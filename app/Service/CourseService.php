<?php

namespace App\Service;
use App\Models\Course;

class CourseService
{
    private $courseModel;

    public function __construct(Course $courseModel)
    {
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
