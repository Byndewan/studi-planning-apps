<?php

namespace App\Http\Controllers;

use App\Models\ConceptMap;
use App\Models\Course;
use App\Models\SQ3RSession;
use App\Services\ConceptMapGenerator;
use Illuminate\Http\Request;

class ConceptMapController extends Controller
{
    protected $conceptMapGenerator;

    public function __construct(ConceptMapGenerator $conceptMapGenerator)
    {
        $this->conceptMapGenerator = $conceptMapGenerator;
    }

    public function index()
    {
        $conceptMaps = ConceptMap::where('user_id', auth()->id())
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('concept-maps.index', compact('conceptMaps'));
    }

    public function create()
    {
        $courses = Course::whereHas('semester', function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        $sq3rSessions = SQ3RSession::where('user_id', auth()->id())
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('concept-maps.create', compact('courses', 'sq3rSessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'sq3r_session_id' => 'nullable|exists:sq3r_sessions,id',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        if ($course->semester->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $validated['user_id'] = auth()->id();

        if (!empty($validated['sq3r_session_id'])) {
            $sq3rSession = SQ3RSession::findOrFail($validated['sq3r_session_id']);

            $conceptData = $this->conceptMapGenerator->generateFromSQ3R($sq3rSession);
            $validated['nodes'] = $conceptData['nodes'];
            $validated['edges'] = $conceptData['edges'];
        } else {
            $validated['nodes'] = [];
            $validated['edges'] = [];
        }

        $conceptMap = ConceptMap::create($validated);

        return redirect()->route('concept-maps.show', $conceptMap)
            ->with('success', 'Concept map created successfully.');
    }

    public function show(ConceptMap $conceptMap)
    {
        $conceptMap->load('sq3rSession');

        $nodes = is_string($conceptMap->nodes)
            ? json_decode($conceptMap->nodes, true)
            : ($conceptMap->nodes ?? []);

        $edges = is_string($conceptMap->edges)
            ? json_decode($conceptMap->edges, true)
            : ($conceptMap->edges ?? []);

        return view('concept-maps.show', compact('conceptMap', 'nodes', 'edges'));
    }

    public function edit(ConceptMap $conceptMap)
    {
        $courses = Course::whereHas('semester', function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('concept-maps.edit', compact('conceptMap', 'courses'));
    }

    public function update(Request $request, ConceptMap $conceptMap)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'nodes' => 'nullable|array',
            'edges' => 'nullable|array',
        ]);

        $conceptMap->update($validated);

        return redirect()->route('concept-maps.show', $conceptMap)
            ->with('success', 'Concept map updated successfully.');
    }

    public function destroy(ConceptMap $conceptMap)
    {
        $conceptMap->delete();

        return redirect()->route('concept-maps.index')
            ->with('success', 'Concept map deleted successfully.');
    }

    public function generateFromSQ3R(SQ3RSession $sq3rSession)
    {
        $conceptData = $this->conceptMapGenerator->generateFromSQ3R($sq3rSession);

        return response()->json($conceptData);
    }

    public function autosave(Request $request, ConceptMap $conceptMap)
    {
        $validated = $request->validate([
            'nodes' => 'sometimes|array',
            'edges' => 'sometimes|array',
        ]);

        $conceptMap->update($validated);

        return response()->json([
            'message' => 'Autosave successful',
            'saved_at' => now(),
            'nodes' => $validated['nodes'] ?? [],
            'edges' => $validated['edges'] ?? []
        ]);
    }
}
