<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    public function update_name(Request $request){

        $request->user()->update(['name' => $request->input('name')]);

        return response()->json(['message' => "Profile information has been updated successfully"]);
        
    }


    public function update_password(Request $request){

        $request->user()->update(['password' => $request->input('password')]);

        return response()->json(['message' => "Profile information has been updated successfully"]);

    }


    public function update_phone(Request $request){


        $request->user()->update(['phone' => $request->input('phone')]);
        
        return response()->json(['message' => "Profile information has been updated successfully"]);

    }


    public function update_avatar(Request $request){

        $validator = Validator::make($request->all(),[ 

                'image' => 'required|image',
        ]);   
        
        if($validator->fails()) {          
            
            return response()->json(['error'=>$validator->errors()], 422);                        
        } 

        $path = $request->file('image')->store();

        $request->user()->update(['avatar' => $path ]);

        return response()->json(['message' => "Profile information has been updated successfully"]);

    }

    public function show(){

        return new UserResource(request()->user());
 
    }
}
