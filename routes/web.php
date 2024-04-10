<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\TempImageController;
use App\Http\Controllers\admin\SubcategoryController;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::group(['prefix'=>'admin'],function(){
    Route::group(['middleware'=>'admin.guest'],function(){
        Route::get('/login',[AdminController::class,'index'])->name('admin.login');
        Route::post('/authenticate',[AdminController::class,'authenticate'])->name('admin.authenticate');
    });
    Route::group(['middleware'=>'admin.auth'],function(){
        Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');
        Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');

        Route::get('/subcategories/{category_id}', [SubcategoryController::class,'getSubcategories'])->name('subcategories.get');

        //categories
        Route::resource('categories', CategoryController::class, [
            'names' => [
                'index' => 'admin.categories',
                'create' => 'admin.categories.create',
                'store' => 'admin.categories.store',
                'edit' => 'admin.categories.edit',
                'update' => 'admin.categories.update',
                'destroy' => 'admin.categories.delete',
                'show' => 'admin.categories.show',
            ]
        ]);
        //subcategory
        Route::resource('subcategories', SubcategoryController::class, [
            'names' => [
                'index' => 'admin.subcategories',
                'create' => 'admin.subcategories.create',
                'store' => 'admin.subcategories.store',
                'edit' => 'admin.subcategories.edit',
                'update' => 'admin.subcategories.update',
                'destroy' => 'admin.subcategories.delete',
                'show' => 'admin.subcategories.show',
            ]
        ]);

        //brand
        Route::resource('brand', BrandController::class, [
            'names' => [
                'index' => 'admin.brand',
                'create' => 'admin.brand.create',
                'store' => 'admin.brand.store',
                'edit' => 'admin.brand.edit',
                'update' => 'admin.brand.update',
                'destroy' => 'admin.brand.delete',
                'show' => 'admin.brand.show',
            ]
        ]);
        
        //product
        Route::resource('product', ProductController::class, [
            'names' => [
                'index' => 'admin.product',
                'create' => 'admin.product.create',
                'store' => 'admin.product.store',
                'edit' => 'admin.product.edit',
                'update' => 'admin.product.update',
                'destroy' => 'admin.product.delete',
                'show' => 'admin.product.show',
            ]
        ]);
        //temp-images.create
        Route::any('/upload-temp-image',[TempImageController::class,'create'])->name('temp-images.create');

        Route::get('/getSlug',function(Request $request)
        { 
            $slug = '';
            if(!empty($request->title))
            {
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getSlug');
    });
});