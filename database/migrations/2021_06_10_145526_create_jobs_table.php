<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->timestamp("deadline_at");
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
