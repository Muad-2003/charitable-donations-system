<?php

use App\Models\Beneficiary;
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
        Schema::create('donation_cases', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Beneficiary::class)->constrained();
            $table->string('title');
            $table->text('description');
            $table->Decimal('target_amount', 10, 2);
            $table->Decimal('current_amount', 10, 2)->default(0.00);
            $table->enum('status', ['active', 'pending', 'completed'])->default('active');
            $table->enum('type', ['يتيم', 'صدقة', 'علاج', 'وقف'])->default('وقف');
            $table->string('img_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_cases');
    }
};
