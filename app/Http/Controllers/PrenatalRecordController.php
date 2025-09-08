<?php

namespace App\Http\Controllers;

use App\Models\PrenatalRecord;
use Illuminate\Http\Request;

class PrenatalRecordController extends Controller
{

    public function index()
    {
        $records = PrenatalRecord::latest()->get();

        return response()->json($records);
    }

    public function store(Request $request)
    {

        $fields = $request->validate([
            'maternal_record_id' => 'required|exists:maternal_records,id',
            'date' => 'required|date|after_or_equal:today',
            'weight' => 'required|numeric|min:0|max:999.99',
            'blood_pressure' => 'required|numeric|min:0|max:999.99',
            'heart_rate' => 'required|integer|max:250',
            'fetal_heart_rate' => 'required|integer|max:250',
            'fundal_height' => 'required|numeric|min:0|max:99.99',
            'fetal_position' => 'required|string|max:100',
            'swelling' => 'nullable|string',
            'nutritional_status' => 'nullable|string|max:100',
        ]);



        $record = PrenatalRecord::create($fields);

        return redirect()->route('maternal')->with('success', 'Prenatal  added successfully.');;
    }
}
