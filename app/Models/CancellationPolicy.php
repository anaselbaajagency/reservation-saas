<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancellationPolicy extends Model
{
    protected $table = 'cancellation_policies';

    protected $fillable = [
        'expert_profile_id',
        'notice_hours',
        'penalty_percentage',
        'is_active'
    ];

    public function expertProfile()
    {
        return $this->belongsTo(ExpertProfile::class);
    }
}