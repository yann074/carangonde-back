<?php

namespace App\Service;

use App\Models\User;
use App\Models\Application;
use App\Models\Course;
use Carbon\Carbon;
use Log;


class ApplicationService{

    private $user;
    private $application;
    private $course;

    public function __construct(User $user, Application $application, Course $course){
        $this->user = $user;
        $this->application = $application;
        $this->course = $course;
    }

    public function hasAlreadyApplied($courseId, $userId){
        return $this->application
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();
    }

      public function getOpportunitieById($id)
    {
        try {
            return $this->course->findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar oportunidade: ' . $e->getMessage());
            throw new \Exception('Oportunidade não encontrada.');
        }
    }

    public function applyCourses($id, $user){
         try {
            if ($this->hasAlreadyApplied($id, $user->id)) {
                throw new \Exception('Usuário já se candidatou para essa vaga.');
            }
    

        $course = $this->getOpportunitieById($id);

        
        if ($course->slot <= 0) {
            throw new \Exception('Não há mais vagas disponíveis.');
        }

        $course->slot = $course->slot - 1;
        $course->save(); 

        $data = [
            'candidate_id' => $user->id,
            'job_id' => $course->id,
            'status' => 'Cadastrado',
            'date_applied' => Carbon::now(),
        ];
    
            $application = $this->application->create($data);
    
            return $application;
    
        } catch (\Exception $e) {
            Log::error('Error creating opportunity: ' . $e->getMessage());
            throw $e; 
        }
    }
}