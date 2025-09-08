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
        Schema::create('immunization_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $table->string('vaccine_name');
            $table->date('date_of_vaccination');
            $table->decimal('weight', 5, 2);
            $table->decimal('height', 5, 2);
            $table->string('type_of_feeding');
            $table->text('notes')->nullable();
            $table->string('status')->default('partially');
            $table->string('reaction')->nullable();
            $table->string('health_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('immunization_records');
    }
};
