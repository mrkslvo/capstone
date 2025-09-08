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
        Schema::create('postnatal_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maternal_record_id')->constrained()->cascadeOnDelete();
            $table->date('checkup_date');
            $table->decimal('days_after_delivery');
            $table->string('mother_condition');
            $table->string('baby_condition');
            $table->string('supplement')->nullable();
            $table->string('remarks')->nullable();
            $table->string('recorded_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postnatal_records');
    }
};
