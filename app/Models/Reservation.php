<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
protected $table = 'appointments';
function expertProfile()
{
    return $this->belongsTo(ExpertProfile::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}
