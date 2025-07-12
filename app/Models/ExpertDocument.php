<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertDocument extends Model
{
    protected $table = 'expert_documents';

    protected $fillable = [
        'expert_profile_id',
        'document_type',
        'file_path',
        'status',
        'admin_notes',
        'verified_by',
        'verified_at'
    ];

    public function expertProfile()
    {
        return $this->belongsTo(ExpertProfile::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}