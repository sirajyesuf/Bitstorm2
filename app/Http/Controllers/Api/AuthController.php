<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

use Carbon\Carbon;

class AuthController extends Controller
{


    public function signup(Request $request){

        $input = request()->input();

        $validationRuleForEmailOrPhone = (bool) (filter_var($input['email_or_phone'], FILTER_VALIDATE_EMAIL))
        ? ['required', 'string', 'email', 'max:255', Rule::unique(User::class,'email')]
        : ['required', 'string', 'max:255'];


        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            
            'email_or_phone' =>  $validationRuleForEmailOrPhone,
            'password' => 'required',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' =>  (bool) (filter_var($input['email_or_phone'],FILTER_VALIDATE_EMAIL)) ? $input['email_or_phone'] : null,
            'phone' =>  !(bool) (filter_var($input['email_or_phone'],FILTER_VALIDATE_EMAIL)) ? $input['email_or_phone'] : null,
            'password' => Hash::make($input['password']),
        ]);

        return [
            'user_id' => $user->id,
            'result'  => true,
            'message' => 'Registration Successful. Please verify and log in to your account.'
        ];

    }

    public function login(Request $request) {

        $request->validate([

            'email' => ['required'],
            'password' => ['required'],

        ]);


        $user = User::where('email', $request->email)->orWhere('phone',$request->email)->first();
 
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
     
        $token = $user->createToken('access_token',[
            'expires_at' => Carbon::today()->addMonths(5)
        ]);


        $data = [

            'result' => true,
            'message' => 'Successfully logged in.',
            'access_token' =>  $token->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => null,
            'user'  =>  new UserResource($user)
        ];



        return  response()->json($data);

        

    }

}
