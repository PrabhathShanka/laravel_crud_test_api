<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    // Register API - name,email,password,password_confirmation
    public function register(Request $request){

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        User::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully created user!']);
    }

    //Login api
    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //user check in email

        $user = User::where('email', $request->email)->first();

        if(!empty($user)){

            //password check
            if(Hash::check($request->password, $user->password)){

                $token = $user->createToken('myToken')->plainTextToken;

                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully login!',
                    'token' => $token
                ]);
            }else{
                return response()->json([
                    'status' => 'false',
                    'message' => 'password didnt match!',
                ]);
            }
        }else{
            return response()->json([
                'status' => 'false',
                'message' => 'Email is invalid!',
            ]);
        }
    }

    //profile api
    public function profile(){

        $userData = auth()->user();

        return response()->json([
            'status' => 'true',
            'message' => 'Profile data',
            'data' => $userData,
            'id' => auth()->user()->id
        ]);

    }

    //logout api
    public function logout(){

        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 'true',
            'message' => 'Successfully logout!',
        ]);

    }

}
