<?php

namespace App\Http\Controllers;

use App\Models\Maternal_profiles;
use App\Models\MaternalProfiles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MaternalProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maternalProfiles = MaternalProfiles::all();
        return view("admin.maternalProfiles", ["maternalProfiles" => $maternalProfiles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:maternal_profiles,name',
            'spouse_name' => 'required|string',
            'birthdate' => 'required|date',
            'age' => 'required|integer',
            'address' => 'required|string',
            'contact_number' => 'required|string',
            'civil_status' => 'required|string',
            'philhealth_no' => 'required|string',
            'family_serial_no' => 'required|string',
            'nhts_status' => 'required|in:nhts,4ps,ips,non-nhts',
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ]);

        $validated = $request->only(['user_id' => 'null', 'name', 'spouse_name', 'birthdate', 'age', 'address', 'contact_number', 'civil_status', 'philhealth_no', 'family_serial_no', 'nhts_status', 'blood_type']);


        sleep(1);
        $maternalProfile = MaternalProfiles::create($validated);


        return response()->json([
            'message' => 'Maternal Profile added successfully!',
            'maternalProfile' => $maternalProfile, // So you can append it in Alpine.js
        ]);
    }

    /**
     * Display the specified resource.
     */// MaternalProfileController.php
    public function show($id)
    {
        $profile = MaternalProfiles::findOrFail($id);
        return response()->json($profile);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $maternalProfile = MaternalProfiles::findOrFail($id);


        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('maternal_profiles', 'name')->ignore($maternalProfile->id),
            ],
            'spouse_name' => 'required|string',
            'birthdate' => 'required|date',
            'age' => 'required|integer',
            'address' => 'required|string',
            'contact_number' => 'required|string',
            'civil_status' => 'required|string',
            'philhealth_no' => 'required|string',
            'family_serial_no' => 'required|string',
            'nhts_status' => 'required|in:nhts,4ps,ips,non-nhts',
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ]);

        sleep(1);

        $maternalProfile->update([
            'name' => $validated['name'],
            'spouse_name' => $validated['spouse_name'],
            'birthdate' => $validated['birthdate'],
            'age' => $validated['age'],
            'address' => $validated['address'],
            'contact_number' => $validated['contact_number'],
            'civil_status' => $validated['civil_status'],
            'philhealth_no' => $validated['philhealth_no'],
            'family_serial_no' => $validated['family_serial_no'],
            'nhts_status' => $validated['nhts_status'],
            'blood_type' => $validated['blood_type'],
        ]);




        return response()->json(['maternalProfile' => $maternalProfile, 'message' => 'maternal updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
