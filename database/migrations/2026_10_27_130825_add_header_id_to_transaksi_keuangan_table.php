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
        Schema::table('transaksi_keuangan', function (Blueprint $table) {
            $table->foreignId('transaksi_keuangan_header_id')
                ->nullable()
                ->after('id')
                ->nullOnDelete();            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_keuangan', function (Blueprint $table) {
            $table->dropConstrainedForeignId(
                'transaksi_keuangan_header_id');            //
        });
    }
};
