<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SQ3RSession;
use Illuminate\Http\Request;

class SQ3RSessionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'module_title' => 'nullable|string|max:255',
            'survey_notes' => 'nullable|string',
            'questions' => 'nullable|array',
            'read_notes' => 'nullable|string',
            'recite_notes' => 'nullable|string',
            'review_notes' => 'nullable|string',
        ]);

        $session = SQ3RSession::create([
            ...$validated,
            'user_id' => auth()->id(),
            'timestamps' => json_encode([
                'started_at' => now(),
                'last_saved_at' => now(),
            ])
        ]);

        return response()->json($session, 201);
    }

    public function update(Request $request, SQ3RSession $sq3rSession)
    {
        $validated = $request->validate([
            'module_title' => 'nullable|string|max:255',
            'survey_notes' => 'nullable|string',
            'questions' => 'nullable|array',
            'read_notes' => 'nullable|string',
            'recite_notes' => 'nullable|string',
            'review_notes' => 'nullable|string',
        ]);

        // Update timestamps
        $timestamps = json_decode($sq3rSession->timestamps, true);
        $timestamps['last_saved_at'] = now();

        if (empty($timestamps['completed_at']) && !empty($validated['review_notes'])) {
            $timestamps['completed_at'] = now();
        }

        $sq3rSession->update([
            ...$validated,
            'timestamps' => json_encode($timestamps)
        ]);

        return response()->json($sq3rSession);
    }

    public function destroy(SQ3RSession $sq3rSession)
    {
        $sq3rSession->delete();

        return response()->json(null, 204);
    }
}
