<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumRepliesTable extends Migration
{

    public function up()
    {
        if (!Schema::hasTable('forum_replies')) {
            Schema::create('forum_replies', function (Blueprint $table) {
                $table->id();
                $table->integer('forum_id')->nullable();
                $table->integer('user_id');
                $table->longText('reply');
                $table->integer('parent_id')->nullable();
                $table->integer('status')->default(1)->nullable();
                $table->integer('points')->nullable();
                $table->integer('lms_id')->default(1);
                $table->timestamps();
            });
        }
    }


    public function down()
    {
        Schema::dropIfExists('forum_replies');
    }
}
