<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    public function series()
    {
        return $this->hasMany(Serie::class);
    }

    public function subscribed()
    {
        return $this->belongsToMany(User::class)->withPivot("subscribed");
    }
}
