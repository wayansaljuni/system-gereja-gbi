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
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->string('agreement_number', 100)->unique();
            $table->foreignId('agreement_type_id')
                ->nullable()
                ->constrained('agreement_types')
                ->restrictOnDelete();
            $table->string('qty', 255);
            $table->string('title', 255);
            $table->text('pic')->nullable();
            $table->enum('sifat', [
                'Original',
                'Copy',
                'Scan',
            ])->default('Original');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedInteger('duration_value')->nullable();
            $table->enum('duration_unit', [
                'day',
                'month',
                'year',
            ])->nullable();
            $table->boolean('auto_renewal')->default(false);
            $table->unsignedInteger('renewal_period_value')->nullable();
            $table->enum('renewal_period_unit', [
                'day',
                'month',
                'year',
            ])->nullable();
            
            $table->enum('status', [
                'draft',
                'active',
                'expiring',
                'expired',
                'terminated',
                'cancelled',
            ])->default('draft');
            $table->boolean('reminder_enabled')->default(true);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
            $table->index('start_date');
            $table->index('end_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
