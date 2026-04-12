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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->date('dob');
            $table->string('blood_group')->nullable();
            $table->string('gender');
            $table->string('mobile')->unique();
            $table->string('nid')->unique();
            $table->enum('role', ['admin','army', 'management', 'employee'])->default('employee');
            $table->string('status')->nullable();
            $table->text('address')->nullable();
            $table->string('image')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('resigning_date')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_person')->nullable();
            $table->string('relation')->nullable();
            $table->unsignedBigInteger('department')->nullable();
            $table->unsignedBigInteger('office')->nullable();
            $table->text('educational_qualification')->nullable();
            $table->string('experience')->nullable();
            $table->string('designation')->nullable();
            $table->string('joined_as')->nullable();
            $table->string('starting_salary')->nullable();
            $table->string('account_no')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('department')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('office')->references('id')->on('offices')->onDelete('cascade');

        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
