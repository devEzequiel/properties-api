<?php

namespace App\Models\Api;

use App\Models\Api\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $table = 'properties';
    protected $fillable = [
        'owner_id',
        'title',
        'description',
        'rental_price',
        'sale_price',
        'slug'
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function savedProperties()
    {
        return $this->hasMany(SavedProperty::class);
    }
}
