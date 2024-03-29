<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @var brandRepository
     */
    public $brandRepository;

    /**
     * LotRepository constructor.
     */
    public function __construct()
    {
        $this->brandRepository = new BrandRepository();
    }

    public function index(Request $request)
    {
        try{
            $brands = $this->brandRepository->brandList($request);
            return view('admin.brand.list',compact('brands'));
        }catch(Exception $e)
        {
            Session::flash('error', $e->getmessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        try {
            $this->brandRepository->creatBrand($request);
            return redirect()->route('admin.brand')->with('success', 'Brand created successfully.');
        } catch (Exception $e) {
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
        try{
            $brands = Brand::find($id);
            return view('admin.brand.create',compact('brands'));
        }catch(Exception $e)
        {
            Session::flash('error', $e->getmessage());
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
        try{
            $this->brandRepository->updateBrand($request,$id);
            return redirect()->route('admin.brand')->with('success', 'Brand updated successfully.');
        }catch(Exception $e)
        {
            Session::flash('error', $e->getmessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { 
        try {
            Brand::destroy($id);
            return redirect()->back()->with('success', 'Brand deleted successfully.');
        } catch (Exception $e) {
            Session::flash('error', $e->getmessage());
            return redirect()->back();
        }
    }
}
