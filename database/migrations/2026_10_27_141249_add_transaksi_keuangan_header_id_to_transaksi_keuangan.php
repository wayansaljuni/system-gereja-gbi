<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambahkan kolom terlebih dahulu
        if (! Schema::hasColumn('transaksi_keuangan', 'transaksi_keuangan_header_id')) {
            Schema::table('transaksi_keuangan', function (Blueprint $table) {
                $table->unsignedBigInteger('transaksi_keuangan_header_id')
                    ->after('id');
            });
        }

        // 2. Tambahkan foreign key setelah kolom tersedia
        Schema::table('transaksi_keuangan', function (Blueprint $table) {
            $table->foreign(
                'transaksi_keuangan_header_id',
                'transaksi_keuangan_header_fk'
            )
            ->references('id')
            ->on('transaksi_keuangan_header')
            ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        // Hapus FK terlebih dahulu
        Schema::table('transaksi_keuangan', function (Blueprint $table) {
            $table->dropForeign('transaksi_keuangan_header_fk');
        });

        // Kemudian hapus kolom
        Schema::table('transaksi_keuangan', function (Blueprint $table) {
            $table->dropColumn('transaksi_keuangan_header_id');
        });
    }
};
