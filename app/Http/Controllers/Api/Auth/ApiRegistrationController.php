<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
class ApiRegistrationController extends Controller
{
    public function register(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|digits_between:10,10|unique:users,mobile',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
           return response(["errors" => $validator->errors()], 422);
        }

        $data = [
            'name' => $r->name,
            'email' => $r->email,
            'mobile' => $r->mobile,
            'password' => \Hash::make($r->password)
        ];

        $user = User::create($data);

        return response([
            'message' => 'Account Created Successfully', 
            'data' => ['token' => $user->createToken('New User')->accessToken, 'user' => $user]
        ],201);

    }
}
