<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Course;
use App\Models\WeeklyPlan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get current semester
        $currentSemester = Semester::where('user_id', $user->id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        // Get statistics
        $coursesCount = Course::whereHas('semester', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        // Calculate completion rate
        $completionRate = WeeklyPlan::whereHas('course.semester', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'completed')
        ->count();

        $totalPlans = WeeklyPlan::whereHas('course.semester', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $completionRate = $totalPlans > 0 ? round(($completionRate / $totalPlans) * 100) : 0;

        // Get upcoming tasks
        $upcomingTasks = WeeklyPlan::whereHas('course.semester', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', '!=', 'completed')
        ->where('week_number', '<=', now()->weekOfYear)
        ->count();

        // Recent activities
        $recentActivities = [
            [
                'icon' => 'book',
                'title' => 'Added new course',
                'description' => 'Mathematics 101',
                'time' => '2 hours ago'
            ],
            [
                'icon' => 'plan',
                'title' => 'Completed weekly plan',
                'description' => 'Week 5 - Physics',
                'time' => '1 day ago'
            ]
        ];

        // Upcoming deadlines
        $upcomingDeadlines = [
            [
                'title' => 'Assignment 1',
                'course' => 'Mathematics',
                'date' => 'Tomorrow',
                'urgent' => true
            ],
            [
                'title' => 'Quiz 2',
                'course' => 'Physics',
                'date' => 'In 3 days',
                'urgent' => false
            ]
        ];

        return view('dashboard', compact(
            'currentSemester',
            'coursesCount',
            'completionRate',
            'upcomingTasks',
            'recentActivities',
            'upcomingDeadlines'
        ));
    }
}
