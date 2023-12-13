<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Tempimage;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index(Request $req){
          $brands = Brand::latest();

        if(!empty($req->get('keyword'))){
             $brands = $categories->where('name','Like','%'.$req->get('keyword').'%');
        }
        $brands = $brands->paginate(5);
        return view('admin.brands.list',compact('brands'));
    }
    public function create(){
        return view('admin.brands.create');
    }
     public function store(Request $req){

          $validate = Validator::make($req->all(),[

            'name' => 'required',
            'status' => 'required',
            'slug' => 'required',
            'slug' => 'required|unique:brands'

        ]);

        if($validate->passes()){

            $brand = new Brand();

            $brand->name = $req->name;
            $brand->slug = $req->slug;

            $brand->status = $req->status;
             $brand->save();



            $req->session()->flash('success','Brand added successfully');

            return response()->json(['status'=>true, 'message','Brand Added.']);

        }else{
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ]);
        }

    }

    public function edit(Request $req, $id){
          if(!empty($id)){

            $brand = Brand::where('id',$id)->first();


            if(empty($brand)){
                    return redirect()->route('brands');
            }else{

            return view('admin.brands.edit',compact('brand'));
            }
        }else{

        }
    }
     public function update(Request $req, $id){

        $brand = Brand::where('id',$id)->first();

          $validate = Validator::make($req->all(),[

            'name' => 'required',
            'status' => 'required',
            'slug' => 'required',
            'slug' => 'required|unique:brands,slug,'.$id.',id'

        ]);

        if($validate->passes()){



            $brand->name = $req->name;
            $brand->slug = $req->slug;

            $brand->status = $req->status;
             $brand->save();



            $req->session()->flash('success','Brand updated successfully');

            return response()->json(['status'=>true, 'message','Brand updated.']);

        }else{
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ]);
        }

    }
        public function delete(Request $req, $id){


        $brand = Brand::where('id',$id)->first();
        if(!empty($brand)){

             $brand->delete();

             $req->session()->flash('success', 'Brand Deleted');
             return response()->json(['status' => true, 'message'=>'Brand deleted successfully']);

        }else{
            return redirect()->route('brands');
        }

    }
}
