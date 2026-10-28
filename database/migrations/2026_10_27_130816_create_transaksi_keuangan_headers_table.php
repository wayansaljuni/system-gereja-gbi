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
        Schema::create('transaksi_keuangan_headers', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->foreignId('ibadah_id')
                ->constrained('ibadah')
                ->restrictOnDelete();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('tanggal');
            $table->index('ibadah_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_keuangan_headers');
    }
};
