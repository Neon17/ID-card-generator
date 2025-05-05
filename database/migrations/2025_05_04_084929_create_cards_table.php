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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company_name')->default('ACME');
            $table->string('company_logo')->nullable();
            $table->string('company_type')->default('Authorized User Identification');
            $table->string('department');
            $table->string('dob');
            $table->string('address');
            $table->string('qr_code')->nullable();
            $table->string('user_id')->nullable();
            $table->string('photo')->nullable();
            $table->string('approve_status')->default('active');
            $table->date('approve_date')->nullable();
            $table->string('approve_by')->nullable();
            $table->float('duration_in_years')->default('5')->nullable();
            $table->string('message')->nullable();
            $table->string('message_by_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
