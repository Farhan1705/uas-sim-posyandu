<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'measurement_date',
        'weight',
        'height',
        'head_circumference',
        'color_zone',
    ];

    protected $casts = [
        'measurement_date' => 'date',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}