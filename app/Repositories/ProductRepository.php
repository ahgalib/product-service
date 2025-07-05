<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductRepository
{
    public function getPaginatedProducts(Request $request)
    {
        $cacheKey = $this->buildCacheKey($request);

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
            $query = Product::with(['category', 'brand']);

            // Filter by name
            if ($request->filled('name')) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            }

            // Filter by price range
            if ($request->filled('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            if ($request->filled('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            // Sorting
            if ($request->filled('sort_by')) {
                $query->orderBy($request->sort_by, $request->get('sort_dir', 'asc'));
            }

            return $query->paginate($request->get('per_page', 20));
        });
    }

    private function buildCacheKey(Request $request)
    {   
        
        return 'products_' . md5(json_encode($request->page));
       
    }

    public function createProduct($request)
    {
        return Product::create([
            'name' => $request['name'],
            'slug' => $request['slug'] ?? Str::slug($request['name']),
            'description' => $request['description'],
            'price' => $request['price'],
            'category_id' => $request['category_id'],
            'sub_category_id' => 3,
            'brand_id' => $request['brand_id'],
            'is_active' => 1,
        ]);
    }
}
