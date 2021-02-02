<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{

    use HasFactory;

    protected $fillable = [
        'name','description','image','category_id'
    ];

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }

    public function subscribed()
    {
        return $this->belongsToMany(User::class);
    }


}
