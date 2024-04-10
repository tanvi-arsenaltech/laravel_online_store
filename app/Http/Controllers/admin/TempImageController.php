<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TempImageController extends Controller
{
    public function create(Request $request)
    {
        $image =$request->image;
        if(!empty($image))
        {
            $ext = $image->getClientOriginalExtension();
            $newName = time().'.'.$ext;
            $tempImage = new TempImage();
            $tempImage->name = $newName;
            $tempImage->save();

            $image->move(public_path().'/temp',$newName);

            $sourcePath = public_path() . '/temp/' . $newName;
            $destinationPath = public_path() . '/temp/thumb/' . $newName;
            File::move($sourcePath, $destinationPath);

            return response()->json([
                'status' => true,
                'image_id'=>$tempImage->id,
                'ImagePath' =>asset('/temp/thumb/'.$newName),
                'message' => 'Image Uploaded Successfully'
            ]);
        }
    }
}
