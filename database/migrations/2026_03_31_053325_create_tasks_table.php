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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // The student
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete(); // The assigner
            $table->string('title');
            $table->text('description'); // For CKEditor content
            $table->enum('status', ['Assigned', 'Submitted', 'Approved', 'Rejected'])->default('Assigned');
            $table->text('user_response')->nullable();
            $table->text('admin_feedback')->nullable();
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
