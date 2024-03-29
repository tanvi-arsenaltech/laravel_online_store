<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;

/**
 * Class LotRepository
 * @package App\Repositories
 */
class CategoryRepository
{

    public function categoryList($request)
    {
        $category = Category::latest();
        if (!empty($request->get('keyword'))) {
            $category = $category->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $category = $category->paginate(10);
        return $category;
    }
    public function categoryCreate($request)
    {
        $category = Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'image' => $request->image_id
        ]);
        $this->imageUpload($request, $category);
        return true;
    }

    public function categoryUpdate($request, $id)
    {
        $category = Category::findOrFail($id);
        if (empty($category)) {
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Category not found'
            ]);
        }
        $category->update(
            [
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
                'image' => $request->image_id
            ]
        );
        $this->imageUpload($request, $category);
        return true;
    }

    public function imageUpload($request, $category)
    {
        if (!empty($request->image_id)) {
            $tempImage = TempImage::find($request->image_id);
            if ($tempImage) {
                $ext = pathinfo($tempImage->name, PATHINFO_EXTENSION);
                $newImageName = $request->image_id . '.' . $ext;
                $sourcePath = public_path() . '/temp/' . $tempImage->name;
                $destinationPath = public_path() . '/uploads/category/' . $newImageName;
                File::move($sourcePath, $destinationPath);
                $category->image = $newImageName; // Update the image field in the category
                $category->save();
            } else {
                return response()->json([
                    'message' => 'Image not Uploaded Successfully'
                ]);
            }
        }
    }
}
