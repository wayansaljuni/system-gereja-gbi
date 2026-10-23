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
        Schema::create('absensi_detail', function (Blueprint $table) {
            $table->id();

            $table->foreignId('absensi_id')
                ->constrained('absensi')
                ->cascadeOnDelete();

            $table->foreignId('jemaat_id')
                ->constrained('jemaat')
                ->cascadeOnDelete();

            $table->enum('status_hadir', [
                'hadir',
                'izin',
                'sakit',
                'tidak_hadir',
            ])->default('hadir');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique([
                'absensi_id',
                'jemaat_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_detail');
    }
};
