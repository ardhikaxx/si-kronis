<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained('prescriptions')->cascadeOnDelete();
            $table->foreignId('medicine_id')->nullable()->constrained('medicines');
            $table->string('nama_obat', 200)->notNullable();
            $table->string('dosis', 100)->notNullable();
            $table->string('frekuensi', 100)->notNullable();
            $table->string('durasi', 100)->nullable();
            $table->integer('jumlah')->default(1);
            $table->text('instruksi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
    }
};
