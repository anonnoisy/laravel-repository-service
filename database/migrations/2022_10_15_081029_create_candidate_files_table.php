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
        Schema::create('candidate_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')
                ->constrained('candidates')
                ->nullable();
            $table->string('candidate_email')->unique()->index('idx_candidate_email');
            $table->string('path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_files');
    }
};
