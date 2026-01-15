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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_template_id')
                ->nullable()
                ->constrained('ticket_templates')
                ->nullOnDelete();

            $table->string('title');
            $table->text('description');
            $table->text('notes')->nullable();

            $table->foreignId('submitted_by_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('submitted_by_name');

            $table->foreignId('assigned_to_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('assigned_to_name')->nullable();

            $table->foreignId('assigned_by_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('assigned_by_name')->nullable();

            $table->string('department');
            $table->string('area');

            // This is your reporting field
            $table->enum('status_type', ['new', 'in_progress', 'completed'])->default('new');

            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            // indexes for reporting
            $table->index('status_type');
            $table->index(['status_type', 'area']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
