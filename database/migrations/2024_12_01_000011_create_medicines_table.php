<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique()->notNullable();
            $table->string('nama', 200)->notNullable();
            $table->string('nama_generik', 200)->nullable();
            $table->string('kategori', 100)->nullable();
            $table->string('satuan', 50)->default('Tablet');
            $table->text('deskripsi')->nullable();
            $table->text('kontraindikasi')->nullable();
            $table->text('efek_samping')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
