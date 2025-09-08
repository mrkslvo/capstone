<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildProfile extends Model
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
        'mother_name',
        'mother_occupation',
        'mother_educational_level',
        'mother_no_of_pregnancies',
        'father_name',
        'father_occupation',
        'father_educational_level',
        'birthdate',
        'gestational_age_at_birth',
        'type_of_birth',
        'birth_order',
        'weight',   // ✅ add this
        'length',   // ✅ add this
        'place_of_delivery',
        'birth_attendant',
        'date_of_birth_registration',
        'maternal_profile_id',
    ];


    public function maternalProfile()
    {
        return $this->belongsTo(MaternalProfile::class, 'maternal_profile_id');
    }

    public function immunizationRecord()
    {
        return $this->hasMany(ImmunizationRecord::class, 'child_profile_id');
    }
    public function growthRecord()
    {
        return $this->hasMany(GrowthRecord::class, 'child_profile_id');
    }

}
