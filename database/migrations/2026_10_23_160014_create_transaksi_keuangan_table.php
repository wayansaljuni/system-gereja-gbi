<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_keuangan', function (Blueprint $table) {
            $table->id();
            /*
             * Tanggal transaksi.
             */
            $table->dateTime('tanggal');
            /*
             * Ibadah yang berkaitan dengan transaksi.
             *
             * Nullable karena tidak semua transaksi
             * terjadi dalam ibadah.
             */
            $table->foreignId('ibadah_id')
                ->nullable()
                ->constrained('ibadah')
                ->nullOnDelete();
            /*
             * Jenis pemasukan / pengeluaran.
             */
            $table->foreignId('kategori_keuangan_id')
                ->constrained('kategori_keuangan')
                ->restrictOnDelete();
            /*
             * Akun aktual tempat uang masuk/keluar.
             *
             * Contoh:
             * Kas Gereja
             * BCA Gereja
             * BRI Gereja
             */
            $table->foreignId('akun_id')
                ->constrained('akun')
                ->restrictOnDelete();

            /*
             * Diisi jika transaksi berhubungan
             * dengan jemaat tertentu.
             *
             * Contoh:
             * Perpuluhan Budi
             * Perpuluhan Wayan
             *
             * NULL untuk transaksi umum.
             */
            $table->foreignId('jemaat_id')
                ->nullable()
                ->constrained('jemaat')
                ->nullOnDelete();

            /*
             * Cara pembayaran.
             *
             * Untuk pengeluaran juga dapat digunakan:
             * tunai atau transfer.
             */
            $table->enum('metode_pembayaran', [
                'tunai',
                'transfer',
            ])->nullable();

            $table->decimal('jumlah', 15, 2);

            /*
             * Nomor bukti transfer / kwitansi / referensi.
             */
            $table->string('no_referensi', 100)
                ->nullable();

            $table->text('keterangan')
                ->nullable();

            $table->timestamps();

            /*
             * Index untuk laporan.
             */
            $table->index('tanggal');

            $table->index([
                'akun_id',
                'tanggal',
            ]);

            $table->index([
                'ibadah_id',
                'tanggal',
            ]);

            $table->index([
                'kategori_keuangan_id',
                'tanggal',
            ]);

            $table->index([
                'jemaat_id',
                'tanggal',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_keuangan');
    }
};