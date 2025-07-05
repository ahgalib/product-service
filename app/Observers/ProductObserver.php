<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\ElasticsearchService;

class ProductObserver
{
    public function saved(Product $product)
    {
        app(ElasticsearchService::class)->indexProduct($product);
    }

    public function deleted(Product $product)
    {
        app(ElasticsearchService::class)->deleteProduct($product->id);
    }
}
