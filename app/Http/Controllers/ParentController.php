<?php

namespace App\Http\Controllers;

use App\Models\ChildProfiles;
use App\Models\MaternalProfiles;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function maternalProfile()
    {
        $maternalProfiles = MaternalProfiles::all();
        return view("parent.maternalProfiles", ["maternalProfiles" => $maternalProfiles]);
    }

    public function childProfile()
    {
        $mothers = MaternalProfiles::select('name')->get();
        $childProfiles = ChildProfiles::all();

        return view("parent.childProfiles", ['mothers' => $mothers, 'childProfiles' => $childProfiles]);
    }
}
