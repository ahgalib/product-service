<?php

namespace App\Http\Controllers;

use App\Services\SubCategoryService;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    protected $subCategoryService;

    public function __construct(SubCategoryService $subCategoryService)
    {
        $this->subCategoryService = $subCategoryService;
    }

    public function index(Request $request)
    {
        return response()->json($this->subCategoryService->getAll($request));
    }

    public function store(Request $request)
    {
        $subCategory = $this->subCategoryService->create($request->all());
        return response()->json($subCategory, 201);
    }

    public function show($id)
    {
        $subCategory = $this->subCategoryService->find($id);
        if (!$subCategory) {
            return response()->json(['message' => 'SubCategory not found'], 404);
        }
        return response()->json($subCategory);
    }

    public function update(Request $request, $id)
    {
        $subCategory = $this->subCategoryService->update($id, $request->all());
        return response()->json($subCategory);
    }

    public function destroy($id)
    {
        $this->subCategoryService->delete($id);
        return response()->json(null, 204);
    }
}
