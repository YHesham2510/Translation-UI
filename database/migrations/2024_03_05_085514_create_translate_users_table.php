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
        Schema::create('translate_users', function (Blueprint $table) {
            $table->string("id");
            $table->string('item_code');
            $table ->text("arabic_translation");
            $table->text('english_translation');
            $table->string('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translate_users');
    }
};