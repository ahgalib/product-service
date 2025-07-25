<?php

namespace App\Repositories;

use App\Models\ProductTag;

class ProductTagRepository
{
    public function getTagsByProduct($productId)
    {
        return ProductTag::where('product_id', $productId)->get();
    }

    public function createTag($data)
    {
        return ProductTag::create($data);
    }

    public function find($id)
    {
        return ProductTag::find($id);
    }

    public function updateTag($id, $data)
    {
        $tag = $this->find($id);
        if ($tag) {
            $tag->update($data);
        }
        return $tag;
    }

    public function deleteTag($id)
    {
        $tag = $this->find($id);
        if ($tag) {
            $tag->delete();
        }
        return $tag;
    }
}
