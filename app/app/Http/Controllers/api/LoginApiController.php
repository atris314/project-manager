<?php

namespace App\Http\Controllers\api;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginApiController extends Controller
{
    public function register(LoginRequest $request)
    {
        $user = User::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'password'=>bcrypt($request['password']),
            'role'=>UserRole::MEMBER,
        ]);

        $token = $user->createToken('default-token', ['projects:read','projects:create']);
        return response()->json([
            'token'=>$token->plainTextToken,
            'token_type'=>'Bearer'
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user = User::where('email',$data['email'])->first();
        if (!$user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message'=>'Invalid credentials'], 401);
        }

        $token = $user->createToken('mobile', ['projects:read','projects:create']);
        return response()->json(['token'=>$token->plainTextToken, 'token_type'=>'Bearer']);
    }

//    public function logout(Request $req)
//    {
//        $req->user()->currentAccessToken()->delete();
//        return response()->json(['message'=>'Logged out']);
//    }
//
//    public function logoutAll(Request $req)
//    {
//        $req->user()->tokens()->delete();
//        return response()->json(['message'=>'All tokens revoked']);
//    }
}
