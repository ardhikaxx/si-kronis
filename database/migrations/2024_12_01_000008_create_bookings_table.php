<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking', 20)->unique()->notNullable();
            $table->foreignId('patient_id')->constrained('users');
            $table->foreignId('doctor_id')->constrained('users');
            $table->date('tanggal_konsultasi')->notNullable();
            $table->time('jam_mulai')->notNullable();
            $table->time('jam_selesai')->notNullable();
            $table->text('keluhan')->notNullable();
            $table->foreignId('chronic_category_id')->nullable()->constrained('chronic_categories');
            $table->enum('tipe_konsultasi', ['online', 'offline'])->default('online');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed', 'no_show'])->default('pending');
            $table->text('catatan_pasien')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('users');
            $table->timestamp('confirmed_at')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users');
            $table->timestamp('cancelled_at')->nullable();
            $table->text('alasan_batal')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
