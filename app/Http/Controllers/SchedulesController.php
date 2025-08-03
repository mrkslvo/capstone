<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentMonth = $request->query('month')
            ? Carbon::createFromFormat('Y-m', $request->query('month'))
            : now()->startOfMonth();

        $startDate = $currentMonth->copy()->startOfMonth()->startOfWeek()->subDay();
        $endDate = $currentMonth->copy()->endOfMonth()->endOfWeek()->subDay();

        $schedules = Schedule::whereBetween('date', [$startDate, $endDate])->get();

        $grouped = $schedules->groupBy(function ($item) {
            return Carbon::parse($item->date)->format('Y-m-d');
        });

        return view('admin.schedules', [
            'schedules' => $schedules,
            'groupedSchedules' => $grouped,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'today' => $currentMonth,
            'previousMonth' => $currentMonth->copy()->subMonth()->format('Y-m'),
            'nextMonth' => $currentMonth->copy()->addMonth()->format('Y-m'),
            'allSchedules' => Schedule::all(),
        ]);
    }

    /**
     * Store a newly created schedule.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|unique:schedules,date',
            'time' => 'required|string',
            'type' => 'required|in:immunization,prenatal,timbang',
            'status' => 'required|in:confirmed,pending,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $schedule = Schedule::create($request->all());

        return response()->json(['message' => 'Schedule created successfully.', 'schedule' => $schedule]);
    }

    /**
     * Show a single schedule (if needed).
     */
    public function show(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        return response()->json($schedule);
    }

    /**
     * Show the form for editing the specified schedule (optional).
     */
    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        return response()->json($schedule);
    }

    /**
     * Update the specified schedule.
     */
    // Update
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|unique:schedules,date,' . $id,
            'time' => 'required|string',
            'type' => 'required|in:immunization,prenatal,timbang',
            'status' => 'required|in:confirmed,pending,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());

        return response()->json(['message' => 'Schedule updated successfully.', 'schedule' => $schedule]);
    }

    /**
     * Remove the specified schedule.
     */
    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully.']);
    }
}
