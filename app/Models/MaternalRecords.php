<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaternalRecords extends Model
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
        'maternal_record_no'
    ];
}
