<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\File;

/**
 * Class LotRepository
 * @package App\Repositories
 */
class SubCategoryRepository
{

    public function subCategoryList($request)
    {
        $subCategories = SubCategory::with('category')->latest();
            if (!empty($request->get('keyword'))) {
                $subCategories = $subCategories->where('name', 'like', '%' . $request->get('keyword') . '%');
            }
            $subCategories = $subCategories->paginate(10);
        return $subCategories;
    }
    public function createSubCategory($request)
    {
        SubCategory::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'category_id' =>$request->category,
            'status' => $request->status
          ]);
        return true;
    }
  public function editSubCategory($id)
    {
        $data['subCategories'] = SubCategory::with('category')->find($id);
        $data['categories'] = Category::orderBy('name','ASC')->get();
        return $data;
    }

    public function updateSubCategory($request, $id)
    {
        $subCategories = SubCategory::findOrFail($id);
        if (empty($subCategories)) {
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'SubCategory not found'
            ]);
        }
        $subCategories->update(
            [
                'name' => $request->name,
                'category_id' => $request->category,
                'slug' => $request->slug,
                'status' => $request->status,
            ]
        );
        return true;
    }
}
