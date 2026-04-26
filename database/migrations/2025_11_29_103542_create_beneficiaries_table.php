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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();

            $table->string('fullName');
            $table->string('surname');
            $table->string('ssn');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('address');
            $table->string('phone_number');
            $table->text('notes')->nullable();
            $table->string('personal_photo_path')->nullable();
            $table->string('bank_statement_photo_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
