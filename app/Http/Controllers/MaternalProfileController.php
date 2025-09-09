<?php

namespace App\Http\Controllers;

use App\Models\ChildProfile;
use App\Models\Delivery;
use App\Models\MaternalProfile;
use App\Models\MaternalRecord;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaternalProfileController extends Controller
{
    public function index()
    {
        $maternalProfiles = MaternalProfile::with(['maternalRecords.prenatalRecords', 'maternalRecords.postnatalRecords', 'maternalRecords.delivery'])->get();
        $schedules = Schedule::all();
        // dd($maternalProfiles->toArray());
        // dd($maternalProfiles);
        return Inertia::render('Admin/Maternal', [
            'maternalProfiles' => $maternalProfiles,
            'schedules' => $schedules
        ]);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|unique:maternal_profiles,name',
            'spouse_name' => 'required|string',
            'birthdate' => 'required|date',
            'age' => 'required|integer|max:100',
            'barangay' => 'required|max:255',
            'purok' => 'required|numeric|min:1|max:50',
            'contact_number' => 'required|digits:10',
            'civil_status' => 'required|string',
            'philhealth_no' => 'required|integer',
            'family_serial_no' => 'required|integer',
            'nhts_status' => 'required|in:nhts,4ps,ips,non-nhts',
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ]);

        $maternalProfile = MaternalProfile::create(array_merge($fields, [
            'status' => 'ongoing',
        ]));

        $maternalRecord = MaternalRecord::create([
            'maternal_profile_id' => $maternalProfile->id,
            'lmp'                => null,   // use null instead of empty string
            'ecd'                => null,
            'ob_score_g'         => null,
            'ob_score_p'         => null,
            'ob_score_t'         => null,
            'ob_score_a'         => null,
            'ob_score_l'         => null,
            'allergies'          => null,
            'tt_status'          => null,
            'assessment'         => null,
            'treatment'          => null,
            'status'             => 'active',     // instead of empty (more meaningful default)
            'maternal_record_no' => 1, // auto-incrementing record no
            'isPresent'          => 'yes',
            'isCompleted'        => 'ongoing',
        ]);

        $user = User::create([
            'fullname' => $maternalProfile->name,
            'purok' => $maternalProfile->purok,
            'username' => 'parent',
            'role' => 'parent',
            'contact_number' => $maternalProfile->contact_number,
            'password' => $maternalProfile->contact_number,
        ]);

        $delivery = Delivery::create([
            'maternal_record_id' => $maternalRecord->id,
            'place' => null,
            'birth_attendant' => null,
            'date' => null,
            'type' => null,
            'complication' => null,
            'remarks' => null
        ]);

        return redirect()->route('maternal');
    }

    public function update(Request $request, MaternalProfile $maternalProfile)
    {
        $fields = $request->validate([
            // 👇 ignores the current maternalProfile id for uniqueness check
            'name' => 'required|string|unique:maternal_profiles,name,' . $maternalProfile->id,
            'spouse_name' => 'required|string',
            'birthdate' => 'required|date|after_or_equal:today',
            'age' => 'required|integer',
            'barangay' => 'required|string|max:255',
            'purok' => 'required|numeric|min:1|max:50',
            'contact_number' => 'required|digits:10',
            'civil_status' => 'required|string',
            'philhealth_no' => 'required|integer',
            'family_serial_no' => 'required|integer',
            'nhts_status' => 'required|in:nhts,4ps,ips,non-nhts',
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ]);

        $maternalProfile->update($fields);

        return redirect()->route('maternal');
    }

    public function dashboard()
    {
        $today = Carbon::today()->addDay();


        //  First, update all outdated schedules
        Schedule::where('date', '<', $today)
            ->where('status', 'pending')
            ->update(['status' => 'missed']);

        //  Now fetch fresh data after updating
        $users = User::all();
        $schedules = Schedule::where('status', '=', 'pending')->get();
        $totalPregnancies = MaternalProfile::count();
        $newMaternalRegistration = MaternalProfile::where('status', 'ongoing')->count();
        $totalChildren = ChildProfile::count();
        $upcomingChildImmunization = Schedule::where('type', 'immunization')
            ->where('status', 'pending')
            ->count();

        return Inertia::render(
            'Admin/Dashboard',
            compact(
                'schedules',
                'totalPregnancies',
                'newMaternalRegistration',
                'totalChildren',
                'upcomingChildImmunization',
                'users'
            )
        );
    }

    public function updateMaternalRecordStatus(MaternalRecord $maternalRecord)
    {
        sleep(1);
        $maternalRecord = MaternalRecord::where('isPresent', 'yes');

        $maternalRecord->update(['isCompleted' => 'prenatal completed']);

        return redirect()->route('maternal');
    }

    public function updateMaternalRecord(MaternalRecord $maternalRecord)
    {
        sleep(1);
        $maternalRecord = MaternalRecord::where('isPresent', 'yes');

        $maternalRecord->update([
            'isPresent' => 'no',
            'isCompleted' => 'completed',
        ]);

        return redirect()->route('maternal');
    }
}
