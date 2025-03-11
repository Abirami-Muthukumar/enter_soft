<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumReplyLikesTable extends Migration
{
    public function up()
    {
        Schema::create('forum_reply_likes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('reply_id');
            $table->integer('lms_id')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('forum_reply_likes');
    }
}
