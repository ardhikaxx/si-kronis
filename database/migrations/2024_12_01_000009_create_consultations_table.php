<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->unique()->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('users');
            $table->foreignId('doctor_id')->constrained('users');
            $table->date('tanggal')->notNullable();
            $table->dateTime('mulai_at')->nullable();
            $table->dateTime('selesai_at')->nullable();
            $table->text('anamnesis')->nullable();
            $table->text('pemeriksaan_fisik')->nullable();
            $table->string('tekanan_darah', 20)->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->decimal('suhu_tubuh', 4, 1)->nullable();
            $table->integer('saturasi_o2')->nullable();
            $table->decimal('gula_darah', 6, 2)->nullable();
            $table->text('diagnosa')->nullable();
            $table->string('icd_code', 20)->nullable();
            $table->text('rencana_terapi')->nullable();
            $table->text('saran_dokter')->nullable();
            $table->enum('tindak_lanjut', ['none', 'kontrol', 'rujukan', 'rawat_inap'])->default('none');
            $table->date('tanggal_kontrol')->nullable();
            $table->enum('status', ['ongoing', 'completed'])->default('ongoing');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
