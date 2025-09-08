<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{

    public function updateDelivery(Request $request, Delivery $delivery)
    {
        $fields = $request->validate([
            'place'            => 'nullable|string',
            'birth_attendant' => 'nullable|string',
            'date'      => 'nullable|date|after_or_equal:today',
            'type'      => 'nullable|string',
            'complication'      => 'nullable|string',
            'remarks'      => 'nullable|string',
        ]);

        //  Update the specific record
        $delivery->update($fields);

        return redirect()
            ->route('maternal')
            ->with('success', 'Delivery Record updated successfully.');
    }
}
