<?php

// app/Models/VerificationLog.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationLog extends Model
{
    protected $fillable = [
        'certificate_id', 'ip_address', 'user_agent',
        'verification_source', 'verified_at'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }
}