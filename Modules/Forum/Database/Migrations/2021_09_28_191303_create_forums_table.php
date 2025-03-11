<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumsTable extends Migration
{

    public function up()
    {
        if (!Schema::hasTable('forums')) {
            Schema::create('forums', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->longText('description');
                $table->integer('created_by');
                $table->integer('course_id')->nullable();
                $table->integer('category_id')->nullable();
                $table->integer('lesson_id')->nullable();

                $table->integer('group_id')->nullable();
                $table->integer('homework_id')->nullable();

                $table->integer('privacy')->default(1)->comment('1 = Private & 0 = Public')->nullable();
                $table->integer('status')->default(1)->nullable();
                $table->integer('view')->nullable();
                $table->integer('reply')->nullable();
                $table->integer('is_closed')->nullable();
                $table->timestamp('last_activity')->nullable();
                $table->integer('lms_id')->default(1);
                $table->timestamps();
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
        Schema::dropIfExists('forums');
    }
}
