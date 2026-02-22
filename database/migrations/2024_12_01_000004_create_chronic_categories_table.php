<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chronic_categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->notNullable();
            $table->string('slug', 120)->unique()->notNullable();
            $table->text('deskripsi')->nullable();
            $table->string('icon', 100)->nullable();
            $table->string('warna', 20)->default('#007bff');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chronic_categories');
    }
};
