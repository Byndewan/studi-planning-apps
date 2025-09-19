<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ConceptMap;
use App\Models\Monitoring;
use App\Models\SQ3RSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function filterWeekly(Request $request)
    {
        $query = auth()->user()->weeklyPlans()->with('course.semester');

        if ($request->semester) {
            $query->whereHas('course.semester', function ($q) use ($request) {
                $q->where('id', $request->semester);
            });
        }
        if ($request->course) {

            $query->where('course_id', $request->course);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $plans = $query->get();

        return response()->json($plans);
    }

    public function filterMonitoring(Request $request)
    {
        $query = Monitoring::with(['course.semester']);

        if ($request->course) {
            $query->where('course_id', $request->course);
        }

        if ($request->status !== null && $request->status !== '') {
            $query->where('achieved', $request->status);
        }

        if ($request->start) {
            $query->whereDate('date', '>=', $request->start);
        }

        if ($request->end) {
            $query->whereDate('date', '<=', $request->end);
        }

        $monitorings = $query->get()->map(function ($m) {
            return [
                'id' => $m->id,
                'date' => $m->date->format('d M Y'),
                'week_number' => $m->week_number,
                'planned' => Str::limit($m->planned, 50),
                'achieved' => $m->achieved,
                'course' => [
                    'name' => $m->course->name,
                    'semester' => ['name' => $m->course->semester->name]
                ]
            ];
        });

        return response()->json($monitorings);
    }

    public function filterSQ3R(Request $request)
    {
        $query = SQ3RSession::with('course');

        if ($request->course) {
            $query->where('course_id', $request->course);
        }

        if ($request->module) {
            $query->where('module_title', 'like', '%' . $request->module . '%');
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $sessions = $query->get()->map(function ($s) {
            return [
                'id' => $s->id,
                'module_title' => $s->module_title,
                'date' => $s->created_at->format('d M Y'),
                'review_notes' => $s->review_notes,
                'progress' => $s->review_notes ? 100 : ($s->recite_notes ? 80 : ($s->read_notes ? 60 : ($s->questions ? 40 : ($s->survey_notes ? 20 : 0)))),
                'course' => [
                    'name' => $s->course->name ?? '-',
                ]
            ];
        });

        return response()->json($sessions);
    }

    public function filterMap(Request $request)
    {
        $query = ConceptMap::with('course');

        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', Carbon::parse($request->start_date));
        }

        if ($request->end_date) {
            $query->whereDate('created_at', '<=', Carbon::parse($request->end_date));
        }


        // if ($request->date_range) {
        //     [$start, $end] = explode(' - ', $request->date_range);
        //     $query->whereBetween('created_at', [
        //         Carbon::parse($start)->startOfDay(),
        //         Carbon::parse($end)->endOfDay()
        //     ]);
        // }

        $conceptMaps = $query->latest()->paginate(9);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('concept-maps.partials.concept-map-list', compact('conceptMaps'))->render(),
                'pagination' => $conceptMaps->links()->toHtml()
            ]);
        }

        return view('concept-maps.index', compact('conceptMaps'));
    }
}
