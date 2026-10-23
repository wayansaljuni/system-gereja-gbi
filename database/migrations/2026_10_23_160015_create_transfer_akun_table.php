<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_akun', function (Blueprint $table) {
            $table->id();

            $table->dateTime('tanggal');

            /*
             * Bisa dikaitkan dengan ibadah.
             *
             * Contoh:
             * Setelah ibadah Minggu,
             * uang Kas disetor ke BCA.
             */
            $table->foreignId('ibadah_id')
                ->nullable()
                ->constrained('ibadah')
                ->nullOnDelete();

            /*
             * Akun asal.
             *
             * Contoh:
             * Kas Gereja
             */
            $table->foreignId('akun_asal_id')
                ->constrained('akun')
                ->restrictOnDelete();

            /*
             * Akun tujuan.
             *
             * Contoh:
             * BCA Gereja
             */
            $table->foreignId('akun_tujuan_id')
                ->constrained('akun')
                ->restrictOnDelete();

            $table->decimal('jumlah', 15, 2);

            $table->string('no_referensi', 100)
                ->nullable();

            $table->text('keterangan')
                ->nullable();

            $table->timestamps();

            $table->index('tanggal');

            $table->index([
                'akun_asal_id',
                'tanggal',
            ]);

            $table->index([
                'akun_tujuan_id',
                'tanggal',
            ]);

            $table->index([
                'ibadah_id',
                'tanggal',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_akun');
    }
};