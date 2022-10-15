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
        Schema::table('candidate_files', function (Blueprint $table) {
            $table->after('candidate_email', function ($table) {
                $table->string('file_name');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('candidate_files', 'file_name')) {
            Schema::dropColumns('candidate_files', 'file_name');
        }
    }
};
