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
        if (Schema::hasColumn('candidates', 'resume_url')) {
            Schema::dropColumns('candidates', 'resume_url');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('candidates', 'resume_url')) {
            Schema::table('candidates', function (Blueprint $table) {
                $table->string('resume_url')->nullable();
            });
        }
    }
};
