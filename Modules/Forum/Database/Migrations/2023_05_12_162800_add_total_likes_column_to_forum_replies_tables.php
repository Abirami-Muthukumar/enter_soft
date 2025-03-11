<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalLikesColumnToForumRepliesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_replies', function (Blueprint $table) {
            if (!Schema::hasColumn('forum_replies', 'total_likes')) {
                $table->integer('total_likes')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
