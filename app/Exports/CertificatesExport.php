<?php
// app/Exports/CertificatesExport.php

namespace App\Exports;

use App\Models\Certificate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CertificatesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $certificates;
    
    public function __construct($certificates)
    {
        $this->certificates = $certificates;
    }
    
    public function collection()
    {
        return $this->certificates;
    }
    
    public function headings(): array
    {
        return [
            'رقم الشهادة',
            'اسم الطالب',
            'الرقم الجامعي',
            'الكلية',
            'البرنامج',
            'سنة التخرج',
            'التقدير',
            'المعدل',
            'تاريخ الإصدار',
            'الحالة',
        ];
    }
    
    public function map($certificate): array
    {
        return [
            $certificate->certificate_number,
            $certificate->student_name_ar,
            $certificate->student_id,
            $certificate->faculty_ar,
            $certificate->program_ar,
            $certificate->graduation_year,
            $certificate->grade,
            $certificate->gpa,
            $certificate->issue_date->format('Y-m-d'),
            $certificate->status === 'verified' ? 'معتمدة' : 'قيد المراجعة',
        ];
    }
}