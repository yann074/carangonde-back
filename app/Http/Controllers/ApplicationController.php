<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Service\ApplicationService;
use App\Service\ApiResponse;

class ApplicationController extends Controller
{
    private $applicationService;

    public function __construct(ApplicationService $applicationService){
        $this->applicationService = $applicationService;
    }

        public function applyCourse(Request $request, $id)
    {
        try {
            $user = $request->user();
            $apply = $this->applicationService->applyCourses($id, $user);
            return ApiResponse::success($apply);
        } catch (ValidationException $e) {
            return ApiResponse::erroron($e->getMessage(), 422);
        } catch (\Exception $e) {
            if ($e->getMessage() === 'Usuário já se candidatou para essa vaga.') {
                return ApiResponse::Conflict($e->getMessage());
            }
    
            return ApiResponse::erroron($e->getMessage() ?: 'Erro ao realizar candidatura.', 500);
        }
    }

    public function index()
{
    try {
        $applications = Application::with(['user', 'course'])->get();

        $data = $applications->map(function ($app) {
            return [
                'user' => $app->user->name ?? 'N/A',
                'email' => $app->user->email ?? 'N/A',
                'course' => $app->course->title ?? 'N/A',
                'data_aplicacao' => $app->date_applied,
                'status' => $app->status,
            ];
        });

        return response()->json([
            'status_code' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    } catch (\Exception $e) {
        \Log::error('Erro ao buscar candidaturas: ' . $e->getMessage());
        return response()->json(['error' => 'Erro ao buscar candidaturas'], 500);
    }
}

}
