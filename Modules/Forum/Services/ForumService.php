<?php

namespace Modules\Forum\Services;

use Illuminate\Support\Facades\Auth;
use Modules\CourseSetting\Entities\Course;
use Modules\Forum\Entities\Forum;
use Modules\OrgSubscription\Entities\OrgCourseSubscription;

class ForumService
{
    public function autoTopic($type, $topic)
    {
        $course_id = 0;
        $path_id = 0;
        $category_id = 0;
        $title = '';
        $new = false;
        $status = false;
        $check = false;
        if ($type == 'topic') {
            if ($topic->type == 1 && $topic->mode_of_delivery == 1 && (bool)Settings('forum_auto_online_course_status')) {
                $status = true;
            } elseif ($topic->type == 1 && $topic->mode_of_delivery != 1 && (bool)Settings('forum_auto_offline_course_status')) {
                $status = true;
            } elseif ($topic->type == 2 && $topic->mode_of_delivery == 1 && (bool)Settings('forum_auto_online_quiz_status')) {
                $status = true;
            } elseif ($topic->type == 2 && $topic->mode_of_delivery != 1 && (bool)Settings('forum_auto_offline_quiz_status')) {
                $status = true;
            } elseif ($type == 3 && (bool)Settings('forum_auto_live_class_status')) {
                $status = true;
            }
            $check = Forum::where('course_id', $course_id)->first();
        } elseif ($type == 'path' && Settings('forum_auto_learning_path_status')) {
            $check = Forum::where('path_id', $path_id)->first();
        }

        if ($topic->type == 2 && $topic->mode_of_delivery == 1) {
            $filter = 'online_quiz';
        } elseif ($topic->type == 1 && $topic->mode_of_delivery == 1) {
            $filter = 'online_course';
        } elseif ($topic->type == 2 && $topic->mode_of_delivery != 1) {
            $filter = 'offline_quiz';
        } elseif ($topic->type == 1 && $topic->mode_of_delivery != 1) {
            $filter = 'offline_course';
        } elseif ($topic->type == 'path') {
            $filter = 'path';
        } elseif ($topic->type == 3) {
            $filter = 'live_class';
        }


        if ($check || $status) {
            $new = true;
            $title = $topic->title;
            if ($type == 'path') {
                $path_id = $topic->id;
            } else {
                $course_id = $topic->id;
            }
        }
        if ($new) {
            $forum = Forum::create([
                'title' => $title,
                'description' => $title,
                'created_by' => (int)Auth::id(),
                'course_id' => (int)$course_id,
                'path_id' => (int)$path_id,
                'category_id' => (int)$category_id,
                'filter' => $filter,
                'approved_at' => (bool)Settings('forum_auto_approval_topic_status') == true ? now() : null,
                'parent_id' => 0
            ]);

            Forum::create([
                'title' => $title,
                'description' => $title,
                'created_by' => (int)Auth::id(),
                'course_id' => (int)$course_id,
                'path_id' => (int)$path_id,
                'category_id' => (int)$category_id,
                'filter' => $filter,
                'approved_at' => (bool)Settings('forum_auto_approval_topic_status') == true ? now() : null,
                'parent_id' => $forum->id
            ]);
        }
    }

    public function autoApprove()
    {
    }
}
