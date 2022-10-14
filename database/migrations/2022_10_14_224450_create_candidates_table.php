<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->date('birth_date');
            $table->foreignId('education_id')
                ->constrained('educations');
            $table->foreignId('applied_position_id')
                ->constrained('positions');
            $table->foreignId('last_position_id')
                ->constrained('positions');

            // Long experience will be calculated with months to facilitate specific data grouping
            $table->unsignedInteger('experience');

            $table->string('resume_url');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
};
