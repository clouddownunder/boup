<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'is_profile_pic',
        'user_id',
    ];

    public function getImageAttribute($value)
    {
        if (empty($value) || $value == 'default_image.png') {
            return asset('images/default_image.png');
        }

        return asset("storage/".$value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
