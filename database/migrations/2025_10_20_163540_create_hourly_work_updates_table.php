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
        Schema::create('hourly_work_updates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->date('date');
            $table->text('t9_10')->nullable();
            $table->text('t10_11')->nullable();
            $table->text('t11_12')->nullable();
            $table->text('t12_1')->nullable();
            $table->text('t1_2')->nullable();
            $table->text('t2_3')->nullable();
            $table->text('t3_4')->nullable();
            $table->text('t4_5')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hourly_work_updates');
    }
};
