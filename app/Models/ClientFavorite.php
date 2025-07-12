<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientFavorite extends Model
{
    protected $table = 'client_favorites';

    protected $fillable = [
        'client_id',
        'expert_profile_id'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function expertProfile()
    {
        return $this->belongsTo(ExpertProfile::class);
    }
}