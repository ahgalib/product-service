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
    
      
}
