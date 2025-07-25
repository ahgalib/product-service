<?php

namespace App\Services;

use App\Repositories\ProductTagRepository;
use Illuminate\Http\Request;

class ProductTagService
{
    protected $tagRepo;

    public function __construct(ProductTagRepository $tagRepo)
    {
        $this->tagRepo = $tagRepo;
    }

    public function getByProduct($productId)
    {
        return $this->tagRepo->getTagsByProduct($productId);
    }

    public function create($requestData)
    {
        return $this->tagRepo->createTag($requestData);
    }

    public function update($id, $requestData)
    {
        $tag = $this->tagRepo->find($id);
        if (!$tag) {
            throw new \Exception('Product Tag not found');
        }
        $tag->update($requestData);
        return $tag;
    }

    public function delete($id)
    {
        $tag = $this->tagRepo->find($id);
        if (!$tag) {
            throw new \Exception('Product Tag not found');
        }
        $tag->delete();
        return $tag;
    }

    public function find($id)
    {
        return $this->tagRepo->find($id);
    }
}
