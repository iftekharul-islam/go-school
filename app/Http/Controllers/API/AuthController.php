<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
//        $request->validate([
//            'name' => 'required|string',
//            'email' => 'required|string|email|unique:users',
//            'password' => 'required|string|confirmed'
//        ]);
//        $user = new User([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => bcrypt($request->password)
//        ]);
//        $user->save();
//        return response()->json([
//            'message' => 'Successfully created user!'
//        ], 201);
    }
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @return [string] access_token
     * @return [string] token_type
     */
    public function login(Request $request)
    {
//        $request->validate([
//            'email' => 'required|string|email',
//            'password' => 'required|string'
//        ]);
//
//
//        $credentials = request(['email', 'password']);
//
//        if(!Auth::attempt($credentials))
//            return response()->json([
//                'message' => 'Unauthorized'
//            ], 401);
//
//
//        $user = $request->user();
//        $tokenResult = $user->createToken('Access Token');
//        $token = $tokenResult->token;
//
//        $token->save();
//        return response()->json([
//            'access_token' => $tokenResult->accessToken,
//            'token_type' => 'Bearer',
//        ]);
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (! \auth()->attempt($loginData))
        {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $accessToken = \auth()->user()->createToken('authToken')->accessToken;

        return response(['access_token' => $accessToken]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
