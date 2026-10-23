<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akun', function (Blueprint $table) {
            $table->id();

            $table->string('kode', 20)->unique();
            $table->string('nama', 100);

            $table->enum('jenis', [
                'kas',
                'bank',
            ]);

            // Khusus akun bank
            $table->string('nama_bank', 100)->nullable();
            $table->string('no_rekening', 50)->nullable();
            $table->string('nama_rekening', 150)->nullable();

            // Saldo awal saat sistem mulai digunakan
            $table->decimal('saldo_awal', 15, 2)->default(0);

            $table->boolean('aktif')->default(true);

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->index('jenis');
            $table->index('aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
};