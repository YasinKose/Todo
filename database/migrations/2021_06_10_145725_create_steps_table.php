<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepsTable extends Migration
{
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("jobs_id");
            $table->bigInteger("user_id");
            $table->string("name");
            $table->integer("status")->default("0");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('steps');
    }
}
