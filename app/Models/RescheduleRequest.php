<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RescheduleRequest extends Model
{
    protected $table = 'reschedule_requests';

    protected $fillable = [
        'appointment_id',
        'requested_by',
        'proposed_start',
        'proposed_end',
        'status',
        'reason',
        'responded_at'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}