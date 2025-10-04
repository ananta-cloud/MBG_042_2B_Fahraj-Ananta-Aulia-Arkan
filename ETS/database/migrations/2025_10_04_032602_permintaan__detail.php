<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('permintaan_detail')) {
            Schema::create('permintaan_detail', function (Blueprint $table) {
                $table->id();
                $table->foreignId('permintaan_id')->constrained('permintaan')->onDelete('cascade')->comment('Relasi ke tabel permintaan');
                $table->foreignId('bahan_id')->nullable()->constrained('bahan_baku')->onDelete('set null')->comment('Relasi ke tabel bahan_baku');
                $table->integer('jumlah_diminta')->comment('Jumlah bahan diminta');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_detail');
    }
};
