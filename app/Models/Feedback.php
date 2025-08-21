<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'experience',
        'version_code',
        'suggestion',
        'os_version',
        'device_type',
        'mobile_name',
        'user_id',
    ];

     /**
     * Get the user associated with the feedback.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
