<?php

namespace App\Http\Controllers;

use App\Models\ChildProfile;
use App\Models\GrowthRecord;
use App\Models\ImmunizationRecord;
use App\Models\MaternalProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {

        $maternals = MaternalProfile::with('maternalRecords', 'childProfiles')->get();
        $childs = ChildProfile::with('immunizationRecord')->get();
        $growths = GrowthRecord::with('childProfiles:id,child_name,purok')->get();

        return Inertia::render('Admin/Report', compact('maternals', 'childs', 'growths'));
    }
}
