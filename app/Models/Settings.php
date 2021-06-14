<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_settings';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zoom_key',
        'zoom_secret',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password'
    ];
}