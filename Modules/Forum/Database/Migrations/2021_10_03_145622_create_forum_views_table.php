<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumViewsTable extends Migration
{

    public function up()
    {
        if (!Schema::hasTable('forum_views')) {
            Schema::create('forum_views', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->integer('forum_id');
                $table->timestamps();
                $table->integer('lms_id')->default(1);
            });
        }
    }


    public function down()
    {
        Schema::dropIfExists('forum_views');
    }
}
