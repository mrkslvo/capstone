<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class MaternalProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'spouse_name',
        'birthdate',
        'age',
        'barangay',
        'purok',
        'contact_number',
        'civil_status',
        'philhealth_no',
        'family_serial_no',
        'nhts_status',
        'blood_type',
        'status',
    ];

    public function maternalRecords()
    {
        return $this->hasMany(MaternalRecord::class, 'maternal_profile_id');
    }
    public function childProfiles()
    {
        return $this->hasMany(ChildProfile::class, 'maternal_profile_id');
    }

}
