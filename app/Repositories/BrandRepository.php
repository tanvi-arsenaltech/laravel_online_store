<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\File;

/**
 * Class LotRepository
 * @package App\Repositories
 */
class BrandRepository
{

    public function brandList($request)
    {
        $brands = Brand::latest();
            if (!empty($request->get('keyword'))) {
                $brands = $brands->where('name', 'like', '%' . $request->get('keyword') . '%');
            }
            $brands = $brands->paginate(10);
        return $brands;
    }
    public function creatBrand($request)
    {
        return Brand::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status
          ]);
    }
    public function updateBrand($request, $id)
    {
        $brands = Brand::findOrFail($id);
        if (empty($brands)) {
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Brand not found'
            ]);
        }
       return $brands->update(
            [
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
            ]
        );
    }
}
