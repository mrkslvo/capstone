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
        Schema::create('maternal_records', function (Blueprint $table) {
            $table->id();
            $table->string('maternal_profile_id');
            $table->string('lmp');
            $table->string('ecd');
            $table->string('ob_score_g');
            $table->string('ob_score_p');
            $table->string('ob_score_t');
            $table->string('ob_score_a');
            $table->string('ob_score_l');
            $table->string('allergies');
            $table->string('tt_status');
            $table->string('assessment');
            $table->string('treatment');
            $table->string('status');
            $table->string('maternal_record_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maternal_records');
    }
};
