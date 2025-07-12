<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    protected $table = 'service_packages';

    protected $fillable = [
        'expert_profile_id',
        'name',
        'description',
        'duration_minutes',
        'price',
        'is_active'
    ];

    public function expertProfile()
    {
        return $this->belongsTo(ExpertProfile::class);
    }
}