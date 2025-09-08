<?php

namespace App\Http\Controllers;

use App\Models\ImmunizationDetails;
use App\Models\ImmunizationRecord;
use Illuminate\Http\Request;

class ImmunizationRecordController extends Controller
{
    public function store(Request $request)
    {
        $fields = $request->validate([
            'child_profile_id'     => 'required|exists:child_profiles,id',
            'vaccine_name'         => 'required|string|in:bcg,hepb,penta,opv,ipv|max:255',
            'date_of_vaccination'  => 'required|date|after_or_equal:today',
            'weight'               => 'required|numeric|min:0|max:999.99',
            'height'               => 'required|numeric|min:0|max:999.99',
            'type_of_feeding'      => 'nullable|string|max:255',
            'notes'                => 'nullable|string|max:255',
            'reaction'             => 'nullable|string|max:255',
            'health_status'        => 'nullable|string|max:255',
        ]);

        // Check if the vaccine already exists for this child
        $existingVaccine = ImmunizationRecord::where('child_profile_id', $fields['child_profile_id'])
            ->where('vaccine_name', $fields['vaccine_name'])
            ->first();

        if ($existingVaccine) {
            return back()->withErrors(['vaccine_name' => 'This vaccine has already been recorded for this child.']);
        }

        // check by sequecne
        $sequence = ['bcg', 'hepb', 'penta', 'ipv', 'opv'];
        $childVaccines = ImmunizationRecord::where('child_profile_id', $fields['child_profile_id'])
            ->pluck('vaccine_name')
            ->toArray();

        $index = array_search($fields['vaccine_name'], $sequence);
        if ($index > 0) {
            $prevVaccine = $sequence[$index - 1];
            if (!in_array($prevVaccine, $childVaccines)) {
                return back()->withErrors(['vaccine_name' => "Cannot record {$fields['vaccine_name']} before {$prevVaccine}."]);
            }
        }
        // Create the record
        $immunization = ImmunizationRecord::create([...$fields, 'status' => 'partially']);

        return redirect()->route('child')->with('success', 'Immunization added successfully.');
    }
}
