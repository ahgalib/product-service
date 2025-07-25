<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        return response()->json($this->categoryService->getAll($request));
    }

    public function store(Request $request)
    {
        $category = $this->categoryService->create($request->all());
        return response()->json($category, 201);
    }

    public function show($id)
    {
        $category = $this->categoryService->find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = $this->categoryService->update($id, $request->all());
        return response()->json($category);
    }

    public function destroy($id)
    {
        $this->categoryService->delete($id);
        return response()->json(null, 204);
    }
}
