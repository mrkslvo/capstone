<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'maternal_record_id',
        'place',
        'birth_attendant',
        'date',
        'type',
        'complication',
        'remarks',
    ];
    public function maternalRecords()
    {
        return $this->belongsTo(MaternalRecord::class, 'maternal_record_id');
    }
}
