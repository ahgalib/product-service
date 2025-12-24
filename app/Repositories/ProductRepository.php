<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductRepository
{
    public function getPaginatedProducts(Request $request)
    {
       
        $cacheKey = $this->buildCacheKey($request->all());

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
            $query = Product::with(['category:id,name,slug', 'sub_category:id,category_id,name,slug', 'brand:id,name,slug'])->where('is_active', 1);

            // Filter by name
            if ($request->search) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
                // dd($query->toSql(), $query->getBindings());
            }

            if ($request->category) {
                $categoryName = $request->category;
                $query->whereHas('category', function ($q) use ($categoryName) {
                    $q->where('name', 'LIKE', '%' . $categoryName . '%');
                });
            }
            if ($request->sub_category) {
                $categoryName = $request->sub_category;
                $query->whereHas('sub_category', function ($q) use ($categoryName) {
                    $q->where('name', 'LIKE', '%' . $categoryName . '%');
                });
            }
            if ($request->brand) {
                $categoryName = $request->brand;
                $query->whereHas('brand', function ($q) use ($categoryName) {
                    $q->where('name', 'LIKE', '%' . $categoryName . '%');
                });
            }
            // Filter by price range
            if ($request->min_price) {
                $query->where('price', '>=', $request->min_price);
            }
            if ($request->max_price) {
                $query->where('price', '<=', $request->max_price);
            }

            // Sorting
            if ($request->sort_by) {
                $query->orderBy($request->sort_by, $request->get('sort_dir', 'asc'));
            }

            return $query->select(['id','name','slug','description', 'category_id','sub_category_id','brand_id','price','discount','stock_quantity','is_active'])->paginate($request->get('per_page', 40));
        });

        // return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
        //     $products = Product::where('is_active', 1)
        //         ->select(['id', 'name', 'slug', 'description', 'category_id', 'sub_category_id', 'brand_id', 'price', 'discount', 'stock_quantity', 'is_active'])
        //         ->paginate($request->get('per_page', 20));

        //     $categoryIds = $products->pluck('category_id')->unique();
        //     $subCategoryIds = $products->pluck('sub_category_id')->unique();
        //     $brandIds = $products->pluck('brand_id')->unique();

        //     $categories = Category::whereIn('id', $categoryIds)->get(['id', 'name', 'slug'])->keyBy('id');
        //     $subCategories = SubCategory::whereIn('id', $subCategoryIds)->get(['id', 'category_id', 'name', 'slug'])->keyBy('id');
        //     $brands = Brand::whereIn('id', $brandIds)->get(['id', 'name', 'slug'])->keyBy('id');



        //     $products->getCollection()->transform(function ($product) use ($categories, $subCategories, $brands) {
        //         $product->category = $categories[$product->category_id] ?? null;
        //         $product->sub_category = $subCategories[$product->sub_category_id] ?? null;
        //         $product->brand = $brands[$product->brand_id] ?? null;
        //         return $product;
        //     });
        // });
    }

    private function buildCacheKey($request)
    {   
        
        return 'products_' . md5(json_encode($request));
       
    }

    public function findBySlug(string $slug)
    {
        $ttl = now()->addMinutes(10);
        $product = Cache::remember("product:slug:{$slug}", $ttl, function () use ($slug) {
            return Product::with(['category', 'sub_category', 'brand', 'product_variants', 'product_tags', 'product_images'])
                ->where('slug', $slug)
                ->first();
        });
        

        if (! $product) {
            return null;
        }

        $relatedKey = "product:{$product->id}:related:v1:limit:10";

        $related = Cache::remember($relatedKey, $ttl, function () use ($product) {
            return $this->relatedProducts($product, 10);
        });

        return [
            'product' => $product,
            'related_products' => $related,
        ];
    }

    protected function relatedProducts(Product $product, int $limit = 10)
    {
        $base = Product::query()
            ->where('is_active', 1)
            ->whereKeyNot($product->id);

        // Change the order of the tiers to match exactly how you want to relax conditions.
        $tiers = [
            // exact match (cat + subcat + brand)
            [
                'category_id'     => $product->category_id,
                'sub_category_id' => $product->sub_category_id,
                'brand_id'        => $product->brand_id,
            ],
            // category + subcategory
            [
                'category_id'     => $product->category_id,
                'sub_category_id' => $product->sub_category_id,
            ],
           
            // brand only
            [
                'brand_id'        => $product->brand_id,
            ],
            // subcategory only
            [
                'sub_category_id' => $product->sub_category_id,
            ],
            // category only
            [
                'category_id'     => $product->category_id,
            ],
            // anything active
            [],
        ];

        $result = collect();

        foreach ($tiers as $filters) {
            if ($result->count() >= $limit) {
                break;
            }

            $q = (clone $base);

            foreach ($filters as $col => $val) {
    
                $q->where($col, $val);
            }

            $toTake = $limit - $result->count();

            $result = $result->merge(
                $q->limit($toTake)
                    ->inRandomOrder()   // or ->orderByDesc('popularity') / 'views' / 'sold_count'
                    ->get(['id', 'name', 'slug', 'description','price', 'discount','stock_quantity', 'brand_id', 'category_id', 'sub_category_id'])
            );
        }

        return $result->unique('id')->take($limit)->values();
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

    public function find($id)
    {
        return Product::find($id);
    }
}
