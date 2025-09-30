<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Foreign key: each task belongs to a user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Task fields
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();

            // Status with default 'pending'
            $table->enum('status', ['pending', 'completed'])->default('pending');

            // Category field (optional, can be null)
            $table->unsignedBigInteger('category_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
