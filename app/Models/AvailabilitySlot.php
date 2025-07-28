<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AvailabilitySlot extends Model
{
    use HasFactory;

    // Status constants
    const STATUS_AVAILABLE = 'available';
    const STATUS_BOOKED = 'booked';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_BLOCKED = 'blocked';

    protected $fillable = [
        'expert_profile_id',
        'start_datetime',
        'end_datetime',
        'status',
        'recurring_pattern', // 'daily', 'weekly', 'monthly', 'custom'
        'recurring_end_date',
        'buffer_time', // in minutes
        'price', // override expert's default rate if needed
        'timezone' // store the timezone for this slot
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'recurring_end_date' => 'date',
        'buffer_time' => 'integer',
        'price' => 'decimal:2'
    ];

    protected $appends = [
        'duration',
        'formatted_time_range'
    ];

    public function expertProfile()
    {
        return $this->belongsTo(ExpertProfile::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'slot_id');
    }

    // Scopes
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_AVAILABLE)
                    ->where('start_datetime', '>', now());
    }

    public function scopeBooked(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_BOOKED);
    }

    public function scopeForExpert(Builder $query, int $expertId): Builder
    {
        return $query->where('expert_profile_id', $expertId);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('start_datetime', '>', now());
    }

    public function scopeRecurring(Builder $query): Builder
    {
        return $query->whereNotNull('recurring_pattern');
    }

    // Accessors
    public function getDurationAttribute(): int
    {
        return $this->start_datetime->diffInMinutes($this->end_datetime);
    }

    public function getFormattedTimeRangeAttribute(): string
    {
        return $this->start_datetime->format('M j, Y g:i A') . ' - ' . 
               $this->end_datetime->format('g:i A');
    }

    public function getIsRecurringAttribute(): bool
    {
        return !empty($this->recurring_pattern);
    }

    // Business logic methods
    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE && 
               $this->start_datetime > now();
    }

    public function isPast(): bool
    {
        return $this->end_datetime < now();
    }

    public function overlapsWith($start, $end): bool
    {
        return $this->start_datetime < $end && 
               $this->end_datetime > $start;
    }

    public function markAsBooked(): bool
    {
        return $this->update(['status' => self::STATUS_BOOKED]);
    }

    public function markAsAvailable(): bool
    {
        return $this->update(['status' => self::STATUS_AVAILABLE]);
    }

    // Recurrence logic
    public function generateRecurringSlots()
    {
        if (!$this->is_recurring || empty($this->recurring_end_date)) {
            return collect();
        }

        $slots = collect();
        $current = clone $this->start_datetime;
        $endDate = $this->recurring_end_date;

        while ($current <= $endDate) {
            $slots->push(new self([
                'expert_profile_id' => $this->expert_profile_id,
                'start_datetime' => clone $current,
                'end_datetime' => (clone $current)->addMinutes($this->duration),
                'status' => self::STATUS_AVAILABLE,
                'buffer_time' => $this->buffer_time,
                'price' => $this->price,
                'timezone' => $this->timezone
            ]));

            // Move to next occurrence based on pattern
            switch ($this->recurring_pattern) {
                case 'daily':
                    $current->addDay();
                    break;
                case 'weekly':
                    $current->addWeek();
                    break;
                case 'monthly':
                    $current->addMonth();
                    break;
                default:
                    break 2; // Exit both switch and while
            }
        }

        return $slots;
    }
}