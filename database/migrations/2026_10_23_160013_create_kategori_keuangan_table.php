<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_keuangan', function (Blueprint $table) {
            $table->id();

            $table->string('kode', 30)->unique();
            $table->string('nama', 150);

            $table->enum('tipe', [
                'pemasukan',
                'pengeluaran',
            ]);

            /*
             * Akun default.
             *
             * Contoh:
             * Perpuluhan -> Kas Gereja
             * Listrik    -> BCA Gereja
             *
             * Ini hanya default saat input transaksi.
             * Akun aktual tetap disimpan di transaksi_keuangan.
             */
            $table->foreignId('akun_default_id')
                ->nullable()
                ->constrained('akun')
                ->nullOnDelete();

            /*
             * Apakah kategori dapat dicatat
             * secara detail per jemaat.
             *
             * Contoh:
             * Perpuluhan = true
             * Persembahan Umum = true
             * Listrik = false
             */
            $table->boolean('bisa_detail_jemaat')
                ->default(false);

            $table->boolean('aktif')
                ->default(true);

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->index('tipe');
            $table->index('aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_keuangan');
    }
};