<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_certificates_table.php
public function up()
{
    Schema::create('certificates', function (Blueprint $table) {
        $table->id();
        $table->string('certificate_number')->unique();
        $table->foreignId('university_id')->constrained()->onDelete('cascade');
        $table->string('student_name_ar');
        $table->string('student_name_en')->nullable();
        $table->string('student_id');
        $table->string('program_ar');
        $table->string('program_en')->nullable();
        $table->string('faculty_ar');
        $table->string('faculty_en')->nullable();
        $table->year('graduation_year');
        $table->string('grade'); // ممتاز، جيد جداً، إلخ
        $table->decimal('gpa', 3, 2)->nullable();
        $table->date('issue_date');
        $table->string('qr_code')->nullable();
        $table->string('pdf_file')->nullable();
        $table->text('notes')->nullable();
        $table->enum('status', ['verified', 'pending', 'suspended'])->default('verified');
        $table->timestamps();
        $table->softDeletes();
        
        $table->index(['certificate_number', 'student_id']);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
