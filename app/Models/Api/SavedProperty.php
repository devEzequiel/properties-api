<?php

namespace App\Models\Api;

use App\Models\Api\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedProperty extends Model
{
    use HasFactory;

    /**
     * @return [type]
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return [type]
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
