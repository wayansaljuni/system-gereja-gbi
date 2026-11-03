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
            $table->foreignId('perpuluhan_id')
                ->nullable()
                ->after('akun_id')
                ->constrained('perpuluhan')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_keuangan', function (Blueprint $table) {
            $table->dropConstrainedForeignId('perpuluhan_id');
        });
    }
};
