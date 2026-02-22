<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('kode_resep', 20)->unique()->notNullable();
            $table->foreignId('consultation_id')->constrained('consultations');
            $table->foreignId('patient_id')->constrained('users');
            $table->foreignId('doctor_id')->constrained('users');
            $table->date('tanggal_resep')->notNullable();
            $table->text('catatan_umum')->nullable();
            $table->enum('status', ['draft', 'issued', 'dispensed', 'cancelled'])->default('issued');
            $table->foreignId('dispensed_by')->nullable()->constrained('users');
            $table->timestamp('dispensed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
