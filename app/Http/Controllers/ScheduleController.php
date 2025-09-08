<?php

namespace App\Http\Controllers;

use App\Models\MaternalProfile;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // update all schedules with status pending and date less than today
        Schedule::where('status', 'pending')
            ->where('date', '<', $today)
            ->update([
                'status' => 'missed'
            ]);

        $schedules = Schedule::where('status', '!=', 'done')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        // Get all  names
        $maternalNames = MaternalProfile::pluck('name');

        return Inertia::render('Admin/Schedule', [
            'schedules' => $schedules,
            'maternalNames' => $maternalNames,
        ]);
    }

    public function store(Request $request)
    {
        //Check vAlidations
        $validated = $request->validate([
            'for' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'type' => 'required|string|max:255',
            'status' => 'nullable',
            'recurrence_rule' => 'nullable|string|max:255',
        ]);

        // Combine date + time for checking
        $date = Carbon::parse($validated['date']);
        $time = Carbon::parse($validated['time']);

        // Check if weekend
        if ($date->isSaturday() || $date->isSunday()) {
            return back()->withErrors(['date' => 'Schedules cannot be set on Saturday or Sunday.'])->withInput();
        }

        // Check time between 6AM - 6PM
        $startTime = Carbon::createFromTime(6, 0, 0);
        $endTime = Carbon::createFromTime(18, 0, 0);

        if ($time->lt($startTime) || $time->gt($endTime)) {
            return back()->withErrors(['time' => 'Time must be between 6:00 AM and 6:00 PM.'])->withInput();
        }
        // Create schedule
        Schedule::create([
            'for' => $validated['for'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'type' => $validated['type'],
            'status' => $validated['status'] ?? 'pending',
            'recurrence_rule' => $validated['recurrence_rule'] ?? null,
        ]);

        return redirect()->route('schedule')->with('success', 'Schedule added successfully.');
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'type' => 'required|string|max:255',
            'recurrence_rule' => 'nullable|string|max:255',
        ]);

        $date = Carbon::parse($validated['date']);
        $time = Carbon::parse($validated['time']);

        // Weekend check
        if ($date->isSaturday() || $date->isSunday()) {
            return back()->withErrors(['date' => 'Schedules cannot be set on Saturday or Sunday.'])->withInput();
        }

        // Time check
        $startTime = Carbon::createFromTime(6, 0, 0);
        $endTime = Carbon::createFromTime(18, 0, 0);

        if ($time->lt($startTime) || $time->gt($endTime)) {
            return back()->withErrors(['time' => 'Time must be between 6:00 AM and 6:00 PM.'])->withInput();
        }

        $schedule->update([
            'date' => $validated['date'],
            'time' => $validated['time'],
            'type' => $validated['type'],
            'recurrence_rule' => $validated['recurrence_rule'],
        ]);

        return redirect()->route('schedule')->with('success', 'Schedule updated successfully.');
    }

    public function updateStatus(Schedule $schedule)
    {
        sleep(1);

        $schedule->update([
            'status' => 'completed',
        ]);

        return redirect()->route('maternal')->with('success', 'Schedule marked as completed.');
    }


    public function addPrenatalSched(Request $request)
    {
        // validation
        $validated = $request->validate([
            'for' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
        ]);

        // Combine date + time for checking
        $date = Carbon::parse($validated['date']);
        $time = Carbon::parse($validated['time']);

        // Check if weekend
        if ($date->isSaturday() || $date->isSunday()) {
            return back()->withErrors(['date' => 'Schedules cannot be set on Saturday or Sunday.'])->withInput();
        }

        // Check time between 6AM - 6PM
        $startTime = Carbon::createFromTime(6, 0, 0);
        $endTime = Carbon::createFromTime(18, 0, 0);

        if ($time->lt($startTime) || $time->gt($endTime)) {
            return back()->withErrors(['time' => 'Time must be between 6:00 AM and 6:00 PM.'])->withInput();
        }


        // Create schedule
        Schedule::create([
            'for' => $validated['for'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'type' => 'prenatal',
            'status' => 'pending',
            'recurrence_rule' => null,
        ]);

        return redirect()->route('maternal')->with('success', 'Schedule added successfully.');
    }
    public function addPostnatalSched(Request $request)
    {
        // validation
        $validated = $request->validate([
            'for' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
        ]);

        $date = Carbon::parse($validated['date']);
        $time = Carbon::parse($validated['time']);
        if ($date->isSaturday() || $date->isSunday()) {
            return back()->withErrors(['date' => 'Schedules cannot be set on Saturday or Sunday.'])->withInput();
        }
        $startTime = Carbon::createFromTime(6, 0, 0);
        $endTime = Carbon::createFromTime(18, 0, 0);
        if ($time->lt($startTime) || $time->gt($endTime)) {
            return back()->withErrors(['time' => 'Time must be between 6:00 AM and 6:00 PM.'])->withInput();
        }


        // Create schedule
        Schedule::create([
            'for' => $validated['for'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'type' => 'postnatal',
            'status' => 'pending',
            'recurrence_rule' => null,
        ]);

        return redirect()->route('maternal')->with('success', 'Schedule added successfully.');
    }

    public function addImmunizationSched(Request $request)
    {
        // validation
        $validated = $request->validate([
            'for' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
        ]);

        $date = Carbon::parse($validated['date']);
        $time = Carbon::parse($validated['time']);
        if ($date->isSaturday() || $date->isSunday()) {
            return back()->withErrors(['date' => 'Schedules cannot be set on Saturday or Sunday.'])->withInput();
        }
        $startTime = Carbon::createFromTime(6, 0, 0);
        $endTime = Carbon::createFromTime(18, 0, 0);
        if ($time->lt($startTime) || $time->gt($endTime)) {
            return back()->withErrors(['time' => 'Time must be between 6:00 AM and 6:00 PM.'])->withInput();
        }


        // Create schedule
        Schedule::create([
            'for' => $validated['for'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'type' => 'immunization',
            'status' => 'pending',
            'recurrence_rule' => null,
        ]);

        return redirect()->route('child')->with('success', 'Schedule added successfully.');
    }

    public function done($id)
    {

        // dd($id);
        // Find the schedule by ID and check if status is pending
        $sched = Schedule::where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        // Update status
        $sched->update([
            'status' => 'done'
        ]);

        return redirect()->back();
    }
}
