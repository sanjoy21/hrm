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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('office');
            $table->date('date');
            $table->string('check_in')->nullable();
            $table->string('check_in_lat')->nullable();
            $table->string('check_in_long')->nullable();
            $table->string('check_in_address')->nullable();
            $table->string('check_out')->nullable();
            $table->string('check_out_lat')->nullable();
            $table->string('check_out_long')->nullable();
            $table->string('check_out_address')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('office')->references('office')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
