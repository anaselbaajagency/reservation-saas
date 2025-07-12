<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

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

    // Accès rapide aux participants
    public function expert()
    {
        return $this->hasOneThrough(
            User::class,
            Appointment::class,
            'id', // Clé étrangère sur appointments
            'id', // Clé étrangère sur users
            'appointment_id', // Clé locale sur sessions
            'expert_profile_id' // Clé locale sur appointments
        );
    }

    public function client()
    {
        return $this->hasOneThrough(
            User::class,
            Appointment::class,
            'id', // Clé étrangère sur appointments
            'id', // Clé étrangère sur users
            'appointment_id', // Clé locale sur sessions
            'client_id' // Clé locale sur appointments
        );
    }
}