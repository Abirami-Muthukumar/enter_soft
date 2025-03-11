<?php

namespace Modules\Forum\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Forum\Entities\Forum;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\Forum\Entities\ForumReply;
use Illuminate\Support\Facades\Validator;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;

class ManageForumController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // return $request;
        try {
            $forum = new Forum();
            $forum->title = $request->title;
            $forum->description = $request->description;
            $forum->created_by = Auth::user()->id;
            $forum->group_id = $request->group ?? null;
            $forum->homework_id = $request->homework ?? null;
            $forum->course_id = $request->course ?? null;
            $forum->category_id = $request->category ?? null;
            $forum->lesson_id = $request->lesson ?? null;
            if ($request->privacy == 'on') {
                $forum->privacy = 1;
            } else {
                $forum->privacy = 0;
            }
            $forum->status = 1;
            $forum->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function EditForum($forum_id)
    {
        try {
            $forum = Forum::find($forum_id);

            $lesson_info = Lesson::find($forum->lesson_id);
            $course_info = Course::find($forum->course_id);

            if (Auth::user()->role_id == 2) {
                $courses = Course::where('status', 1)->where('type', 1)->where('user_id', Auth::user()->id)->get();

            } elseif (Auth::user()->role_id == 3) {
                $courses = Course::join('course_enrolleds', 'course_enrolleds.course_id', '=', 'courses.id')
                    ->where('course_enrolleds.user_id', Auth::user()->id)
                    ->select('courses.*')->get();
            } else {
                $courses = Course::where('status', 1)->whereHas('forums')->where('type', 1)->get();
            }

            if (Auth::user()->role_id == 1 || Auth::user()->id == $forum->created_by) {

//                $recent_discussion = Forum::where('course_id', $forum->course_id)->where('id', '!=', $forum_id)->where('status', 1)->orderBy('id', 'desc')->take(3)->get();

                return view(theme('pages.forum_form'), compact('courses', 'forum', 'course_info', 'lesson_info'));;
            } else {
                Toastr::error(trans('frontend.You are not eligible to modify forum'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function DeleteForum($forum_id)
    {
        try {
            $forum = Forum::find($forum_id);

            if (Auth::user()->role_id == 1 || Auth::user()->id == $forum->created_by) {

                $forum_replies = ForumReply::where('forum_id', $forum_id)->delete();

                $forum->delete();

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));

                return redirect()->route('forum.ViewForum', $forum->id);
            } else {
                Toastr::error(trans('frontend.You are not eligible to modify forum'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function CloseForum($forum_id)
    {
        try {
            $forum = Forum::find($forum_id);

            if (Auth::user()->role_id == 1 || Auth::user()->id == $forum->created_by) {
                $forum->is_closed = 1;
                $forum->save();

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->route('forum.ViewForum', $forum->id);
            } else {
                Toastr::error(trans('frontend.You are not eligible to modify forum'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function OpenForum($forum_id)
    {
        try {
            $forum = Forum::find($forum_id);

            if (Auth::user()->role_id == 1 || Auth::user()->id == $forum->created_by) {
                $forum->is_closed = 0;
                $forum->save();

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->route('forum.ViewForum', $forum->id);
            } else {
                Toastr::error(trans('frontend.You are not eligible to modify forum'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // return $request;
        try {
            $forum = Forum::find($request->forum_id);

            if (Auth::user()->role_id == 1 || Auth::user()->id == $forum->created_by) {

                $forum->title = $request->title;
                $forum->description = $request->description;
                if ($request->privacy == 'on') {
                    $forum->privacy = 1;
                } else {
                    $forum->privacy = 0;
                }
                $forum->status = 1;
                $forum->save();

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));

                return redirect()->route('forum.ViewForum', $forum->id);
            } else {
                Toastr::error(trans('frontend.You are not eligible to modify forum'), trans('common.Failed'));
                return redirect()->back();
            }


        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }
}
