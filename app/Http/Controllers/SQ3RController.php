<?php

namespace App\Http\Controllers;

use App\Models\SQ3RSession;
use App\Models\Course;
use Illuminate\Http\Request;

class SQ3RController extends Controller
{
    public function index()
    {
        $sessions = SQ3RSession::where('user_id', auth()->id())
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('sq3r.index', compact('sessions'));
    }

    public function create()
    {
        $courses = Course::whereHas('semester', function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('sq3r.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'module_title' => 'required|string|max:255',
            'survey_notes' => 'nullable|string',
            'questions' => 'nullable|array',
            'read_notes' => 'nullable|string',
            'recite_notes' => 'nullable|string',
            'review_notes' => 'nullable|string',
        ]);


        $validated['user_id'] = auth()->id();
        $validated['timestamps'] = json_encode([
            'started_at' => now(),
            'last_saved_at' => now(),
        ]);

        $session = SQ3RSession::create($validated);

        return redirect()->route('sq3r.show', $session)
            ->with('success', 'SQ3R session created successfully.');
    }

    public function show()
    {
        $sq3rSession = SQ3RSession::where('user_id', auth()->id())->with('course')->orderBy('created_at', 'desc')->first();

        return view('sq3r.show', compact('sq3rSession'));
    }

    public function edit()
    {
        $courses = Course::whereHas('semester', function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        $sq3rSession = SQ3RSession::where('user_id', auth()->id())->with('course')->orderBy('created_at', 'desc')->first();

        return view('sq3r.edit', compact('sq3rSession', 'courses'));
    }

    public function update(Request $request, SQ3RSession $sq3r)
    {

        // dd($request->all());
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'module_title' => 'required|string|max:255',
            'survey_notes' => 'nullable|string',
            'questions' => 'nullable|array',
            'read_notes' => 'nullable|string',
            'recite_notes' => 'nullable|string',
            'review_notes' => 'nullable|string',
        ]);

        // Update timestamps
        $timestamps = json_decode($sq3r->timestamps, true);
        if (!is_array($timestamps)) {
            $timestamps = [];
        }
        $timestamps['last_saved_at'] = now();

        if (empty($timestamps['completed_at']) && !empty($validated['review_notes'])) {
            $timestamps['completed_at'] = now();
        }

        $validated['timestamps'] = json_encode($timestamps);

        $sq3r->update($validated);

        return redirect()->route('sq3r.show', $sq3r)
            ->with('success', 'SQ3R session updated successfully.');
    }

    public function destroy(SQ3RSession $sq3r)
    {

        $sq3r->delete();

        return redirect()->route('sq3r.index')
            ->with('success', 'SQ3R session deleted successfully.');
    }

    public function autosave(Request $request, SQ3RSession $sq3rSession)
    {

        $validated = $request->validate([
            'survey_notes' => 'sometimes|string',
            'questions' => 'sometimes|array',
            'read_notes' => 'sometimes|string',
            'recite_notes' => 'sometimes|string',
            'review_notes' => 'sometimes|string',
        ]);

        // Update timestamps
        $timestamps = json_decode($sq3rSession->timestamps, true);
        $timestamps['last_saved_at'] = now();

        $validated['timestamps'] = json_encode($timestamps);

        $sq3rSession->update($validated);

        return response()->json(['message' => 'Autosave successful', 'saved_at' => now()]);
    }
}
