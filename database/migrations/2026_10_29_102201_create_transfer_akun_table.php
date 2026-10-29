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
        Schema::create('transfer_akun', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->foreignId('ibadah_id')
                ->nullable()
                ->constrained('ibadah')
                ->nullOnDelete();
            $table->foreignId('akun_asal_id')
                ->constrained('akun')
                ->restrictOnDelete();
            $table->foreignId('akun_tujuan_id')
                ->constrained('akun')
                ->restrictOnDelete();
            $table->decimal('jumlah', 15, 2);
            $table->string('no_referensi', 100)->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('approve')->default(false);
            $table->timestamps();
            $table->index('tanggal');
            $table->index(['akun_asal_id', 'tanggal']);
            $table->index(['akun_tujuan_id', 'tanggal']);
            $table->index(['ibadah_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_akun');
    }
};
