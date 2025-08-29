<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{
    use HasFactory;

    protected $table = 'tabs';

    public function category()
    {
        return $this->hasMany(Categories::class);
    }
}
