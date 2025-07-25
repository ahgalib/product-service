<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getAll(Request $request)
    {
        return $this->productRepo->getPaginatedProducts($request);
    }

    public function create($requestData)
    {
        // Validate and create the product using the repository
        return $this->productRepo->createProduct($requestData);
    }

    public function update($id, $requestData)
    {
        // Find the product by ID and update it
        $product = $this->productRepo->find($id);
        if (!$product) {
            throw new \Exception('Product not found');
        }

        $product->update($requestData);
        return $product;
    }

    
    
      
}
