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
        Schema::create('agreement_parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agreement_id')
                ->constrained('agreements')
                ->cascadeOnDelete();
          $table->enum('party_type', [
                'internal',
                'external',
            ])->default('external');
            $table->string('name', 255);
            $table->string('code', 50)->nullable();
            $table->string('contact_person', 150)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('tax_number', 100)->nullable();
            $table->string('role', 50)->nullable();
            $table->string('signatory_name', 150)->nullable();
            $table->string('signatory_position', 150)->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index('agreement_id');
            $table->index('party_type');
            $table->index('name');
            $table->index('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreement_parties');
    }
};
