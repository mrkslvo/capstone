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
        Schema::create('maternal_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('name');
            $table->string('spouse_name');
            $table->string('birthdate');
            $table->string('age');
            $table->string('address');
            $table->string('contact_number');
            $table->string('civil_status');
            $table->string('philhealth_no');
            $table->string('family_serial_no');
            $table->string('nhts_status');
            $table->string('blood_type');
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
