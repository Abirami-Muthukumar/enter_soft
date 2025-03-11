<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForumsColumnToHomeContentTable extends Migration
{

    public function up()
    {

        if (Schema::hasColumn('home_contents', 'key')) {
            UpdateHomeContent('forum_title', 'Forum');
        } else {
            Schema::table('home_contents', function (Blueprint $table) {
                if (!Schema::hasColumn('home_contents', 'forum_title')) {
                    $table->string('forum_title')->default('Forum');
                }
            });
        }

        if (Schema::hasColumn('home_contents', 'key')) {
            UpdateHomeContent('forum_sub_title', 'JavaScript Course From Zero to Expert!');
        } else {
            Schema::table('home_contents', function (Blueprint $table) {
                if (!Schema::hasColumn('home_contents', 'forum_sub_title')) {
                    $table->string('forum_sub_title')->default('JavaScript Course From Zero to Expert!');
                }
            });
        }
        if (Schema::hasColumn('home_contents', 'key')) {
            UpdateHomeContent('forum_banner', 'public/frontend/acslmstheme/img/banner/bradcam_bg_1.jpg');
        } else {
            Schema::table('home_contents', function (Blueprint $table) {
                if (!Schema::hasColumn('home_contents', 'forum_banner')) {
                    $table->string('forum_banner')->default('public/frontend/acslmstheme/img/banner/bradcam_bg_1.jpg');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
