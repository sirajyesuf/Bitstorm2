<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Models\Alert;
use App\Http\Controllers\Api\BrandController;




//registration and login
Route::prefix('v2/auth')->group(function(){
    
    Route::post('signup',[AuthController::class,'signup']);
    Route::post('login',[AuthController::class,'login']);

});


Route::middleware('auth:sanctum')->group(function(){


    Route::post('v2/auth/logout',[AuthController::class,'logout']);

    Route::get('v2/notifications/list',function(Request $req){

        return response()->json(["notifications" => $req->user()->notifications]);

    });

    Route::post('v1/notified-product',[ProductController::class,'alert']);

    Route::prefix('v2')->group(function () {

        Route::name('products.')->prefix('products')->group(function(){
    
            Route::get('category/{id}',[ProductController::class,'category'])->name('category');
            Route::get('featured',[ProductController::class,'featured']);
            Route::post('search',[ProductController::class,'search']);
            Route::get('brand/{id}',[ProductController::class,'brand'])->name('brand');

        
        });
        
        Route::get('home-categories',[CategoryController::class,'home_categories']);
        Route::get('categories',[CategoryController::class,'index']);


        Route::get('/brands',[BrandController::class,'index']);
    
    });



    Route::prefix('v1/user/info')->group(function(){
        Route::post('updateName',[ProfileController::class,'update_name']);
        Route::post('updatePhone',[ProfileController::class,'update_phone']);
        Route::post('updatePassword',[ProfileController::class,'update_password']);
        Route::post('updateAvatar',[ProfileController::class,'update_avatar']);
        Route::get('{user_id}',[ProfileController::class,'show']);

        Route::post('setfcmtoken',[ProfileController::class,'setfcm_token']);
    });



    


});












