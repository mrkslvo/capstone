<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostnatalRecord extends Model
{
    protected $fillable = [
        'maternal_record_id',
        'checkup_date',
        'days_after_delivery',
        'mother_condition',
        'baby_condition',
        'supplement',
        'remarks',
        'recorded_by',
    ];

    public function maternalRecord()
    {
        return $this->belongsTo(MaternalRecord::class, 'maternal_record_id');
    }
}
