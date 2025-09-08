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
        Schema::create('maternal_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('spouse_name')->nullable();
            $table->date('birthdate');
            $table->integer('age');
            $table->string('barangay');
            $table->integer('purok');
            $table->string('contact_number', 15);
            $table->string('civil_status');
            $table->string('philhealth_no', 20)->nullable();
            $table->string('family_serial_no', 20)->nullable();
            $table->string('nhts_status')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('status')->default('ongoing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maternal_profiles');
    }
};
