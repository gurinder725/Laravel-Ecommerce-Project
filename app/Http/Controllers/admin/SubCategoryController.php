<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Tempimage;
use Illuminate\Support\Facades\File;

class SubCategoryController extends Controller
{
    public function index(Request $req){
          $categories = SubCategory::with('parentCategories')->latest();

        if(!empty($req->get('keyword'))){
             $categories = $categories->where('name','Like','%'.$req->get('keyword').'%');
        }
        $categories = $categories->paginate(5);
        return view('admin.sub_category.list',compact('categories'));
    }

    public function create(){
         $category = Category::where('status',1)->get();
        return view('admin.sub_category.create',compact('category'));
    }
    public function store(Request $req){

          $validate = Validator::make($req->all(),[

            'name' => 'required',
            'status' => 'required',
            'parent_category' => 'required',
            'slug' => 'required|unique:sub_categories'

        ]);

        if($validate->passes()){

            $category = new SubCategory();

            $category->name = $req->name;
            $category->slug = $req->slug;
            $category->category_id = $req->parent_category;
            $category->status = $req->status;
             $category->save();

           /*  if(!empty($req->image_id)){

                $getImg = Tempimage::find($req->image_id);
                $extArray = explode('.',$getImg->name);
                $ext = last($extArray);

                $newImage = "file_" . time() . "_" . uniqid().'.'.$ext;

                $sPath = public_path().'/temp/'.$getImg->name;
                $dPath = \public_path().'/uploads/category/'.$newImage;

                File::copy($sPath,$dPath);

                $category->image = $newImage;
                  $category->save();

            } */


            $req->session()->flash('success','Sub Category added successfully');

            return response()->json(['status'=>true, 'message','Sub Category Added.']);

        }else{
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ]);
        }

    }

    public function edit(Request $req, $id){


        if(!empty($id)){

            $category = SubCategory::with('parentCategories')->where('id',$id)->first();
            $p_category = Category::where('status',1)->get();

            if(empty($category)){
                    return redirect()->route('subcategories');
            }else{

            return view('admin.sub_category.edit',compact('category','p_category'));
            }
        }else{

        }
    }

    public function update(Request $req, $id){

         $category = SubCategory::where('id',$id)->first();

          $validate = Validator::make($req->all(),[

            'name' => 'required',
            'status' => 'required',
            'parent_category' => 'required',
            'slug' => 'required|unique:sub_categories,slug,'.$id.',id'

        ]);

        if($validate->passes()){



            $category->name = $req->name;
            $category->slug = $req->slug;
            $category->category_id = $req->parent_category;
            $category->status = $req->status;
             $category->save();




            $req->session()->flash('success','Sub Category added successfully');

            return response()->json(['status'=>true, 'message','Sub Category Added.']);

        }else{
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ]);
        }

    }
    public function delete(Request $req, $id){


        $category = SubCategory::where('id',$id)->first();
        if(!empty($category)){

             $category->delete();

             $req->session()->flash('success', 'Category Deleted');
             return response()->json(['status' => true, 'message'=>'Category deleted successfully']);

        }else{
            return redirect()->route('subcategories');
        }

    }


}
