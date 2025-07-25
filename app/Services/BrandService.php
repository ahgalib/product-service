<?php

namespace App\Services;

use App\Repositories\BrandRepository;
use Illuminate\Http\Request;

class BrandService
{
    protected $brandRepo;

    public function __construct(BrandRepository $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    public function getAll(Request $request)
    {
        return $this->brandRepo->getPaginatedBrands($request);
    }

    public function create($requestData)
    {
        return $this->brandRepo->createBrand($requestData);
    }

    public function update($id, $requestData)
    {
        $brand = $this->brandRepo->find($id);
        if (!$brand) {
            throw new \Exception('Brand not found');
        }
        $brand->update($requestData);
        return $brand;
    }

    public function delete($id)
    {
        $brand = $this->brandRepo->find($id);
        if (!$brand) {
            throw new \Exception('Brand not found');
        }
        $brand->delete();
        return $brand;
    }

    public function find($id)
    {
        return $this->brandRepo->find($id);
    }
}
