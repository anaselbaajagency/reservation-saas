<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider',
        'method_id',
        'details',
        'is_default'
    ];

    protected $casts = [
        'details' => 'array',
        'is_default' => 'boolean'
    ];

    // Inverse Relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}