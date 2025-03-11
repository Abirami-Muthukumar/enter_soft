<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInForumTable extends Migration
{
    public function up()
    {
        Schema::table('forums', function (Blueprint $table) {
            if (!Schema::hasColumn('forums', 'topic_type')) {
                $table->integer('topic_type')->default(1)->comment('1=l&d topic,2=org topic');
            }

            if (!Schema::hasColumn('forums', 'deleted_at')) {
                $table->timestamp('deleted_at')->nullable();
            }

            if (!Schema::hasColumn('forums', 'deleted_by')) {
                $table->integer('deleted_by')->default(1);
            }

            if (!Schema::hasColumn('forums', 'parent_id')) {
                $table->integer('parent_id')->default(0);
            }

            if (!Schema::hasColumn('forums', 'path_id')) {
                $table->integer('path_id')->default(0);
            }
            if (!Schema::hasColumn('forums', 'filter')) {
                $table->string('filter')->nullable();
            }

            if (!Schema::hasColumn('forums', 'total_replies')) {
                $table->integer('total_replies')->default(0);
            }

            if (!Schema::hasColumn('forums', 'total_views')) {
                $table->integer('total_views')->default(0);
            }

            if (!Schema::hasColumn('forums', 'total_likes')) {
                $table->integer('total_likes')->default(0);
            }
            if (!Schema::hasColumn('forums', 'total_threads')) {
                $table->integer('total_threads')->default(0);
            }
            if (!Schema::hasColumn('forums', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }

            if (!Schema::hasColumn('forums', 'pin')) {
                $table->tinyInteger('pin')->default(0);
            }
            if (!Schema::hasColumn('forums', 'lock')) {
                $table->tinyInteger('lock')->default(0);
            }
        });
//        topic_type
    }

    public function down()
    {
        //
    }
}
