<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    //register a user
    public function register(RegisterRequest  $request)
    {

        //validation handled by RegisterRequest

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //create access token
        $accessToken =  $user->createToken('authToken')->accessToken;

        return response()->json([
           'user'=> $user,
            'access token' => $accessToken,
        ], 200);

    }

    public function login(LoginRequest  $request){

        //validation handled by LoginRequest

        if(!auth()->attempt($request->validated())){
            return response()->json([
                'message' => 'Invalid Credentials!',
            ]);

        }else{
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            return response()->json([
               'message' => 'Login Successful',
               'user' =>  auth()->user(),
               'access token' => $accessToken,
            ], 200);
        }
    }

    public function profile(){
        //get user id
        $userData = auth()->user()->id;

        if($userData){
            return response()->json([
                'status' => 1,
                'user data' => auth()->user(),
            ], 200);
        }
    }


    public function logout(Request $request){
        $token = $request->user()->token();

        if($token){

            //revoke this token
            $token->revoke();

            return response()->json([
                'status' => 1,
                'message' => 'User Logged out Successful',
            ], 200);

        }
    }
}
