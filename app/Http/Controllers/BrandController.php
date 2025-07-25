<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index(Request $request)
    {
        return response()->json($this->brandService->getAll($request));
    }

    public function store(Request $request)
    {
        $brand = $this->brandService->create($request->all());
        return response()->json($brand, 201);
    }

    public function show($id)
    {
        $brand = $this->brandService->find($id);
        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }
        return response()->json($brand);
    }

    public function update(Request $request, $id)
    {
        $brand = $this->brandService->update($id, $request->all());
        return response()->json($brand);
    }

    public function destroy($id)
    {
        $this->brandService->delete($id);
        return response()->json(null, 204);
    }
}
