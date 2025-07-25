<?php

namespace App\Repositories;

use App\Models\ProductVariant;

class ProductVariantRepository
{
    public function getPaginatedVariants($request)
    {
        return ProductVariant::paginate(10);
    }

    public function createVariant($data)
    {
        return ProductVariant::create($data);
    }

    public function find($id)
    {
        return ProductVariant::find($id);
    }

    public function updateVariant($id, $data)
    {
        $variant = $this->find($id);
        if ($variant) {
            $variant->update($data);
        }
        return $variant;
    }

    public function deleteVariant($id)
    {
        $variant = $this->find($id);
        if ($variant) {
            $variant->delete();
        }
        return $variant;
    }

    public function adjustStock($id, $quantity)
    {
        $variant = $this->find($id);
        if ($variant) {
            $variant->stock += $quantity;
            $variant->save();
        }
        return $variant;
    }
}
