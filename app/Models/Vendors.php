<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Vendors extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'vendors';
    protected $fillable = [
        'password',
    ];

}
