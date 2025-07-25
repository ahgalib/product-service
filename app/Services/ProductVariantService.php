<?php

namespace App\Services;

use App\Repositories\ProductVariantRepository;
use Illuminate\Http\Request;

class ProductVariantService
{
    protected $variantRepo;

    public function __construct(ProductVariantRepository $variantRepo)
    {
        $this->variantRepo = $variantRepo;
    }

    public function getAll(Request $request)
    {
        return $this->variantRepo->getPaginatedVariants($request);
    }

    public function create($requestData)
    {
        return $this->variantRepo->createVariant($requestData);
    }

    public function update($id, $requestData)
    {
        $variant = $this->variantRepo->find($id);
        if (!$variant) {
            throw new \Exception('Product Variant not found');
        }
        $variant->update($requestData);
        return $variant;
    }

    public function delete($id)
    {
        $variant = $this->variantRepo->find($id);
        if (!$variant) {
            throw new \Exception('Product Variant not found');
        }
        $variant->delete();
        return $variant;
    }

    public function find($id)
    {
        return $this->variantRepo->find($id);
    }

    public function adjustStock($id, $quantity)
    {
        return $this->variantRepo->adjustStock($id, $quantity);
    }
}
