<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\TempImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest('id')->with('product_images')->paginate();
        return view('admin.product.list',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [];
        $categories = Category::orderBy('name','ASC')->get();
        $brands = Brand::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        return view('admin.product.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // if(!empty($request->track_qty) && $request->track_qty == 'Yes')
        // {
        //     $request['qty'] = 'required|numeric';
        // }
        try{
        $productData = Product::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'price' => $request->price,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'track_qty' => $request->track_qty,
            'qty' => $request->qty,
            'status' => $request->status,
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
            'brand_id' => $request->brand,
            'is_featured' => $request->is_featured
        ]);
        if(!empty($request->image_array))
        {
            foreach($request->image_array as $temp_img_id)
            {
                $tempImageInfo = TempImage::find($temp_img_id);
                $extArray = explode('.',$tempImageInfo->name);
                $ext = last($extArray);

                $productImg = new ProductImage();
                $productImg->product_id =  $productData->id;
                $productImg->image = $tempImageInfo->name;
                $productImg->save();

                // $imageName = $productData->id.'-'.$productImg->id.'-'.time().'.'.$ext;
                // $productImg->image = $imageName;
                // $productImg->save();

                $sourcePath = public_path().'/temp/thumb/'.$tempImageInfo->name;
                $destinationPath = public_path().'/uploads/product/'.$tempImageInfo->name;
                File::move($sourcePath, $destinationPath);
            }   
        }
        return redirect()->route('admin.product')->with('success', 'Product created successfully.');
    }
    catch(Exception $e)
    {
        Session::flash('error', $e->getmessage());
        return redirect()->back();
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!empty($id))
        {
            $products = Product::find($id);
            $data = [];
            $categories = Category::orderBy('name','ASC')->get();
            $brands = Brand::orderBy('name','ASC')->get();
            $data['categories'] = $categories;
            $data['brands'] = $brands;
        }
        
        return view('admin.product.create',compact(['data','products']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
