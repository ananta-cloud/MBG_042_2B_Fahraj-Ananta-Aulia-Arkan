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
        if (!Schema::hasTable('permintaan')) {
            Schema::create('permintaan', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('pemohon_id');
                $table->date('tgl_masak')->comment('Tanggal rencana memasak');
                $table->string('menu_makan', 255)->comment('Deskripsi Menu');
                $table->integer('jumlah_porsi');
                $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->comment('Status Permintaan');
                $table->timestamp('created_at')->nullable()->comment('Waktu Dibuat');

                $table->foreign('pemohon_id')
                    ->references('id')->on('user')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan');
    }
};
