<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(){
        $courses = Course::whereHas('semester', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('semester')->paginate(10);

        return view('courses.index', compact('courses'));
    }

    public function create(){
        $semesters = auth()->user()->semesters()->get();
        return view('courses.create', compact('semesters'));
    }

    public function store(Request $request){
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

        $recentActivities = $this->getRecentActivities($course);

        return view('courses.show', compact('course', 'recentActivities'));
    }

    private function getRecentActivities($course)
    {
        $activities = collect();

        $monitorings = $course->monitorings()
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($monitoring) {
                return [
                    'type' => 'monitoring',
                    'description' => 'Monitoring: ' . ($monitoring->achieved ? 'Tercapai' : 'Tidak Tercapai') . ' - ' . Str::limit($monitoring->planned, 50),
                    'time' => $monitoring->created_at->diffForHumans(),
                    'icon' => $monitoring->achieved ? 'fa-check-circle' : 'fa-times-circle',
                    'time_diff' => $monitoring->created_at->diffForHumans()
                ];
            });

        $sq3rSessions = $course->sq3rSessions()
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($session) {
                return [
                    'type' => 'sq3r',
                    'description' => 'SQ3R: ' . $session->module_title . ' - ' . ($session->review_notes ? 'Selesai' : 'Dalam Proses'),
                    'time' => $session->created_at->diffForHumans(),
                    'icon' => $session->review_notes ? 'fa-check-circle' : 'fa-clock',
                    'time_diff' => $session->created_at->diffForHumans()
                ];
            });

        $conceptMaps = $course->conceptMaps()
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($map) {
                $nodes = is_array($map->nodes) ? $map->nodes : json_decode($map->nodes, true) ?? [];
                $edges = is_array($map->edges) ? $map->edges : json_decode($map->edges, true) ?? [];

                return [
                    'type' => 'concept_map',
                    'description' => 'Peta Konsep: ' . $map->title . ' (' . count($nodes) . ' konsep)',
                    'time' => $map->created_at->diffForHumans(),
                    'icon' => 'fa-project-diagram',
                    'time_diff' => $map->created_at->diffForHumans()
                ];
            });

        return $monitorings->merge($sq3rSessions)->merge($conceptMaps)
            ->sortByDesc('created_at')
            ->take(10)
            ->values();
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
