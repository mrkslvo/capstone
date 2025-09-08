<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrenatalRecord extends Model
{
    protected $fillable = [
        'maternal_record_id',
        'date',
        'weight',
        'blood_pressure',
        'heart_rate',
        'fetal_heart_rate',
        'fundal_height',
        'fetal_position',
        'swelling',
        'nutritional_status',
    ];

    public function maternalRecord()
    {
        return $this->belongsTo(MaternalRecord::class, 'maternal_record_id');
    }
}
