<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\Course;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        $monitorings = Monitoring::where('user_id', auth()->id())
            ->with('course')
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('monitorings.index', compact('monitorings'));
    }

    public function create()
    {
        $courses = Course::whereHas('semester', function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('monitorings.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'week_number' => 'required|integer|min:1|max:14',
            'planned' => 'required|string',
            'actual' => 'required|string',
            'cause' => 'nullable|string',
            'solution' => 'nullable|string',
            'achieved' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['achieved'] = $request->has('achieved');

        Monitoring::create($validated);

        return redirect()->route('monitorings.index')
            ->with('success', 'Monitoring entry created successfully.');
    }

    public function show(Monitoring $monitoring)
    {
        return view('monitorings.show', compact('monitoring'));
    }

    public function edit(Monitoring $monitoring)
    {
        if ($monitoring->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $courses = Course::whereHas('semester', function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('monitorings.edit', compact('monitoring', 'courses'));
    }

    public function update(Request $request, Monitoring $monitoring)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'week_number' => 'required|integer|min:1|max:14',
            'planned' => 'required|string',
            'actual' => 'required|string',
            'cause' => 'nullable|string',
            'solution' => 'nullable|string',
            'achieved' => 'boolean',
        ]);

        $validated['achieved'] = $request->has('achieved');

        $monitoring->update($validated);

        return redirect()->route('monitorings.show', $monitoring)
            ->with('success', 'Monitoring entry updated successfully.');
    }

    public function destroy(Monitoring $monitoring)
    {
        $monitoring->delete();

        return redirect()->route('monitorings.index')
            ->with('success', 'Monitoring entry deleted successfully.');
    }
}
