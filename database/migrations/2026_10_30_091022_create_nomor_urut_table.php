<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nomor_urut', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->unique();
            $table->unsignedBigInteger('nilai')->default(0);
            $table->timestamps();
        });

        // Ambil nomor NIJ terbesar yang sudah ada.
        $lastNumber = DB::table('jemaat')
            ->where('no_jemaat', 'like', 'NIJ-%')
            ->selectRaw(
                'MAX(CAST(SUBSTRING(no_jemaat, 5) AS UNSIGNED)) as nomor'
            )
            ->value('nomor');

        // Inisialisasi sequence berdasarkan data lama.
        DB::table('nomor_urut')->insert([
            'kode' => 'jemaat',
            'nilai' => (int) ($lastNumber ?? 0),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('nomor_urut');
    }
};
