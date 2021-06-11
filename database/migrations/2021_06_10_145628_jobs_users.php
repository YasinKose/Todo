<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JobsUsers extends Migration
{
    public function up()
    {
        Schema::create('jobs_users', function (Blueprint $table) {
            $table->bigInteger('jobs_id')->unsigned();
            $table->foreign('jobs_id')->references('id')->on('jobs');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('jobs_users', function (Blueprint $table) {
            //
        });
    }
}
