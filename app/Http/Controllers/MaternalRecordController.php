<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\MaternalProfile;
use App\Models\MaternalRecord;
use Illuminate\Http\Request;

class MaternalRecordController extends Controller
{
    public function addRecord(MaternalProfile $maternalProfile)
    {


        $maternalRecord = MaternalRecord::create([
            'maternal_profile_id' => $maternalProfile->id,
            'lmp'                => null,
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
            'status'             => 'active',
            'maternal_record_no' => MaternalRecord::max('maternal_record_no') + 1,
            'isPresent'          => 'yes',
            'isCompleted'        => 'ongoing',
        ]);

        $delivery = Delivery::create([
            'maternal_profile_id' => $maternalProfile->id,
            'place' => null,
            'birth_attendant' => null,
            'date' => null,
            'type' => null,
            'complication' => null,
            'remarks' => null
        ]);

        return redirect()->route('maternal')
            ->with('success', 'Maternal Record added successfully.');
    }

    public function updateRecord(Request $request, MaternalRecord $maternalRecord)
    {
        $fields = $request->validate([
            'lmp'            => 'nullable|date',
            'ecd'            => 'nullable|date',
            'ob_score_g'     => 'nullable|integer|min:1',
            'ob_score_p'     => 'nullable|integer|min:1',
            'ob_score_t'     => 'nullable|integer|min:1',
            'ob_score_l'     => 'nullable|integer|min:1',
            'ob_score_a'     => 'nullable|integer|min:1',
            'allergies'      => 'nullable|string',
            'tt_status'      => 'nullable|string',
            'assessment'     => 'nullable|string',
            'treatment'      => 'nullable|string',
            'status'         => 'nullable|string',
            'past_deliveries' => 'nullable|string',
            'high_risk'      => 'nullable|string',
        ]);

        // Update the specific record
        $maternalRecord->update($fields);

        return redirect()
            ->route('maternal')
            ->with('success', 'Maternal Record updated successfully.');
    }
}
