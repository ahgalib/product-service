<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
use App\Services\ElasticsearchService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        return response()->json(
            $this->productService->getAll($request)
        );
    }

    public function store(ProductRequest $request)
    {
       
        $product = $this->productService->create($request->validated());
        return response()->json($product, 201);
    }

    public function search(Request $request, ElasticsearchService $search)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json(['error' => 'Query required'], 400);
        }

        $results = $search->searchProduct($query);

        return response()->json($results['hits']['hits']);
    }

    public function autocomplete(Request $request, ElasticsearchService $search)
    {
        $request->validate([
            'q' => 'required|string|min:1',
        ]);

        $query = $request->input('q');

        $results = $search->autocomplete($query);

        // Format the response
        $hits = collect($results['hits']['hits'])->map(function ($hit) {
            return [
                'id' => $hit['_source']['id'],
                'name' => $hit['_source']['name'],
            ];
        });

        return response()->json([
            'results' => $hits
        ]);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = $this->productService->update($id, $request->validated());
        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(null, 204);
    }
}
