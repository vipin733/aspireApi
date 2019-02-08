<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
class ApiLoginController extends Controller
{
    public function login(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
           return response(["errors" => $validator->errors()], 422);
        }

        $credentials = $r->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response(["errors" => [], "msg" => "Unauthorize"], 401);
        }
        $user = $r->user();
        return response([
            'message' => 'LogedIn Successfully', 
            'data' => ['token' => $user->createToken('User')->accessToken, 'user' => $user]
        ],201);

    }
}
