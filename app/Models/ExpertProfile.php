<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ExpertProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'biography',
        'hourly_rate',
        'verified',
        'years_experience',
        'education',
        'certifications',
        'languages',
        'timezone',
        'is_active',
        'rating_avg'
    ];

    protected $casts = [
        'verified' => 'boolean',
        'is_active' => 'boolean',
        'hourly_rate' => 'decimal:2',
        'rating_avg' => 'decimal:2'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'expert_specialties')
                    ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function payments()
    {
        return $this->hasManyThrough(
            Payment::class,
            Appointment::class,
            'expert_profile_id',
            'appointment_id'
        );
    }

    public function availabilitySlots()
    {
        return $this->hasMany(AvailabilitySlot::class);
    }

    public function availableSlots()
    {
        return $this->hasMany(AvailabilitySlot::class)
                   ->where('status', AvailabilitySlot::STATUS_AVAILABLE)
                   ->where('start_datetime', '>', now());
    }

    public function bookedSlots()
    {
        return $this->hasMany(AvailabilitySlot::class)
                   ->where('status', AvailabilitySlot::STATUS_BOOKED);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('verified', true);
    }

    public function scopeHasAvailability(Builder $query): Builder
    {
        return $query->whereHas('availableSlots');
    }

    // Business Logic Methods
    public function isAvailableBetween($start, $end): bool
    {
        return $this->availableSlots()
                   ->where('start_datetime', '<=', $start)
                   ->where('end_datetime', '>=', $end)
                   ->exists();
    }

    public function nextAvailableSlot()
    {
        return $this->availableSlots()
                   ->orderBy('start_datetime')
                   ->first();
    }

    public function createAvailabilitySlot(array $data): AvailabilitySlot
    {
        return $this->availabilitySlots()->create(array_merge([
            'timezone' => $this->timezone,
            'price' => $this->hourly_rate,
            'status' => AvailabilitySlot::STATUS_AVAILABLE
        ], $data));
    }

    public function generateRecurringSlots(array $slotData, string $pattern, string $endDate)
    {
        $baseSlot = $this->createAvailabilitySlot(array_merge($slotData, [
            'recurring_pattern' => $pattern,
            'recurring_end_date' => $endDate
        ]));

        return $baseSlot->generateRecurringSlots();
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}