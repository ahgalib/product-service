<?php

namespace App\Services;

use App\Repositories\ProductImageRepository;
use Illuminate\Http\Request;

class ProductImageService
{
    protected $imageRepo;

    public function __construct(ProductImageRepository $imageRepo)
    {
        $this->imageRepo = $imageRepo;
    }

    public function getByProduct($productId)
    {
        return $this->imageRepo->getImagesByProduct($productId);
    }

    public function create($requestData)
    {
        return $this->imageRepo->createImage($requestData);
    }

    public function update($id, $requestData)
    {
        $image = $this->imageRepo->find($id);
        if (!$image) {
            throw new \Exception('Product Image not found');
        }
        $image->update($requestData);
        return $image;
    }

    public function delete($id)
    {
        $image = $this->imageRepo->find($id);
        if (!$image) {
            throw new \Exception('Product Image not found');
        }
        $image->delete();
        return $image;
    }

    public function find($id)
    {
        return $this->imageRepo->find($id);
    }
}
