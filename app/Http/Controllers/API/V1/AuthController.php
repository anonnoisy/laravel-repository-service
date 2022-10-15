<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.',
            ], 401);
        }

        $token = Auth::user()->createToken('Personal Access Tokens', ['basic-auth'])->accessToken;

        return response(['token' => $token]);
    }

    public function profile()
    {
        $user = auth()->user();
        dd($user->permissions);

        return response([
            'success' => true,
            'message' => 'successfully get profile information',
            'data' => $user,
        ]);
    }

    public function logout()
    {
        $tokenRepository = app(TokenRepository::class);

        $tokenId = Auth::user()->token()->id;
        // Revoke an access token
        $tokenRepository->revokeAccessToken($tokenId);

        return response([
            'success' => true,
            'message' => 'logout.',
        ]);
    }
}
