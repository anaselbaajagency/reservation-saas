<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Add this line
use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    use HasFactory; // Add this trait

    protected $fillable = [
        'expert_profile_id',
        'start_datetime',
        'end_datetime',
        'status',
        'recurring_pattern',
        'recurring_end_date',
        'buffer_time',
        'price'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'recurring_end_date' => 'date'
    ];

    public function expertProfile()
    {
        return $this->belongsTo(ExpertProfile::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'slot_id');
    }
}