<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Immunization extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'vaccine_name',
        'age_target',
        'date_given',
    ];

    protected $casts = [
        'date_given' => 'date',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    /**
     * Status dihitung otomatis berdasarkan tanggal lahir anak dan age_target
     * - done    : date_given sudah diisi
     * - missed  : belum diberikan dan tanggal target sudah lewat
     * - pending : belum diberikan dan tanggal target belum lewat
     */
    public function getStatusAttribute(): string
    {
        if ($this->date_given) {
            return 'done';
        }

        if ($this->child) {
            $targetDate = Carbon::parse($this->child->birth_date)->addMonths($this->age_target);
            if (now()->gt($targetDate)) {
                return 'missed';
            }
        }

        return 'pending';
    }
}