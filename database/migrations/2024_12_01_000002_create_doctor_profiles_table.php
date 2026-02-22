<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nip', 30)->unique()->nullable();
            $table->string('str_number', 50)->nullable();
            $table->string('spesialisasi', 100)->nullable();
            $table->string('sub_spesialisasi', 100)->nullable();
            $table->string('pendidikan', 255)->nullable();
            $table->integer('pengalaman_tahun')->default(0);
            $table->decimal('biaya_konsultasi', 10, 2)->default(0);
            $table->text('tentang')->nullable();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_konsultasi')->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_profiles');
    }
};
