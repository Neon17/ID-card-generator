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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('card_approve_status')->nullable(); //can be 'pending', 'approved' or null
            $table->string('card_apply_status')->nullable(); //can be 'applied' or null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('card_approve_status');
            $table->dropColumn('card_apply_status');
        });
    }
};
