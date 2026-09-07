<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Migration ALTER untuk tabel `hpr` (dibuat awalnya via SQLyog).
 *
 * Catatan penting sebelum dijalankan:
 * 1. Method change() butuh package "doctrine/dbal":
 *      composer require doctrine/dbal
 * 2. Kolom-kolom date dengan default '0000-00-00' pada DDL asli
 *    diubah menjadi nullable tanpa default, karena '0000-00-00'
 *    tidak valid di strict mode MySQL 5.7+/8 dan akan error saat
 *    Eloquent/Carbon mem-parsing-nya sebagai Carbon date.
 *    -> Pastikan dulu tidak ada proses lain yang bergantung pada
 *       nilai '0000-00-00' sebagai "belum diisi" sebelum migration
 *       ini dijalankan di production.
 * 3. `tgl_update` (timestamp bawaan tabel lama) TIDAK dihapus/diubah,
 *    supaya logic existing yang mengandalkan kolom itu tetap jalan.
 *    created_at & updated_at ditambahkan terpisah sebagai standar Laravel.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Nonaktifkan strict mode sementara khusus utk session ini.
        // Diperlukan karena saat ALTER satu kolom date, MySQL ikut
        // memvalidasi ulang SEMUA kolom lain di tabel, termasuk yang
        // masih berdefault '0000-00-00' dan belum sempat diubah.
        // DB::statement("SET SESSION sql_mode = REPLACE(REPLACE(REPLACE(@@sql_mode, 'NO_ZERO_DATE', ''), 'NO_ZERO_IN_DATE', ''), 'STRICT_TRANS_TABLES', '')");
        DB::connection('mysql55')->statement(
            "SET SESSION sql_mode = REPLACE(
                REPLACE(
                    REPLACE(@@sql_mode, 'NO_ZERO_DATE', ''),
                    'NO_ZERO_IN_DATE', ''
                ),
                'STRICT_TRANS_TABLES', ''
            )"
        );
       Schema::connection('mysql55')->table('hpr', function (Blueprint $table) {
            // --- Perbaikan kolom tanggal agar valid & nullable ---
            $table->date('tgl')->nullable()->default(null)->change();
            $table->date('tglapp')->nullable()->default(null)->change();
            $table->date('tglapp1')->nullable()->default(null)->change();
            $table->date('tglapp2')->nullable()->default(null)->change();
            $table->date('tglapp3')->nullable()->default(null)->change();
            $table->date('tgldel')->nullable()->default(null)->change();
            $table->date('tglentry')->nullable()->default(null)->change();

            // --- Tambah timestamp standar Laravel ---
            $table->timestamp('created_at')->nullable()->after('tgl_update');
            $table->timestamp('updated_at')->nullable()->after('created_at');
        });
    }

    public function down(): void
    {
        // DB::statement("SET SESSION sql_mode = REPLACE(REPLACE(REPLACE(@@sql_mode, 'NO_ZERO_DATE', ''), 'NO_ZERO_IN_DATE', ''), 'STRICT_TRANS_TABLES', '')");
       DB::connection('mysql55')->statement(
            "SET SESSION sql_mode = REPLACE(
                REPLACE(
                    REPLACE(@@sql_mode, 'NO_ZERO_DATE', ''),
                    'NO_ZERO_IN_DATE', ''
                ),
                'STRICT_TRANS_TABLES', ''
            )"
        );

        Schema::connection('mysql55')->table('hpr', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
            $table->date('tgl')->default('0000-00-00')->nullable(false)->change();
            $table->date('tglapp')->default('0000-00-00')->nullable(false)->change();
            $table->date('tglapp1')->default('0000-00-00')->nullable(false)->change();
            $table->date('tglapp2')->default('0000-00-00')->nullable(false)->change();
            $table->date('tglapp3')->default('0000-00-00')->nullable(false)->change();
            $table->date('tgldel')->default('0000-00-00')->nullable(false)->change();
            $table->date('tglentry')->default('0000-00-00')->nullable(false)->change();
        });
    }
};
