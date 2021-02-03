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

    public function bytes_format($size, $precision = 2)
    {


        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }

    public function time_format($time)
    {
        $hours = floor($time / 3600);
        $left_seconds = $time % 3600;
        $minutes = floor($left_seconds/60);
        $seconds = $left_seconds % 60;

        $seconds = sprintf("%02d", $seconds);

        if($hours < 1)
        {
            return "$minutes:$seconds min";
        }else
        {
            $minutes = sprintf("%02d", $minutes);
            return "$hours:$minutes:$seconds"."h";
        }
    }
}



