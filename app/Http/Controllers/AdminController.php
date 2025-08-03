<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
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

        return view("admin.dashboard", [
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
    public function reports()
    {

        return view("admin.reports", ["name" => 'marksalvo']);
    }

    public function userManagement()
    {

        $users = User::all();

        return view("admin.userManagement", ['users' => $users]);

    }


}
