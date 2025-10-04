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
        if (!Schema::hasTable('bahan_baku')) {
            Schema::create('bahan_baku', function (Blueprint $table) {
                $table->id();
                $table->string('nama', 120)->nullable()->comment('Nama Bahan');
                $table->string('kategori', 60)->nullable()->comment('Kategori Bahan');
                $table->integer('jumlah')->nullable()->comment('Stok Tersedia');
                $table->string('satuan', 20)->nullable()->comment('Satuan Bahan');
                $table->date('tanggal_masuk')->nullable();
                $table->date('tanggal_kadaluarsa')->nullable();
                $table->enum('status', ['tersedia', 'segera_kadaluarsa', 'kadaluarsa', 'habis'])->nullable();
                $table->timestamp('created_at')->nullable()->comment('Waktu Dibuat');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_baku');
    }
};
