<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\adminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\GetCategorySubCategoryController;
use App\Http\Controllers\TempImageController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' =>'admin'],function(){

Route::group(['middleware' => 'admin.guest'],function () {
    Route::get('/login',[adminLoginController::class,'index'])->name('admin.login');
    Route::post('/auth',[adminLoginController::class,'auth'])->name('admin.auth');

});
Route::group(['middleware' => 'admin.auth'],function () {
    Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');
     Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');

     //category routes
       Route::get('/categories',[CategoryController::class,'index'])->name('categories');
       Route::get('/categories/create',[CategoryController::class,'create'])->name('categories.create');

       Route::post ('/categories/store',[CategoryController::class,'store'])->name('categories.store');
       Route::get('/categories/edit/{id}',[CategoryController::class,'edit'])->name('categories.edit');
       Route::post('/categories/update/{id}',[CategoryController::class,'update'])->name('categories.update');
       Route::get('/categories/delete/{id}',[CategoryController::class,'delete'])->name('categories.delete');


            // Sub category routes
       Route::get('/sub-categories',[SubCategoryController::class,'index'])->name('subcategories');
       Route::get('/sub-categories/create',[SubCategoryController::class,'create'])->name('subcategories.create');

       Route::post ('/sub-categories/store',[SubCategoryController::class,'store'])->name('subcategories.store');
       Route::get('/sub-categories/edit/{id}',[SubCategoryController::class,'edit'])->name('subcategories.edit');
       Route::post('/sub-categories/update/{id}',[SubCategoryController::class,'update'])->name('subcategories.update');
       Route::get('/sub-categories/delete/{id}',[SubCategoryController::class,'delete'])->name('subcategories.delete');



     //Brands routes
       Route::get('/brands',[BrandController::class,'index'])->name('brands');
       Route::get('/brands/create',[BrandController::class,'create'])->name('brands.create');

       Route::post ('/brands/store',[BrandController::class,'store'])->name('brands.store');
       Route::get('/brands/edit/{id}',[BrandController::class,'edit'])->name('brands.edit');
       Route::post('/brands/update/{id}',[BrandController::class,'update'])->name('brands.update');
       Route::get('/brands/delete/{id}',[BrandController::class,'delete'])->name('brands.delete');


       //Product routes
       Route::get('/products',[ProductController::class,'index'])->name('products');
       Route::get('/product/create',[ProductController::class,'create'])->name('products.create');

       Route::post ('/product/store',[ProductController::class,'store'])->name('products.store');
       Route::get('/product/edit/{id}',[ProductController::class,'edit'])->name('products.edit');
       Route::post('/product/update/{id}',[ProductController::class,'update'])->name('products.update');
       Route::get('/product/delete/{id}',[ProductController::class,'delete'])->name('products.delete');



       //get slug

       Route::get('/getSlug',function(Request $req){

            $slug = '';
            if(!empty($req->title)){
                $slug = Str::slug($req->title);
            }
            return response()->json(['status' => 'true', 'slug'=> $slug]);
       })->name('getSlug');

       //temp image route
         Route::post('/temp-images',[TempImageController::class,'index'])->name('temp-images.create');

         //get sub category ajax

         Route::get('get-subcategory',[GetCategorySubCategoryController::class,'index'])->name('GetCategorySubCategory');

         //update status active or inactive

         Route::get('update-status-categories',[TempImageController::class,'updateStatusCategories'])->name('updateStatus');
          Route::get('update-status-sub-categories',[TempImageController::class,'updateStatusSubCategories'])->name('updateStatusSubCat');
        Route::get('update-status-brand',[TempImageController::class,'updateStatusBrand'])->name('updateStatusBrands');

});



});
