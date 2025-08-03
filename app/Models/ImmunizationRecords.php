<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImmunizationRecords extends Model
{
     protected $fillable = [
        'child_profiiles_id',
        'vaccine_name',
        'date_given',
        'dose_no',
        'age_in_months',
        'status',


    ];
}
