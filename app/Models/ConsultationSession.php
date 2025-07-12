<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationSession extends Model
{
    use HasFactory;

    protected $table = 'consultation_sessions';

    protected $fillable = [
        'appointment_id',
        'start_time',
        'end_time',
        'status',
        'meeting_url',
        'meeting_platform',
        'meeting_id',
        'notes',
        'recording_url'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function expert()
    {
        return $this->hasOneThrough(
            User::class,
            Appointment::class,
            'id',
            'id',
            'appointment_id',
            'expert_profile_id'
        );
    }

    public function client()
    {
        return $this->hasOneThrough(
            User::class,
            Appointment::class,
            'id',
            'id',
            'appointment_id',
            'client_id'
        );
    }
}