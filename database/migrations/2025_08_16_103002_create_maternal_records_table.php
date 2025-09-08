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
        Schema::create('maternal_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maternal_profile_id')->constrained()->cascadeOnDelete();
            $table->string('lmp')->nullable();
            $table->string('ecd')->nullable();
            $table->integer('ob_score_g')->nullable();
            $table->integer('ob_score_p')->nullable();
            $table->integer('ob_score_t')->nullable();
            $table->integer('ob_score_a')->nullable();
            $table->integer('ob_score_l')->nullable();
            $table->string('allergies')->nullable();
            $table->string('tt_status')->nullable();
            $table->string('assessment')->nullable();
            $table->string('treatment')->nullable();
            $table->string('status')->nullable();
            $table->integer('maternal_record_no');
            $table->string('isPresent')->default('yes');
            $table->string('isCompleted')->default('not complete');
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
