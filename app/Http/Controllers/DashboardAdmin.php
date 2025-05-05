<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Event;
use App\Service\ApiResponse;


class DashboardAdmin extends Controller
{
    private $user;
    private $course;
    private $event;

    public function __construct(User $user, Course $course, Event $event)
    {
        $this->user = $user;
        $this->course = $course;
        $this->event = $event;
    }

    public function status()
    {
        $couseCount = $this->course->count();
        $usersCount = $this->user->count();

        return ApiResponse::success([
            "courses" => [
                "total_courses" => $couseCount,
                "enrollment_over_time" => self::getUsersByDay(),
                "recent_courses" => self::recentCourses(),
            ],
            "event" => [
                "active_events" => self::activeEvents(),
                "upcoming_events" => self::upcomingEvents(),
            ],
            "users" => [
                "total_users" => $usersCount,
                "recent_users" => self::recentUsers(),
            ],
        ]);
    }

    public function getUsersByDay(){
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        return User::selectRaw("DATE_FORMAT(created_at, '%d/%m') as dia, COUNT(*) as inscritos")
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();
    }

    public function recentCourses(){
        $course = $this->course;

        return $course->orderByDesc('created_at')
            ->take(10)
            ->get();
    }

    public function activeEvents(){
        $events = $this->event;

        return $events->where('active', 1)
            ->orderByDesc('created_at')
            ->take(10)
            ->get();
    }

    public function upcomingEvents(){
        $events = $this->event;

        return $events->where('date', '>=', Carbon::now())
            ->orderBy('date')
            ->take(10)
            ->get();
    }
    
    public function recentUsers(){
        $user = $this->user;

        return $user->orderByDesc('created_at')
            ->take(10)
            ->get();
    }

}
