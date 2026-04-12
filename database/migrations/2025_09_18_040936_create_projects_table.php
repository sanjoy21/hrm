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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->text('project_details');
            $table->unsignedBigInteger('employee');
            $table->unsignedBigInteger('employer');
            $table->date('assign_date');
            $table->date('deadline');
            $table->string('status')->nullable();
            $table->string('progress')->nullable();
            $table->date('submission_date')->nullable();
            $table->timestamps();
            $table->foreign('employee')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('employer')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
