<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tempimage;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;

class TempImageController extends Controller
{
   public function index(Request $req){

    $image = $req->image;
    if(!empty($image)){
          $ext = $image->getClientOriginalExtension();
    $name = time().'.'.$ext;

    $tempImage = new Tempimage();
    $tempImage->name = $name;
    $tempImage->save();


   // dd($path);

    $image->move(public_path('temp'),$name);

    return response()->json([
        'status' => true,
        'image_id' => $tempImage->id,
        'image_path' => asset('temp').'/'.$name,
        'message' => 'Image uploaded successfully' ]);

   }
    }

    public function updateStatusCategories(Request $req){

        if(!empty($req->get('id')) & !empty($req->get('status')) || $req->get('status') == 0){

            $category = Category::where('id',$req->get('id'))->first();



      if($category != null){

            if($req->get('status') == 1){

                $category->status = 0;
                $category->save();
                return response()->json(['status'=>true,'message'=>'status updated','update_status'=>0]);


            }else{

                $category->status = 1;
                $category->save();
                 return response()->json(['status'=>true,'message'=>'status updated','update_status'=>1]);
            }
        }else{
             return response()->json(['status'=>false,'message'=>'Something went wrong','is_status' => $req->get('status')]);
        }

        }
    }

    public function updateStatusSubCategories(Request $req){

        if(!empty($req->get('id')) & !empty($req->get('status')) || $req->get('status') == 0){

            $category = SubCategory::where('id',$req->get('id'))->first();



      if($category != null){

            if($req->get('status') == 1){

                $category->status = 0;
                $category->save();
                return response()->json(['status'=>true,'message'=>'status updated','update_status'=>0]);


            }else{

                $category->status = 1;
                $category->save();
                 return response()->json(['status'=>true,'message'=>'status updated','update_status'=>1]);
            }
        }else{
             return response()->json(['status'=>false,'message'=>'Something went wrong','is_status' => $req->get('status')]);
        }

        }
    }

    public function updateStatusBrand(Request $req){

        if(!empty($req->get('id')) & !empty($req->get('status')) || $req->get('status') == 0){

            $brands = Brand::where('id',$req->get('id'))->first();



      if($brands != null){

            if($req->get('status') == 1){

                $brands->status = 0;
                $brands->save();
                return response()->json(['status'=>true,'message'=>'status updated','update_status'=>0]);


            }else{

                $brands->status = 1;
                $brands->save();
                 return response()->json(['status'=>true,'message'=>'status updated','update_status'=>1]);
            }
        }else{
             return response()->json(['status'=>false,'message'=>'Something went wrong','is_status' => $req->get('status')]);
        }

        }
    }

}
