<?php

namespace App\Http\Controllers;

use App\Models\PostnatalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostnatalRecordController extends Controller
{
    public function store(Request $request)
    {

        $user = Auth::user();

        $fields = $request->validate([
            'maternal_record_id'   => 'required|exists:maternal_records,id',
            'checkup_date'         => 'required|date|after_or_equal:today',
            'days_after_delivery'  => 'required|numeric|max:500',
            'mother_condition'     => 'required|string|max:255',
            'baby_condition'       => 'required|string|max:255',
            'supplement'           => 'nullable|string|max:255',
            'remarks'              => 'nullable|string|max:255',
        ]);

        // dd(vars: $fields);

        PostnatalRecord::create(array_merge($fields, [
            'recorded_by' => $user->role,
        ]));

        return redirect()->route('maternal')->with('success', 'Postnatal  added successfully.');;
    }
}
