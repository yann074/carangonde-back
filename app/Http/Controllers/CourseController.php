<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Service\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Service\CourseService;

class CourseController extends Controller
{
    protected $courseService;
    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }
    public function index()
    {
        $courses = Cache::remember('courses:all', 1, function () {
            return Course::all();
        });

        return ApiResponse::success($courses);
    }


    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->only([
            'title',
            'description',
            'location',
            'slots',
            'active',
            'image',
            'start_date', 
            'end_date'   
        ]);

        $data['user_id'] = $user->id;

        $course = $this->courseService->createCourse($data);

        Cache::forget('courses:all');

        return ApiResponse::created($course);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course = Cache::remember('courses:show:' . $course->id, 10800, function () use ($course) {
            return Course::find($course->id);
        });

        if (!$course) {
            return ApiResponse::notFound();
        }

        return ApiResponse::success($course);
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->only(['title', 'description', 'location', 'date', 'time', 'image', 'slots', 'active']);

        $course = $this->courseService->updateCourse($course->id, $data);
        if (!$course) {
            return ApiResponse::notFound();
        }
        Cache::forget('courses:show:' . $course->id);

        Cache::forget('courses:all');

        return ApiResponse::created($course);
    }


    public function destroy(Course $course)
    {
        $deleted = $this->courseService->deleteCourse($course->id);

        if (!$deleted) {
            return ApiResponse::notFound();
        }

        Cache::forget('courses:all');
        Cache::forget('courses:show:' . $course->id);

        return ApiResponse::success('Course deleted successfully');
    }
}
