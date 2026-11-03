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
        Schema::create('perpuluhan', function (Blueprint $table) {
            $table->id();
            $table->string('no_kantong', 50);
            $table->foreignId('jemaat_id')
                ->nullable()
                ->constrained('jemaat')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perpuluhan');
    }
};
