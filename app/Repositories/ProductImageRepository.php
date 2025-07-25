<?php

namespace App\Repositories;

use App\Models\ProductImage;

class ProductImageRepository
{
    public function getImagesByProduct($productId)
    {
        return ProductImage::where('product_id', $productId)->get();
    }

    public function createImage($data)
    {
        return ProductImage::create($data);
    }

    public function find($id)
    {
        return ProductImage::find($id);
    }

    public function updateImage($id, $data)
    {
        $image = $this->find($id);
        if ($image) {
            $image->update($data);
        }
        return $image;
    }

    public function deleteImage($id)
    {
        $image = $this->find($id);
        if ($image) {
            $image->delete();
        }
        return $image;
    }
}
