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
        Schema::create('monthly_salary_sheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('month');
            $table->string('year');
            $table->string('salary')->nullable();
            $table->string('bonus')->nullable();
            $table->string('performance_bonus')->nullable();
            $table->string('other_add')->nullable();
            $table->string('advance')->nullable();
            $table->string('ait')->nullable();
            $table->string('revenue_stamp')->nullable();
            $table->string('late_attendance')->nullable();
            $table->string('other')->nullable();
            $table->string('total_paid');
            $table->date('date_of_payment');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_salary_sheets');
    }
};
