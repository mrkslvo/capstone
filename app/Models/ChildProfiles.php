<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildProfiles extends Model
{
    protected $fillable = [
        'clinic_center',
        'barangay',
        'purok',
        'address',
        'child_name',
        'child_no',
        'family_no',
        'sex',
        'age',
        'civil_status',
        'mother_name',
        'mother_occupation',
        'mother_educational_level',
        'mother_no_of_pregnancies',
        'father_name',
        'father_occupation',
        'father_educational_level',
        'birthdate',
        'gestational_age_at_birth',
        'mother_occupation',
        'type_of_birth',
        'birth_order',
        'weight',
        'length',
        'place_of_delivery',
        'birth_attendant',
        'date_of_birth_registration'
    ];
}
