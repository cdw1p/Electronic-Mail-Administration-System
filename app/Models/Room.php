<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'start_date',
        'is_duration',
        'is_recording',
        'is_start_meeting',
        'is_join_before_host',
        'zoom_id',
        'zoom_link'
    ];
}
