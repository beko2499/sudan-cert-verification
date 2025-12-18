<?php

// app/Models/University.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = [
        'name_ar', 'name_en', 'code', 'email', 
        'phone', 'address', 'logo', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}