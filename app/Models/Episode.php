<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }

    public function activity()
    {
        return $this->belongsToMany(User::class)->withPivot("watch_later", "download", "history");
    }
}
