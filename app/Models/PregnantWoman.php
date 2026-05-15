<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PregnantWoman extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'husband_name',
        'due_date',
        'gestational_age',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->hasMany(Child::class, 'mother_id');
    }
}
