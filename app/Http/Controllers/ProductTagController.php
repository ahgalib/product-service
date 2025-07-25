<?php

namespace App\Http\Controllers;

use App\Services\ProductTagService;
use Illuminate\Http\Request;

class ProductTagController extends Controller
{
    protected $tagService;

    public function __construct(ProductTagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index(Request $request)
    {
        $productId = $request->input('product_id');
        return response()->json($this->tagService->getByProduct($productId));
    }

    public function store(Request $request)
    {
        $tag = $this->tagService->create($request->all());
        return response()->json($tag, 201);
    }

    public function show($id)
    {
        $tag = $this->tagService->find($id);
        if (!$tag) {
            return response()->json(['message' => 'Product Tag not found'], 404);
        }
        return response()->json($tag);
    }

    public function update(Request $request, $id)
    {
        $tag = $this->tagService->update($id, $request->all());
        return response()->json($tag);
    }

    public function destroy($id)
    {
        $this->tagService->delete($id);
        return response()->json(null, 204);
    }
}
