<?php

namespace App\Service\Auth;

use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function attemptLogin($loginInfos)
    {
        try {
            if (Auth::attempt($loginInfos)) {
                $user = Auth::user();
                $tokenResult = $user->createToken($user->name);
                $plainTextToken = $tokenResult->plainTextToken;
                $accessToken = $tokenResult->accessToken;

                $accessToken->expires_at = now()->addMinutes(60);
                $accessToken->save();


                return [
                    'role' => $user->role,
                    'user' => $user,
                    'token' => $plainTextToken
                ];
            }

            return null;
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
