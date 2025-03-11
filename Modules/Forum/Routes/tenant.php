<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/forum', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/setting', 'SettingController@index')->name('forum.setting');
    Route::post('/setting', 'SettingController@store')->name('forum.setting');
    Route::get('/deleted-topic', 'DeletedForumController@topic')->name('forum.deleted_topic');
    Route::get('/deleted-thread', 'DeletedForumController@thread')->name('forum.deleted_thread');


});
Route::group(['prefix' => 'forum', 'middleware' => ['auth']], function () {
    //topic manage
    Route::get('/topic', 'ForumController@topic')->name('forum.topic');
    Route::get('/', 'ForumController@index')->name('forum.index');
    Route::get('/course/{course_id}', 'ForumController@CourseForum')->name('forum.CourseForum');
    Route::get('/course/lesson/{lesson_id}', 'ForumController@LessonForum')->name('forum.LessonForum');

    Route::get('/view/{forum_id}', 'ForumController@ViewForum')->name('forum.ViewForum');
    // Route::get('/edit/{forum_id}', 'ManageForumController@EditForum')->name('forum.topic.edit');
    Route::get('/edit-thread/{id}', 'ForumController@editThread')->name('forum.topic.edit');
    Route::post('/update-thread/{id}', 'ForumController@updateThreadSubmit')->name('forum.topic.update');

    Route::get('/edit/{forum_id}', 'ManageForumController@EditForum')->name('forum.EditForum');
    Route::get('/delete/{forum_id}', 'ManageForumController@DeleteForum')->name('forum.DeleteForum');

    Route::get('/course/{course_id}/create', 'ForumController@CreateForum')->name('forum.CreateCourseForum');
    Route::get('/lesson/{course_id}/{lesson_id?}/create', 'ForumController@CreateForum')->name('forum.CreateLessonForum');


    Route::get('/close/{forum_id}', 'ManageForumController@CloseForum')->name('forum.CloseForum');
    Route::get('/open/{forum_id}', 'ManageForumController@OpenForum')->name('forum.OpenForum');

    Route::post('/reply/store', 'ForumReplyController@ForumReply')->name('forum.ForumReply');
    Route::post('/reply/update', 'ForumReplyController@ForumReplyUpdate')->name('forum.ForumReplyUpdate');

    Route::post('/replies-reply/store', 'ForumReplyController@RepliesReply')->name('forum.RepliesReply');
    Route::post('/replies-reply/update', 'ForumReplyController@RepliesReplyUpdate')->name('forum.RepliesReplyUpdate');

    Route::post('/reply-delete', 'ForumReplyController@ReplyDelete')->name('forum.ReplyDelete');
    Route::post('/reply-of-reply/delete', 'ForumReplyController@ReplyofReplyDelete')->name('forum.ReplyofReplyDelete');

    Route::post('store', 'ManageForumController@store')->name('forum.storeForum');
    Route::post('update', 'ManageForumController@update')->name('forum.UpdateForum');


    //org
    Route::get('/create-topic', 'ForumController@createTopic')->name('forum.createTopic');
    Route::post('/create-topic', 'ForumController@createTopicSubmit');

    Route::get('/create-thread', 'ForumController@createThread')->name('forum.createThread');
    Route::post('/create-thread', 'ForumController@createThreadSubmit');
    Route::get('/get-course-list', 'ForumController@getCourseList')->name('forum.getCourseList');

    Route::get('/threads/{topic_id?}', 'ForumController@threads')->name('forum.threads');
    Route::get('/thread/{thread_id}', 'ForumController@thread')->name('forum.thread');


    Route::post('/topic/approval', 'ForumController@approval')->name('forum.topic.approval');
    Route::post('/topic/lock', 'ForumController@lock')->name('forum.topic.lock');
    Route::post('/topic/unlock', 'ForumController@unlock')->name('forum.topic.unlock');
    Route::post('/topic/pin', 'ForumController@pin')->name('forum.topic.pin');
    Route::post('/topic/unpin', 'ForumController@unpin')->name('forum.topic.unpin');
    Route::post('/topic/delete', 'ForumController@delete')->name('forum.topic.delete');

    Route::post('/topic/final-delete', 'ForumController@finalDelete')->name('forum.topic.finalDelete');
    Route::post('/topic/restore', 'ForumController@restore')->name('forum.topic.restore');

    Route::get('/thread/like-unlike/{thread_id}', 'ForumController@threadLikeUnlike')->name('forum.topic.threadLikeUnlike');
    Route::get('/reply/like-unlike/{reply_id}', 'ForumController@replyLikeUnlike')->name('forum.topic.replyLikeUnlike');
    Route::get('like-unlike-forum', 'ForumController@threadAjaxLikeUnlike')->name('like-unlike-forum');

    Route::post('/reply/approval', 'ForumReplyController@approval')->name('forum.reply.approval');
    Route::post('/reply/lock', 'ForumReplyController@lock')->name('forum.reply.lock');
    Route::post('/reply/unlock', 'ForumReplyController@unlock')->name('forum.reply.unlock');
    Route::post('/reply/pin', 'ForumReplyController@pin')->name('forum.reply.pin');
    Route::post('/reply/unpin', 'ForumReplyController@unpin')->name('forum.reply.unpin');
    Route::post('/reply/delete', 'ForumReplyController@delete')->name('forum.reply.delete');


});

Route::group(['prefix' => 'forum', 'middleware' => ['student'], 'as' => 'forum.'], function () {
    Route::get('/list', 'ForumController@studentList')->name('student_list');
});
