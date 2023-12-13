<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tempimage;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
{

    public function index(Request $req){
         $products = Product::with('categories')
         ->with('subCategories')
         ->with('brands')
         ->with('g_images')->latest();

        if(!empty($req->get('keyword'))){
             $products = $products->where('title','Like','%'.$req->get('keyword').'%');
        }
        $products = $products->paginate(5);

      //dd($products);

        return view('admin.product.list',compact('products'));
    }
    public function create(){
        $categories = Category::where('status',1)->orderBy('name','ASC')->get();
         $brands = Brand::where('status',1)->orderBy('name','ASC')->get();
        return view('admin.product.create',compact('categories','brands'));
    }
    public function store(Request $req){
       // dd($req->image_id);
            $rules = [
                'title' => 'required',
                'slug' => 'required|unique:products',
                'price' => 'required|numeric',
                'sku' => 'required|unique:products',
                'track_qty' => 'required|in:Yes,No',
                'category' => 'required|numeric',
                'is_featured' => 'required|in:Yes,No',
            ];
            if(!empty($req->track_qty && $req->track_qty == 'Yes')){
                $rules['qty'] = 'required|numeric';
            }
            $validator = Validator::make($req->all(),$rules);

            if($validator->passes()){
                $product = new Product;

                $product->title = $req->title;
                $product->slug = $req->slug;
                $product->description = $req->description;
                $product->price = $req->price;
                $product->compare_price = $req->compare_price;
                $product->sku = $req->sku;
                $product->barcode = $req->barcode;
                $product->track_qty = $req->track_qty;
                $product->qty = $req->qty;
                $product->status = $req->status;
                $product->is_featured = $req->is_featured;
                $product->category_id = $req->category;
                $product->sub_category_id = $req->sub_category;
                $product->brand_id = $req->brand;
                $product->save();

                //save gallery images

                if(!empty($req->image_id)){
                    foreach($req->image_id as $imgId){

                        $tmpimage = Tempimage::find($imgId);
                        $img_array = explode('.',$tmpimage->name);
                        $img_ext = end($img_array);

                        $image = new ProductImage;
                        $image->image = $tmpimage->name;
                        $image->product_id = $product->id;
                        $image->save();

                      //  $imgname = $product->id.'-'.$image->id.'-'.time().'-'.$img_ext;

                        //$image->image = $imgname;
                       // $image->save();

                    }
                }

                $req->session()->flash('success','Product Added Successfully');
                return response()->json([
                    'status' => true,
                    'message' => 'Product Added Successfully',
                ]);

            }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }
    }
      public function edit(Request $req, $id){
          $product = Product::find($id);
          if(empty($product)){
        return redirect()->route('products')->with('error','Product Not Found');
      }
        if(!empty($id)){
            $categories = Category::where('status',1)->orderBy('name','ASC')->get();
         $brands = Brand::where('status',1)->orderBy('name','ASC')->get();
          $products = Product::with('categories')
         ->with('subCategories')
         ->with('brands')
         ->with('g_images')->where('id',$id)->first();



      dd($products);

        return view('admin.product.edit',compact('products','categories','brands'));
    }
}
  public function update(Request $req, $id){

      $product = Product::find($id);


       //dd($product->id);
            $rules = [
                'title' => 'required',
                'slug' => 'required|unique:products,slug,'.$product->id.',id',
                'price' => 'required|numeric',
                'sku' => 'required|unique:products,sku,'.$product->id.',id',
                'track_qty' => 'required|in:Yes,No',
                'category' => 'required|numeric',
                'is_featured' => 'required|in:Yes,No',
            ];
            if(!empty($req->track_qty && $req->track_qty == 'Yes')){
                $rules['qty'] = 'required|numeric';
            }
            $validator = Validator::make($req->all(),$rules);

            if($validator->passes()){
                $product = new Product;

                $product->title = $req->title;
                $product->slug = $req->slug;
                $product->description = $req->description;
                $product->price = $req->price;
                $product->compare_price = $req->compare_price;
                $product->sku = $req->sku;
                $product->barcode = $req->barcode;
                $product->track_qty = $req->track_qty;
                $product->qty = $req->qty;
                $product->status = $req->status;
                $product->is_featured = $req->is_featured;
                $product->category_id = $req->category;
                $product->sub_category_id = $req->sub_category;
                $product->brand_id = $req->brand;
                $product->save();

                //save gallery images

                if(!empty($req->image_id)){
                    foreach($req->image_id as $imgId){

                        $tmpimage = Tempimage::find($imgId);
                        $img_array = explode('.',$tmpimage->name);
                        $img_ext = end($img_array);

                        $image = new ProductImage;
                        $image->image = $tmpimage->name;
                        $image->product_id = $product->id;
                        $image->save();

                      //  $imgname = $product->id.'-'.$image->id.'-'.time().'-'.$img_ext;

                        //$image->image = $imgname;
                       // $image->save();

                    }
                }

                $req->session()->flash('success','Product Updated Successfully');
                return response()->json([
                    'status' => true,
                    'message' => 'Product Updated Successfully',
                ]);

            }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }
    }

public function delete(Request $req, $id){


        $category = Product::where('id',$id)->get();
        if(!empty($category)){
             $oldimage = $category->image;
             File::delete(public_path().'/uploads/category/'.$oldimage);

             $category->delete();

             $req->session()->flash('success', 'Category Deleted');
             return response()->json(['status' => true, 'message'=>'Category deleted successfully']);

        }else{
            return redirect()->route('categories');
        }

    }
}
