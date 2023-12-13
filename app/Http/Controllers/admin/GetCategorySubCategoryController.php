<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\SubCategory;

class GetCategorySubCategoryController extends Controller
{

    public function index(Request $req){

        $id = $req->category_id;
        if(!empty($id)){
            $subCat = SubCategory::where('category_id',$id)->orderBy('name','ASC')->get();

            return response()->json([
                'status' => true,
                'subcategories' => $subCat

            ]);
        }

    }
}
