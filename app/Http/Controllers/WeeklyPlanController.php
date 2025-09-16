<?php

namespace App\Http\Controllers;

use App\Models\WeeklyPlan;
use App\Models\Course;
use Illuminate\Http\Request;

class WeeklyPlanController extends Controller
{
    public function index()
    {
        $weeklyPlans = WeeklyPlan::whereHas('course.semester', function($query) {
            $query->where('user_id', auth()->id());
        })->with('course')->paginate(10);

        return view('weekly-plans.index', compact('weeklyPlans'));
    }

    public function create()
    {
        return view('weekly-plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'week_number' => 'required|integer|min:1|max:14',
            'target_text' => 'required|string',
            'planned_hours' => 'required|numeric|min:0',
            'num_pages' => 'nullable|integer|min:0',
            'status' => 'required|in:planned,in_progress,completed,missed',
            'media' => 'nullable|string',
        ]);

        // Verify the course belongs to the user
        $course = Course::findOrFail($validated['course_id']);
        if ($course->semester->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Process media field
        if (!empty($validated['media'])) {
            $validated['media'] = array_filter(explode("\n", $validated['media']));
        }

        $validated['user_id'] = auth()->id();

        $weeklyPlan = WeeklyPlan::create($validated);

        return redirect()->route('weekly-plans.show', $weeklyPlan)
            ->with('success', 'Weekly plan created successfully.');
    }

    public function destroy(WeeklyPlan $weeklyPlan)
    {
        // Verify the plan belongs to the user
        if ($weeklyPlan->course->semester->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $weeklyPlan->delete();

        return redirect()->route('weekly-plans.index')
            ->with('success', 'Weekly plan deleted successfully.');
    }

    public function show(WeeklyPlan $weeklyPlan)
    {
        return view('weekly-plans.show', compact('weeklyPlan'));
    }

    public function edit(WeeklyPlan $weeklyPlan)
    {
        return view('weekly-plans.edit', compact('weeklyPlan'));
    }

    public function update(Request $request, WeeklyPlan $weeklyPlan)
    {
        $validated = $request->validate([
            'target_text' => 'required|string',
            'num_pages' => 'nullable|integer|min:0',
            'media' => 'nullable|array',
            'planned_hours' => 'required|numeric|min:0',
            'status' => 'required|in:planned,in_progress,completed,missed',
        ]);

        $weeklyPlan->update($validated);

        return redirect()->route('weekly-plans.show', $weeklyPlan)
            ->with('success', 'Weekly plan updated successfully.');
    }

    public function autosave(Request $request, WeeklyPlan $weeklyPlan)
    {
        $validated = $request->validate([
            'target_text' => 'sometimes|string',
            'num_pages' => 'sometimes|integer|min:0',
            'media' => 'sometimes|array',
            'planned_hours' => 'sometimes|numeric|min:0',
        ]);

        $weeklyPlan->update($validated);

        return response()->json(['message' => 'Autosave successful', 'saved_at' => now()]);
    }
}
