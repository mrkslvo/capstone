<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImmunizationRecord extends Model
{
    protected $fillable = [
        'child_profile_id',
        'vaccine_name',
        'date_of_vaccination',
        'weight',
        'height',
        'type_of_feeding',
        'notes',
        'status',
        'reaction',
        'health_status',
    ];

    public function childProfiles()
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }
}
