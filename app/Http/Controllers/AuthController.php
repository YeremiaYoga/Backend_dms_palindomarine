<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    public function login(Request $request){
        $logindata = $request->all();
        $validate = Validator::make($logindata, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validate->fails()){
            return response(['message' => $validate->errors()],400);
        }
        if(!Auth::attempt($logindata)){
            return response(['message' => 'Akun tidak terdaftar'],401);
        }
        $user = Auth::user();
        
        $token = $user->createToken('Authentication Token')->accessToken;
        Log::info('Showing the user profile for user: '.$user);

        return response([
            
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
            
        ]);
    }

}
