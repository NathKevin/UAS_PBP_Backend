<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //use tambahan
use App\Models\User; //import model user
use Validator; // import library validasi

class AuthController extends Controller
{
    public function register(Request $request){
        $registrationData = $request->all();
        $validate = Validator::make($registrationData,[
            'name' => 'required|max:60',
            'noTelp' => 'required|digits_between:10,13',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required'
        ]); // membuat rule validasi input register

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error validasi input 
        
        $registrationData['password'] = bcrypt($request->password); //enkripsi password
        $user = User::create($registrationData); // membuat user baru
        return response([
            'message' => 'Register Success',
            'user' => $user
        ], 200); //return data user dalam bentuk json
    }

    public function login(Request $request){
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]); //membuat rule validasi input login

        if($validate->fails())
            return response(['message' => $validate->errors()],400); // return error validasi
        
        if(!Auth::attempt($loginData))
            return response(['message' => 'Invalid Credentials'],401); // return gagal login

        $user = Auth::user();
        $token = $user->createToken('Authentication Token')->accessToken; //generate token

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]); // return data user dan token dalam bentuk json
    }
}