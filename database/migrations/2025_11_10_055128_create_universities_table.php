<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_universities_table.php
public function up()
{
    Schema::create('universities', function (Blueprint $table) {
        $table->id();
        $table->string('name_ar');
        $table->string('name_en');
        $table->string('code')->unique();
        $table->string('email')->unique();
        $table->string('phone')->nullable();
        $table->string('address')->nullable();
        $table->string('logo')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
