<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json(
            [
                'id' => $user->id,
                'name' => $user->name,
                'access_token' => $user->createToken('token')->accessToken
            ],
            201
        );
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'id' => $user->id,
                    'name' => $user->name,
                    'access_token' => $user->createToken('token')->accessToken
                ]);
            } else {
                return response(["message" => "Password mismatch"], 422);
            }
        } else {
            return response(["message" =>'User does not exist'], 422);
        }
    }

    public function logout(): JsonResponse
    {
        auth()->user()->token()->revoke();
        return response()->json(['status' => 200]);
    }
}
