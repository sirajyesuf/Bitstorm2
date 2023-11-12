<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index(){

        $categories = Category::paginate();

        return new CategoryCollection($categories);
    
    }

    public function home_categories(){


        $categories = Category::take(2)->get();

        return new CategoryCollection($categories);

    }
}
