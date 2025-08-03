<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class MaternalProfiles extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'spouse_name',
        'birthdate',
        'age',
        'address',
        'contact_number',
        'civil_status',
        'philhealth_no',
        'family_serial_no',
        'nhts_status',
        'blood_type',
    ];
}
