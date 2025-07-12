<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'expert_profile_id',
        'client_id',
        'slot_id',
        'start_datetime',
        'end_datetime',
        'status',
        'notes',
        'client_notes',
        'expert_notes',
        'cancellation_reason',
        'cancelled_by',
        'reminder_sent'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'reminder_sent' => 'boolean'
    ];

    public function expertProfile()
    {
        return $this->belongsTo(ExpertProfile::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function slot()
    {
        return $this->belongsTo(AvailabilitySlot::class, 'slot_id');
    }
    // app/Models/Appointment.php
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function session()
    {
        return $this->hasOne(Session::class);
    }
    public function consultationSession()
    {
        return $this->hasOne(ConsultationSession::class, 'appointment_id');
    }
    public function rescheduleRequests()
    {
        return $this->hasMany(RescheduleRequest::class);
    }
}