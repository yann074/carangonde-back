<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Service\ApiResponse;
use App\Service\Auth\LoginService;
use App\Service\Auth\LogoutService;
use App\Service\Auth\RegisterService;
use Mail;
use Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public $loginService;
    public $logoutService;
    public $registerService;

    public function __construct(LoginService $loginService, LogoutService $logoutService, RegisterService $registerService)
    {
        $this->loginService = $loginService;
        $this->logoutService = $logoutService;
        $this->registerService = $registerService;
    }


    //ADICIONAR UM SERVICE PARA ESSE
    /*public function AuthGoogle(Request $request)
    {
        //https://console.cloud.google.com/auth/clients/create?previousPage=%2Fapis%2Fcredentials%3ForganizationId%3D0%26project%3Dcentral-bulwark-452300-t6&organizationId=0&project=central-bulwark-452300-t6
        $user_google = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $user_google->getEmail())->first();

        if (!$user) {
            $new_user = new User();

            $new_user->name = $user_google->getName();
            $new_user->permission = "users";
            $new_user->email = $user_google->getEmail();
            $new_user->password = bcrypt(str()->random(16));
            $new_user->confirmation_token = Str::random(64);
            $new_user->active = 1;
            $new_user->save();

            $token = $new_user->createToken($new_user->name)->plainTextToken;
            return ApiResponse::created([$new_user['name'], $new_user['email'], $token]);
        }

        return ApiResponse::error("Algo deu errado, tente novamente");
    }*/

    public function newUser(Request $request)
    {
        $response = $this->registerService->createUser($request->all());
        if ($response) {
            return ApiResponse::created($response);
        }
        if ($response == "email") {
            return ApiResponse::error("Email já cadastrado");
        }
        return $response ?? ApiResponse::error("Erro ao criar o usuário");
    }

    public function confirmEmail($token)
    {
        $response = $this->registerService->confirmEmail($token);

        return $response ?? ApiResponse::error("Erro ao confirmar o e-mail");
    }

    public function Login(Request $request)
    {
        $data = $request->only('email', 'password');

        $authData = $this->loginService->attemptLogin($data);

        if (!$authData) {
            return ApiResponse::error('Algo deu errado, tente novamente');
        }

        return ApiResponse::success([
            'role' => $authData['user']->role,
            'token' => $authData['token']
        ]);

    }

    public function logout()
    {
        $user = $this->logoutService->logout();

        if (!$user) {
            return ApiResponse::error('Token inválido ou expirado');
        }

        return ApiResponse::success('Deslogado com sucesso');
    }

    public function sendResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        Mail::to($request->email)->send(new ResetPassword($token));

        return ApiResponse::success('Email de redefinição enviado com sucesso.');

    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $reset =  DB::table('password_resets')
        ->where('email', $request->email)
        ->where('token', $request->token)
        ->first();

        if (!$reset) {
            return response()->json(['message' => 'Token inválido ou expirado.'], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Senha redefinida com sucesso.']);
    }
}
