<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Crypt;

class Certificate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'certificate_number', 'university_id', 'student_name_ar',
        'student_name_en', 'student_id', 'program_ar', 'program_en',
        'faculty_ar', 'faculty_en', 'graduation_year', 'grade',
        'gpa', 'issue_date', 'qr_code', 'pdf_file', 'notes', 'status'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'gpa' => 'decimal:2',
    ];

    /**
     * تشفير وفك تشفير العمود notes تلقائيًا
     */
    protected function notes(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Crypt::decryptString($value) : null,
            set: fn ($value) => $value ? Crypt::encryptString($value) : null,
        );
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function verificationLogs()
    {
        return $this->hasMany(VerificationLog::class);
    }

    public function getVerificationUrlAttribute()
    {
        return route('certificate.show', $this->certificate_number);
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }
}
