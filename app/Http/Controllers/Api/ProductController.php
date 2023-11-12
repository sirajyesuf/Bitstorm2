<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use App\Models\Alert;

class ProductController extends Controller
{

    public function featured(){

        return new ProductCollection(Product::where('is_featured',true)->paginate());
    
    }

    public function search(Request $request){

        $query = Product::query();

        // Add a condition for the required 'name' field
        $query->where('title', 'like', '%' . $request->input('name') . '%');
    
        // Optional parameters: min, max, and sort_by
        $query->when($request->has('min'), function ($query) use ($request) {
            return $query->where('price', '>=', $request->input('min'));
        });
    
        $query->when($request->has('max'), function ($query) use ($request) {
            return $query->where('price', '<=', $request->input('max'));
        });
    
        $query->when($request->has('sort_by'), function ($query) use ($request) {
            return $query->orderBy($request->input('sort_by'));
        });
    
      
        return new ProductCollection($query->paginate());
    }

    public function category($id){

        return new ProductCollection(Product::where('category_id',$id)->paginate());
    }


    public function alert(Request $request){


        // $user_id = $request->input('user_id');

        $request->validate([

            'product_id' => 'required',

        ]);
    
        $product_id = $request->input('product_id');
    
        Alert::create([
            'user_id' => request()->user()->id,
            'product_id' => $product_id
        ]);
    
        return [

            'success' => 200,
            'message' => 'done'
        ];

    }
}
