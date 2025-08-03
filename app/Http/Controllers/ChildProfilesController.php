<?php

namespace App\Http\Controllers;

use App\Models\ChildProfiles;
use App\Models\MaternalProfiles;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChildProfilesController extends Controller
{
    public function index()
    {
        $mothers = MaternalProfiles::select('name')->get();
        $childProfiles = ChildProfiles::all();

        return view("admin.childProfiles", ['mothers' => $mothers, 'childProfiles' => $childProfiles]);
    }
    public function growthRecords()
    {

        return view("admin.growthRecords");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'clinic_center' => 'required|string',
            'barangay' => 'required|string',
            'purok' => 'required|string',
            'address' => 'required|string',
            'child_name' => 'required|string|unique:child_profiles,child_name',
            'child_no' => 'required|numeric',
            'family_no' => 'required|numeric',
            'sex' => 'required|in:male,female',
            'age' => 'required|numeric|min:0',
            'civil_status' => 'required|string',
            'mother_name' => 'required|string',
            'mother_occupation' => 'required|string',
            'mother_educational_level' => 'required|string',
            'mother_no_of_pregnancies' => 'required|numeric|min:0',
            'father_name' => 'required|string',
            'father_occupation' => 'required|string',
            'father_educational_level' => 'required|string',
            'birthdate' => 'required|date',
            'gestational_age_at_birth' => 'required|numeric|min:0',
            'type_of_birth' => 'required|string',
            'birth_order' => 'required|numeric|min:1',
            'weight' => 'required|numeric|min:0',
            'length' => 'required|numeric|min:0',
            'place_of_delivery' => 'required|string',
            'birth_attendant' => 'required|string',
            'date_of_birth_registration' => 'required|date',
        ]);

        $validated = $request->only(['clinic_center', 'barangay', 'purok', 'address', 'child_name', 'child_no', 'family_no', 'sex', 'age', 'civil_status', 'mother_name', 'mother_occupation', 'mother_educational_level', 'mother_no_of_pregnancies', 'father_name', 'father_occupation', 'father_educational_level', 'birthdate', 'gestational_age_at_birth', 'type_of_birth', 'birth_order', 'weight', 'length', 'mother_name', 'place_of_delivery', 'birth_attendant', 'date_of_birth_registration']);


        sleep(1);
        $childProfile = ChildProfiles::create($validated);

        return response()->json([
            'message' => 'Child Profile added successfully!',
            'childProfile' => $childProfile, // So you can append it in Alpine.js
        ]);
    }
    public function update(Request $request, $id)
    {
        $childProfile = ChildProfiles::findOrFail($id);

        $validated = $request->validate([
            'clinic_center' => 'required|string',
            'barangay' => 'required|string',
            'purok' => 'required|string',
            'address' => 'required|string',
            'child_name' => [
                'required',
                'string',
                Rule::unique('child_profiles', 'child_name')->ignore($childProfile->id),
            ],
            'child_no' => 'required|numeric',
            'family_no' => 'required|numeric',
            'sex' => 'required|in:male,female',
            'age' => 'required|numeric|min:0',
            'civil_status' => 'required|string',
            'mother_name' => 'required|string',
            'mother_occupation' => 'required|string',
            'mother_educational_level' => 'required|string',
            'mother_no_of_pregnancies' => 'required|numeric|min:0',
            'father_name' => 'required|string',
            'father_occupation' => 'required|string',
            'father_educational_level' => 'required|string',
            'birthdate' => 'required|date',
            'gestational_age_at_birth' => 'required|numeric|min:0',
            'type_of_birth' => 'required|string',
            'birth_order' => 'required|numeric|min:1',
            'weight' => 'required|numeric|min:0',
            'length' => 'required|numeric|min:0',
            'place_of_delivery' => 'required|string',
            'birth_attendant' => 'required|string',
            'date_of_birth_registration' => 'required|date',
        ]);

        sleep(1);

        $childProfile->update([
            'clinic_center' => $validated['clinic_center'],
            'barangay' => $validated['barangay'],
            'purok' => $validated['purok'],
            'address' => $validated['address'],
            'child_name' => $validated['child_name'],
            'child_no' => $validated['child_no'],
            'family_no' => $validated['family_no'],
            'sex' => $validated['sex'],
            'age' => $validated['age'],
            'civil_status' => $validated['civil_status'],
            'mother_name' => $validated['mother_name'],
            'mother_occupation' => $validated['mother_occupation'],
            'mother_educational_level' => $validated['mother_educational_level'],
            'mother_no_of_pregnancies' => $validated['mother_no_of_pregnancies'],
            'father_name' => $validated['father_name'],
            'father_occupation' => $validated['father_occupation'],
            'father_educational_level' => $validated['father_educational_level'],
            'birthdate' => $validated['birthdate'],
            'gestational_age_at_birth' => $validated['gestational_age_at_birth'],
            'type_of_birth' => $validated['type_of_birth'],
            'birth_order' => $validated['birth_order'],
            'weight' => $validated['weight'],
            'length' => $validated['length'],
            'place_of_delivery' => $validated['place_of_delivery'],
            'birth_attendant' => $validated['birth_attendant'],
            'date_of_birth_registration' => $validated['date_of_birth_registration'],
        ]);


        return response()->json([
            'message' => 'Child Profile updated successfully!',
            'childProfile' => $childProfile, // So you can append it in Alpine.js
        ]);
    }


}
