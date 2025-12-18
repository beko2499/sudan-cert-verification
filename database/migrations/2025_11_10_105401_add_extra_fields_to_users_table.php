<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'university_id')) {
                $table->foreignId('university_id')->nullable()->constrained();
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'university_admin', 'verifier'])->default('verifier');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['university_id']);
            $table->dropColumn(['university_id', 'role', 'is_active']);
        });
    }
};