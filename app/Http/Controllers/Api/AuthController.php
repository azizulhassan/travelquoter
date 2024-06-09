<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Bad Creds'
            ], 404);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function check(Request $request) {
        // Get the token from the POST request
        $token = $request->input('bearer_token');

        // Try to find the token in the database
        $tokenInstance = PersonalAccessToken::findToken($token);

        // If the token instance exists and is valid
        if ($tokenInstance && !$tokenInstance->revoked) {
            return response()->json(['message' => 'Token is valid'], 200);
        } else {
            return response()->json(['message' => 'Token is invalid or revoked'], 401);
        }
    }

    public function logout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $user = User::find($request->user_id);
        if ($user) {
            $user->tokens()->delete();
        }

        return [
            'message' => 'Logged out'
        ];
    }
}
