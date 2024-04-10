<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Repositories\SubCategoryRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @var SubCategoryRepository
     */
    public $subCategoryRepository;

    /**
     * LotRepository constructor.
     */
    public function __construct()
    {
        $this->subCategoryRepository = new SubCategoryRepository();
    }

    public function index(Request $request)
    {
        try {
            $subCategories = $this->subCategoryRepository->subCategoryList($request);
            return view('admin.subcategory.list', compact(['subCategories']));
        } catch (Exception $e) {
            Session::flash('error', $e->getmessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('admin.subcategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryRequest $request)
    {
        try {
            $this->subCategoryRepository->createSubCategory($request);
            return redirect()->route('admin.subcategories')->with('success', 'SubCategory created successfully.');
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
        try {
            $data = $this->subCategoryRepository->editSubCategory($id);
            $subCategories = $data['subCategories'];
            $categories = $data['categories'];
            return view('admin.subcategory.create', compact(['subCategories', 'categories']));
        } catch (Exception $e) {
            Session::flash('error', $e->getmessage());
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryRequest $request, string $id)
    {
        try {
            $this->subCategoryRepository->updateSubCategory($request, $id);
            return redirect()->route('admin.subcategories')->with('success', 'SubCategory updated successfully.');
        } catch (Exception $e) {
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
            SubCategory::destroy($id);
            return redirect()->back()->with('success', 'SubCategory deleted successfully.');
        } catch (Exception $e) {
            Session::flash('error', $e->getmessage());
            return redirect()->back();
        }
    }

    public function getSubcategories($category_id)
    {
        $subcategories = Subcategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }
}
