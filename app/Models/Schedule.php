<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['for', 'date', 'time', 'type', 'status', 'recurrence_rule'];

    // A schedule belongs to a child

}
