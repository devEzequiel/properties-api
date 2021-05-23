<?php

namespace App\Models\Api\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $table = 'user_profile';
    protected $fillable = [
        'about', 'social_networks', 'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
