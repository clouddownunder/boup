<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Buyers extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'buyers';

    protected $fillable = [
        'email',
        'password',
        'device_token',
        'device_type',
        'app_version',
        'os_version',
        'device_name',
        'is_setup_profile',
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

}
