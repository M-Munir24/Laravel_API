<?php

namespace App\Http\Controllers;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;


class ProductController extends Controller
{
    public function createData(Request $request){

        $validator = validator::make($request->all(),[
                'product_name' => 'required',
                'price' => 'required|numeric',
                'desc_product' => 'required|max: 100'
        ]);
        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

           Product::create([
            'name' => $request->product_name,
            'price' => $request->price,
            'desc' => $request->desc_product
           ]);
           return response()->json([
           'message' => 'success create data'
            ]);
    }

    public function getAllData(){
        $products = Product::all();
        return response()->json([
            'products' => $products
        ]);
    }

    public function getData($id){
        
        $products = Product::findOrFail($id);
        return response()->json($products);
    }

    public function searchData(Request $request){
        $products = Product::where('name', 'LIKE', '%'.$request->product_name.'%')->get();
        return response()->json([
            'productSearch'=>$products
        ]);
    }

    public function updateData(Request $request, $id){

        $validator = validator::make($request->all(),[
            'product_name' => 'required',
            'price' => 'required|numeric',
            'desc_product' => 'required|max: 100'
    ]);
    if($validator->fails()){
        return response()->json([
            'error' => $validator->errors()
        ]);
    }

       Product::findOrFail($id)->update([
        'name' => $request->product_name,
        'price' => $request->price,
        'desc' => $request->desc
        ]);

        return response()->json([
            'message' => 'succes update'
        ]);
    }

    public function deleteData($id){
        Product::destroy($id);
        return response()->json([
            'message' => 'success delete'
        ]);
    }
}
