<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'email',
        'password',
        'role',
        'status',
        'email_verified_at',
        'phone' // Added phone if needed
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ==================== RELATIONSHIPS ====================

    public function expertProfile()
    {
        return $this->hasOne(ExpertProfile::class);
    }

    // For clients who wrote reviews
    public function reviewsWritten()
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    // For experts who received reviews
    public function reviewsReceived()
    {
        return $this->hasManyThrough(
            Review::class,
            ExpertProfile::class,
            'user_id', // Foreign key on ExpertProfile table
            'expert_profile_id', // Foreign key on Review table
            'id', // Local key on User table
            'id' // Local key on ExpertProfile table
        );
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function appointmentsAsClient()
    {
        return $this->hasMany(Appointment::class, 'client_id');
    }

    public function appointmentsAsExpert()
    {
        return $this->hasManyThrough(
            Appointment::class,
            ExpertProfile::class,
            'user_id', // Foreign key on ExpertProfile table
            'expert_profile_id', // Foreign key on Appointment table
            'id', // Local key on User table
            'id' // Local key on ExpertProfile table
        );
    }

    // ==================== SCOPES ====================

    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    public function scopeExperts($query)
    {
        return $query->where('role', 'expert');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // ==================== HELPER METHODS ====================

    public function isExpert(): bool
    {
        return $this->role === 'expert' && $this->expertProfile !== null;
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }
    public function favoriteExperts()
    {
        return $this->hasMany(ClientFavorite::class, 'client_id');
    }
}