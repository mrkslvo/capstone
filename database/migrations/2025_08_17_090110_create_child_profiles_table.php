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
        Schema::create('child_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('maternal_profile_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('clinic_center');
            $table->string('barangay');
            $table->string('purok');
            $table->string('address');

            $table->string('child_name');
            $table->smallInteger('child_no');
            $table->smallInteger('family_no');
            $table->enum('sex', ['male', 'female']);
            $table->smallInteger('age');

            $table->string('mother_name');
            $table->string('mother_occupation');
            $table->string('mother_educational_level');
            $table->smallInteger('mother_no_of_pregnancies');

            $table->string('father_name');
            $table->string('father_occupation');
            $table->string('father_educational_level');

            $table->date('birthdate');
            $table->smallInteger('gestational_age_at_birth');
            $table->string('type_of_birth');
            $table->smallInteger('birth_order');
            $table->decimal('weight', 5, 2);
            $table->decimal('length', 5, 2);
            $table->string('place_of_delivery');
            $table->string('birth_attendant');

            $table->date('date_of_birth_registration');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_profile');
    }
};
