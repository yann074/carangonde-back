<?php

namespace App\Service;
use App\Models\Course;
use App\Service\FileService;

class CourseService
{
    private $courseModel;
    private $fileService;
    public function __construct(FileService $fileService, Course $courseModel)
    {
        $this->fileService = $fileService;
        $this->courseModel = $courseModel;
    }

    public function getAllCourses()
    {
        return $this->courseModel->all();
    }

    public function getCourseById($id)
    {
        return $this->courseModel->find($id);
    }

    public function createCourse($data)
    {
        
        $data['image'] = $this->fileService->uploadPhoto($data);
        $data['pdf'] = $this->fileService->uploadPdf($data);

        return $this->courseModel->create($data);
    }

    public function updateCourse($id, $data)
    {
        $course = $this->getCourseById($id);
        if ($course) {
            $course->update($data);
            return $course;
        }
        return null;
    }

    public function deleteCourse($id)
    {
        $course = $this->getCourseById($id);
        if ($course) {
            $course->delete();
            return true;
        }
        return false;
    }

}
