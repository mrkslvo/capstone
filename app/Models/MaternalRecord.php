<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaternalRecord extends Model
{
    protected $fillable = [
        'maternal_profile_id',
        'lmp',
        'ecd',
        'ob_score_g',
        'ob_score_p',
        'ob_score_t',
        'ob_score_a',
        'ob_score_l',
        'allergies',
        'tt_status',
        'assessment',
        'treatment',
        'status',
        'maternal_record_no',
        'isPresent',
        'isCompleted',
    ];

    public function maternalProfile()
    {
        return $this->belongsTo(MaternalProfile::class, 'maternal_profile_id');
    }

    public function prenatalRecords()
    {
        return $this->hasMany(PrenatalRecord::class, 'maternal_record_id');
    }

    public function postnatalRecords()
    {
        return $this->hasMany(PostnatalRecord::class, 'maternal_record_id');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'maternal_record_id');
    }


}
