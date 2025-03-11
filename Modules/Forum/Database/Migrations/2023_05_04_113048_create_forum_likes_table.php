<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumLikesTable extends Migration
{
    public function up()
    {
        Schema::create('forum_likes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('forum_id');
            $table->integer('lms_id')->default(1);
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
        Schema::dropIfExists('forum_likes');
    }
}
