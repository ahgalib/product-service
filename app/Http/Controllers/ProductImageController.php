<?php

namespace App\Http\Controllers;

use App\Services\ProductImageService;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    protected $imageService;

    public function __construct(ProductImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $productId = $request->input('product_id');
        return response()->json($this->imageService->getByProduct($productId));
    }

    public function store(Request $request)
    {
        $image = $this->imageService->create($request->all());
        return response()->json($image, 201);
    }

    public function show($id)
    {
        $image = $this->imageService->find($id);
        if (!$image) {
            return response()->json(['message' => 'Product Image not found'], 404);
        }
        return response()->json($image);
    }

    public function update(Request $request, $id)
    {
        $image = $this->imageService->update($id, $request->all());
        return response()->json($image);
    }

    public function destroy($id)
    {
        $this->imageService->delete($id);
        return response()->json(null, 204);
    }
}
