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
        Schema::create('jemaat', function (Blueprint $table) {
            $table->id();

            $table->string('no_jemaat', 30)->nullable()->unique();
            $table->string('no_kantong', 30)->nullable()->unique();

            $table->foreignId('keluarga_id')
                ->nullable()
                ->constrained('keluarga')
                ->nullOnDelete();

            $table->foreignId('organisasi_id')
                ->nullable()
                ->constrained('keluarga')
                ->nullOnDelete();

            $table->foreignId('kelompok_id')
                ->nullable()
                ->constrained('kelompok')
                ->nullOnDelete();

            $table->string('nama', 150);

            $table->enum('jenis_kelamin', [
                'L',
                'P',
            ])->nullable();

            $table->date('tanggal_lahir')->nullable();

            $table->string('no_hp', 30)->nullable();
            $table->text('alamat')->nullable();

            $table->boolean('aktif')->default(true);

            $table->timestamps();

            $table->index('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jemaat');
    }
};
