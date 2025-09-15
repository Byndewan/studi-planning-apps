<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Course;
use App\Models\SemesterSchedule;
use App\Models\WeeklyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = auth()->user()->semesters()->withCount('courses')->paginate(10);

        return view('semesters.index', compact('semesters'));
    }

    public function create()
    {
        return view('semesters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $semester = auth()->user()->semesters()->create($validated);

        return redirect()->route('semesters.show', $semester)
            ->with('success', 'Semester created successfully.');
    }

    public function show(Semester $semester)
    {
        $semester->load('courses', 'studyGoals', 'semesterSchedules');

        return view('semesters.show', compact('semester'));
    }

    public function edit(Semester $semester)
    {
        return view('semesters.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $semester->update($validated);

        return redirect()->route('semesters.show', $semester)
            ->with('success', 'Semester updated successfully.');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();

        return redirect()->route('semesters.index')
            ->with('success', 'Semester deleted successfully.');
    }

    public function generateSchedule(Semester $semester)
    {
        DB::transaction(function () use ($semester) {
            foreach ($semester->courses as $course) {
                for ($week = 1; $week <= 14; $week++) {
                    SemesterSchedule::updateOrCreate(
                        [
                            'course_id' => $course->id,
                            'week_number' => $week
                        ],
                        [
                            'planned_hours' => $course->sks,
                            'note' => "Week {$week} study plan for {$course->name}"
                        ]
                    );

                    WeeklyPlan::updateOrCreate(
                        [
                            'course_id' => $course->id,
                            'week_number' => $week
                        ],
                        [
                            'target_text' => "Study materials for week {$week}",
                            'status' => 'planned'
                        ]
                    );
                }
            }
        });

        return redirect()->back()
            ->with('success', 'Schedule generated successfully for all courses.');
    }
}
