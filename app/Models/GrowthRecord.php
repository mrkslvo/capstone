<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrowthRecord extends Model
{

    protected $fillable = [
        'child_profile_id',
        'date',
        'age_in_months',
        'weight',
        'height',
        'supplement_given',
        'assessment',
        'status',
    ];
    public function childProfiles()
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }
}
