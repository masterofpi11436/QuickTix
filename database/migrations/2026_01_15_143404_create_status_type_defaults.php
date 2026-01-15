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
        Schema::create('status_type_defaults', function (Blueprint $table) {
            $table->enum('status_type', ['new', 'in_progress', 'completed'])->primary();
            $table->foreignId('status_id')->constrained('statuses')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_type_defaults');
    }
};
