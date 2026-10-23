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
        Schema::create('keluarga', function (Blueprint $table) {
            $table->id();

            $table->string('no_keluarga', 30)->nullable()->unique();
            $table->string('nama_keluarga', 150);
            $table->text('alamat')->nullable();
            $table->string('no_hp', 30)->nullable();
            $table->boolean('aktif')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluarga');
    }
};
