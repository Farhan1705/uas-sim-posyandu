<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mother_id',
        'birth_date',
        'gender',
        'nutrition_status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function mother()
    {
        return $this->belongsTo(PregnantWoman::class, 'mother_id');
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function immunizations()
    {
        return $this->hasMany(Immunization::class);
    }

    public function getAgeInMonthsAttribute()
    {
        return $this->birth_date->diffInMonths(Carbon::now());
    }
}