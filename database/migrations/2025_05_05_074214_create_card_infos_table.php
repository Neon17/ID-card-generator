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
        Schema::create('card_infos', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->default('ACME CORPORATION');
            $table->string('company_logo')->nullable();
            $table->string('company_type')->default('Authorized Employee Identification');
            $table->string('company_address')->nullable();
            $table->string('custom_message')->nullable();
            $table->integer('card_duration')->default(5); // in years
            $table->string('card_type')->nullable();
            $table->string('select_fields')->nullable(); //select fields of user like name, address and place in card
            $table->string('select_fields_type')->nullable();
            $table->integer('number_of_guests_printed')->default(0);
            $table->string('card_color')->nullable();
            $table->string('card_background')->nullable();
            $table->string('card_background_color')->nullable();
            $table->string('card_background_image')->nullable();
            $table->string('card_background_image_type')->nullable();
            $table->string('card_background_image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_infos');
    }
};
