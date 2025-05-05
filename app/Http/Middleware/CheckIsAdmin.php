<?php

namespace App\Http\Middleware;

use App\Service\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard("sanctum")->user();
        
        if ($user && $user->is_admin != "admin") {
            return ApiResponse::forbidden();
        }
        return $next($request);
    }
}
