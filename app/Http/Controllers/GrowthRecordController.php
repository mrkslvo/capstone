<?php

namespace App\Http\Controllers;

use App\Models\ChildProfile;
use App\Models\GrowthRecord;
use Illuminate\Http\Request;

class GrowthRecordController extends Controller
{

    private function bmi(float $bmi): string
    {
        if ($bmi < 18.5) {
            return 'underweight';
        } elseif ($bmi < 25) {
            return 'normal';
        } elseif ($bmi < 30) {
            return 'overweight';
        }
        return 'overweight';
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'child_profile_id' => 'required|exists:child_profiles,id',
            'date' => 'required|date|after_or_equal:today',
            'age_in_months' => 'required|numeric|min:1',
            'weight' => 'required|numeric|min:0|max:255',
            'height' => 'required|numeric|min:0|max:255',
            'supplement_given' => 'required|string|max:255',
            'assessment' => 'required|string|max:255',
        ]);

        $height = $fields['height'] / 100;
        $bmi = $fields['weight'] / ($height * $height);
        $bmi = round($bmi, 1);
        $status = $this->bmi($bmi);

        $growthRecord = GrowthRecord::create([...$fields, 'status' => $status]);

        return redirect()->route('child')->with('success', 'Growth Record added successfully.');;
    }
}
