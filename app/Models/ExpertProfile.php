<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'timezone'
    ];

    protected $casts = [
        'verified' => 'boolean',
        'hourly_rate' => 'decimal:2',
        'rating_avg' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'expert_specialties', 'expert_profile_id', 'specialty_id')
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

    public function favorites()
    {
        return $this->hasMany(ClientFavorite::class);
    }

    public function cancellationPolicies()
    {
        return $this->hasMany(CancellationPolicy::class);
    }

    public function documents()
    {
        return $this->hasMany(ExpertDocument::class);
    }

    public function servicePackages()
    {
        return $this->hasMany(ServicePackage::class);
    }
   
}
