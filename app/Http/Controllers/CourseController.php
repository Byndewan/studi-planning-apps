<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::whereHas('semester', function($query) {
            $query->where('user_id', auth()->id());
        })->with('semester')->paginate(10);

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $semesters = auth()->user()->semesters()->get();
        return view('courses.create', compact('semesters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'code' => 'required|string|max:50|unique:courses,code',
            'name' => 'required|string|max:255',
            'sks' => 'required|integer|min:1',
            'total_modules' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $semester = Semester::findOrFail($validated['semester_id']);
        if ($semester->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        if ($course->semester->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $course->load('semester', 'weeklyPlans', 'monitorings', 'sq3rSessions', 'conceptMaps');

        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        if ($course->semester->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $semesters = auth()->user()->semesters()->get();

        return view('courses.edit', compact('course', 'semesters'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'name' => 'required|string|max:255',
            'sks' => 'required|integer|min:1',
            'total_modules' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $semester = Semester::findOrFail($validated['semester_id']);
        if ($semester->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $course->update($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        if ($course->semester->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $semesterId = $course->semester_id;
        $course->delete();

        return redirect()->route('semesters.show', $semesterId)
            ->with('success', 'Course deleted successfully.');
    }
}
