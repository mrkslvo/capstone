<?php

namespace App\Http\Controllers;

use App\Models\ChildProfiles;
use App\Models\MaternalProfiles;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BhwController extends Controller
{
    public function dashboard(Request $request)
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

        return view("bhw.dashboard", [
            'schedules' => $schedules,
            'groupedSchedules' => $grouped,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'today' => $currentMonth,
            'previousMonth' => $currentMonth->copy()->subMonth()->format('Y-m'),
            'nextMonth' => $currentMonth->copy()->addMonth()->format('Y-m'),
            'allSchedules' => Schedule::all()->where('status', 'pending'),
        ]);
    }

    public function maternalProfile()
    {
        $maternalProfiles = MaternalProfiles::all();
        return view("bhw.maternalProfiles", ["maternalProfiles" => $maternalProfiles]);
    }

    public function childProfile()
    {
        $mothers = MaternalProfiles::select('name')->get();
        $childProfiles = ChildProfiles::all();

        return view("bhw.childProfiles", ['mothers' => $mothers, 'childProfiles' => $childProfiles]);
    }

    public function schedules(Request $request)
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

        return view('bhw.schedules', [
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

}
