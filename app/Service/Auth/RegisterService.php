<?php

namespace App\Service\Auth;

use App\Models\User;
use App\Mail\ConfirmUserMail;
use App\Enums\Permissions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterService
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function createUser(array $data)
    {
        try {
            if (User::where('email', $data["email"])->exists()) {
                return 'E-mail já cadastrado.';
            }

            $data['password'] = Hash::make($data['password']);
            $data['confimation_token'] = Str::random(64);
            $data['role'] = Permissions::User;
            $data['active'] = 0;

            $user = $this->user->create($data);

            Cache::forget('users:all');

            //email para confirmar
            Mail::to($user->email)->send(new ConfirmUserMail($user));

            return [
                'role' => $user->role,
                'user' => $user,
                'token' => $user->confimation_token
            ];
        } catch (\Exception $e) {
            return "Erro ao criar o User" . $e->getMessage();
        }

    }

    public function confirmEmail($token)
    {

        try {
            $user = $this->user->where('confimation_token', $token)->first();

            if (!$user) {
                return "Token nao foi confirmado";
            }

            $user->update([
                'email_verified_at' => now(),
                'confimation_token' => null,
                'active' => 1,
            ]);

            return response()->json([
                'message' => 'Ativado com sucesso',
                'redirect_url' => 'http://localhost:5173/courses' // URL para redirecionamento no frontend
            ], 200);

        } catch (\Exception $e) {
            return "Erro ao atualizar o User" . $e->getMessage();
        }
    }
}
