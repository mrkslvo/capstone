<?php

namespace App\Http\Controllers;

use App\Models\ChildProfile;
use App\Models\ImmunizationDetails;
use App\Models\MaternalProfile;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChildProfileController extends Controller
{
    // List all children
    public function index()
    {
        $children = ChildProfile::with(['maternalProfile', 'immunizationRecord', 'growthRecord'])->latest()->get();
        // dd($children->toArray());
        $schedules = Schedule::whereIn('type', ['timbang', 'immunization'])->get();


        $mothers = MaternalProfile::all(['name', 'family_serial_no']);

        return Inertia::render('Admin/Child', [
            'childProfiles' => $children,
            'mothers' => $mothers,
            'schedules' => $schedules
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'clinic_center' => 'required|string',
            'barangay' => 'required|string',
            'purok' => 'required|integer|min:1|max:50',
            'address' => 'required|string',
            'child_name' => 'required|string',
            'child_no' => 'required|integer|min:1|max:50',
            'family_no' => 'nullable|integer|min:1|max:50',
            'sex' => 'required|in:male,female',
            'age' => 'required|integer|min:1|max:59',
            'mother_name' => 'required|string',
            'mother_occupation' => 'required|string',
            'mother_educational_level' => 'required|string',
            'mother_no_of_pregnancies' => 'required|integer|min:1|max:100',
            'father_name' => 'required|string',
            'father_occupation' => 'required|string',
            'father_educational_level' => 'required|string',
            'birthdate' => 'required|date|after_or_equal:today',
            'gestational_age_at_birth' => 'required|integer|min:1|max:100',
            'type_of_birth' => 'required|string',
            'birth_order' => 'required|integer|min:1',
            'weight' => 'required|numeric|min:0|max:999.99',
            'length' => 'required|numeric|min:0|max:999.99',
            'place_of_delivery' => 'required|string',
            'birth_attendant' => 'required|string',
            'date_of_birth_registration' => 'required|date|after_or_equal:today',
        ]);

        $maternalProfile = MaternalProfile::where('name', $validated['mother_name'])->first();

        if ($maternalProfile) {
            $validated['maternal_profile_id'] = $maternalProfile->id;
            $validated['family_no'] = $maternalProfile->family_serial_no;
        } else {
            return back()->withErrors([
                'mother_name' => 'The mother does not exist in the maternal profiles.'
            ]);
        }
        $child = ChildProfile::create($validated);


        return redirect()->back()->with('success', 'Child profile registered successfully!');
    }

    public function update(Request $request, ChildProfile $childProfile)
    {
        $validated = $request->validate([
            'clinic_center' => 'required|string',
            'barangay' => 'required|string',
            'purok' => 'required|string',
            'address' => 'required|string',
            'child_name' => 'required|string',
            'child_no' => 'required|integer|min:1',
            'family_no' => 'required|integer|min:1',
            'sex' => 'required|in:male,female',
            'age' => 'required|integer|min:1',
            'mother_name' => 'required|string',
            'mother_occupation' => 'required|string',
            'mother_educational_level' => 'required|string',
            'mother_no_of_pregnancies' => 'required|integer|min:1',
            'father_name' => 'required|string',
            'father_occupation' => 'required|string',
            'father_educational_level' => 'required|string',
            'birthdate' => 'required|date',
            'gestational_age_at_birth' => 'required|integer|min:1',
            'type_of_birth' => 'required|string',
            'birth_order' => 'required|integer|min:1',
            'weight' => 'required|numeric|min:0|max:999.99',
            'length' => 'required|numeric|min:0|max:999.99',
            'place_of_delivery' => 'required|string',
            'birth_attendant' => 'required|string',
            'date_of_birth_registration' => 'required|date',
        ]);


        // ✅ Resolve maternal profile from mother_name
        $maternalProfile = MaternalProfile::where('name', $validated['mother_name'])->first();

        if ($maternalProfile) {
            $validated['maternal_profile_id'] = $maternalProfile->id;
        } else {
            return back()->withErrors([
                'mother_name' => 'The mother does not exist in the maternal profiles.'
            ]);
        }

        // ✅ Update instead of create
        $childProfile->update($validated);

        return redirect()->back()->with('success', 'Child profile updated successfully!');
    }
}
