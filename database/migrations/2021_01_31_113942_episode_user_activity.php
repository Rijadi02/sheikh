<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EpisodeUserActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episode_user', function (Blueprint $table) {
            $table->id();
            $table->integer('episode_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamp('watch_later')->nullable();
            $table->timestamp('download')->nullable();
            $table->timestamp('history')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episode_user');
    }
}
