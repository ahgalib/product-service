<?php

namespace App\Repositories;

use App\Models\Brand;

class BrandRepository
{
    public function getPaginatedBrands($request)
    {
        return Brand::paginate(10);
    }

    public function createBrand($data)
    {
        return Brand::create($data);
    }

    public function find($id)
    {
        return Brand::find($id);
    }

    public function updateBrand($id, $data)
    {
        $brand = $this->find($id);
        if ($brand) {
            $brand->update($data);
        }
        return $brand;
    }

    public function deleteBrand($id)
    {
        $brand = $this->find($id);
        if ($brand) {
            $brand->delete();
        }
        return $brand;
    }
}
