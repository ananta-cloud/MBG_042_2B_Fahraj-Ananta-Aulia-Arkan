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
        if (!Schema::hasTable('user')) {
            Schema::create('user', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100)->unique();
                $table->string('email', 150)->unique();
                $table->string('password')->comment('Hashed Password');
                $table->enum('role', ['gudang', 'dapur']);
                $table->timestamp('created_at')->nullable()->comment('Waktu Dibuat');
            });
        };
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
