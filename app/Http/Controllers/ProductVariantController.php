<?php

namespace App\Http\Controllers;

use App\Services\ProductVariantService;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    protected $variantService;

    public function __construct(ProductVariantService $variantService)
    {
        $this->variantService = $variantService;
    }

    public function index(Request $request)
    {
        return response()->json($this->variantService->getAll($request));
    }

    public function store(Request $request)
    {
        $variant = $this->variantService->create($request->all());
        return response()->json($variant, 201);
    }

    public function show($id)
    {
        $variant = $this->variantService->find($id);
        if (!$variant) {
            return response()->json(['message' => 'Product Variant not found'], 404);
        }
        return response()->json($variant);
    }

    public function update(Request $request, $id)
    {
        $variant = $this->variantService->update($id, $request->all());
        return response()->json($variant);
    }

    public function destroy($id)
    {
        $this->variantService->delete($id);
        return response()->json(null, 204);
    }

    public function adjustStock(Request $request, $id)
    {
        $quantity = $request->input('quantity');
        $variant = $this->variantService->adjustStock($id, $quantity);
        return response()->json($variant);
    }
}
