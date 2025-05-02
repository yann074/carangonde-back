<?php

namespace App\Service\Auth;

use Illuminate\Support\Facades\Auth;

class LogoutService
{
    public function __construct()
    {

    }

    public function logout()
    {

        try {
            $user = Auth::user();

            if (!$user) {
                return "Usuário não Autenticado";
            }

            Auth::user()->currentAccessToken()->delete();

            return "Logout realizado com sucesso";
        } catch (\Exception $e) {
            return "Erro ao atualizar o User" . $e->getMessage();
        }
    }
}
