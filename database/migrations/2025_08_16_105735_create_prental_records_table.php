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
        Schema::create('prenatal_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maternal_record_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->decimal('weight', 5, 2);
            $table->string('blood_pressure');
            $table->integer('heart_rate');
            $table->integer('fetal_heart_rate');
            $table->decimal('fundal_height', 5, 2);
            $table->string('fetal_position');
            $table->string('swelling')->nullable();
            $table->string('nutritional_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prenatal_records');
    }
};
