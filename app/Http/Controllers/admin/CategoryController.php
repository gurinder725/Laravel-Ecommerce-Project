<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Tempimage;
use Illuminate\Support\Facades\File;


class CategoryController extends Controller
{
    public function index(Request $req){

        $categories = Category::latest();
        if(!empty($req->get('keyword'))){
             $categories = $categories->where('name','Like','%'.$req->get('keyword').'%');
        }
        $categories = $categories->paginate(5);
        return view('admin.category.list',compact('categories'));

    }

     public function create(){

        return view('admin.category.create');

    }

     public function store(Request $req){

        $validate = Validator::make($req->all(),[

            'name' => 'required',
            'slug' => 'required|unique:categories'

        ]);

        if($validate->passes()){

            $category = new Category();

            $category->name = $req->name;
            $category->slug = $req->slug;

            $category->status = $req->status;

            if(!empty($req->image_id)){

                $getImg = Tempimage::find($req->image_id);
                $extArray = explode('.',$getImg->name);
                $ext = last($extArray);

                $newImage = "file_" . time() . "_" . uniqid().'.'.$ext;

                $sPath = public_path().'/temp/'.$getImg->name;
                $dPath = \public_path().'/uploads/category/'.$newImage;

                File::copy($sPath,$dPath);

                $category->image = $newImage;
                  $category->save();

            }


            $req->session()->flash('success','Category added successfully');

            return response()->json(['message','Category Added.']);

        }else{
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ]);
        }

    }
 public function edit(Request $req, $id){


        if(!empty($id)){

            $category = Category::where('id',$id)->first();

            if(empty($category)){
 return redirect()->route('categories');
            }else{

            return view('admin.category.edit',compact('category'));
            }
        }else{

        }

    }
     public function update(Request $req, $id){

        $category = Category::where('id',$id)->first();

        $validate = Validator::make($req->all(),[

            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$id.',id'

        ]);

        if($validate->passes()){



            $category->name = $req->name;
            $category->slug = $req->slug;

            $category->status = $req->status;

            $oldimage = $category->image;
           // dd($oldimage);

            if(!empty($req->image_id)){

                $getImg = Tempimage::find($req->image_id);
                $extArray = explode('.',$getImg->name);
                $ext = last($extArray);

                $newImage = "file_" . time() . "_" . uniqid().'.'.$ext;

                $sPath = public_path().'/temp/'.$getImg->name;
                $dPath = \public_path().'/uploads/category/'.$newImage;

                File::copy($sPath,$dPath);

                $category->image = $newImage;
                  $category->save();

                  //delete old image
                    $del_img_path = public_path().'uploads/category/'.$oldimage;

                  File::delete(public_path().'/uploads/category/'.$oldimage);

            }

              $category->save();


            $req->session()->flash('success','Category Updated successfully');

            return response()->json(['status'=> true,'message','Category Updated.']);

        }else{
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ]);
        }

    }

     public function delete(Request $req, $id){


        $category = Category::where('id',$id)->first();
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
