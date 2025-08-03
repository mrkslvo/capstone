<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('child_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('clinic_center');
            $table->string('barangay');
            $table->string('purok');
            $table->string('address');
            $table->string('child_name');
            $table->string('child_no');
            $table->string('family_no');
            $table->string('sex');
            $table->string('age');
            $table->string('civil_status');
            $table->string('mother_name');
            $table->string('mother_occupation');
            $table->string('mother_educational_level');
            $table->string('mother_no_of_pregnancies');
            $table->string('father_name');
            $table->string('father_occupation');
            $table->string('father_educational_level');
            $table->string('birthdate');
            $table->string('gestational_age_at_birth');
            $table->string('type_of_birth');
            $table->string('birth_order');
            $table->string('weight');
            $table->string('length');
            $table->string('place_of_delivery');
            $table->string('birth_attendant');
            $table->string('date_of_birth_registration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_profiles');
    }
};
