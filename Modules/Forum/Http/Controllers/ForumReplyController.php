<?php

namespace Modules\Forum\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Forum\Entities\Forum;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\Forum\Entities\ForumReply;
use Illuminate\Support\Facades\Validator;

class ForumReplyController extends Controller
{
    public function ForumReply(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'reply' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $reply = new ForumReply();
            $reply->forum_id = $request->forum_id;
            $reply->reply = $request->reply;
            $reply->user_id = Auth::id();
            $reply->points = 100;
            $reply->pin = isset($request->pin) ? 1 : 0;
            $reply->save();

            $total_reply = ForumReply::where('forum_id', $request->forum_id)->count();
            Forum::where('id', $request->forum_id)->update([
                'last_activity' => now(),
                'total_replies' => $total_reply
            ]);
            $forum = Forum::findOrFail($request->forum_id);
            $course_id = $forum->course_id;
            $parent = Forum::find($forum->parent_id);
            if ($parent) {
                $parent->update(['total_replies' => $total_reply]);
                $course_id = $parent->course_id;
            }
            if (richTextWordLength($request->reply) >= 20) {
                orgLeaderboardPointCheck('Interaction', Settings('answer_thread'), $course_id, 'answer_thread');
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function ForumReplyUpdate(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'reply' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $reply = ForumReply::find($request->reply_id);
            $reply->forum_id = $request->forum_id;
            $reply->reply = $request->reply;
            $reply->user_id = Auth::user()->id;
            $reply->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function RepliesReply(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'forum_id' => 'required',
                'reply_id' => 'required',
                'reply' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $reply = new ForumReply();
            $reply->forum_id = $request->forum_id;
            $reply->reply = $request->reply;
            $reply->parent_id = $request->reply_id;
            $reply->user_id = Auth::user()->id;
            $reply->save();
            $forum = Forum::findOrFail($request->forum_id);

            if (richTextWordLength($request->reply) >= 20) {
                orgLeaderboardPointCheck('Interaction', Settings('answer_thread'), $forum->course_id, 'answer_thread');
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function RepliesReplyUpdate(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'forum_id' => 'required',
                'reply_id' => 'required',
                'second_reply_id' => 'required',
                'reply' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $reply = ForumReply::find($request->second_reply_id);

            $reply->reply = $request->reply;
            $reply->parent_id = $request->reply_id;
            $reply->user_id = Auth::user()->id;
            $reply->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function ReplyDelete(Request $request)
    {
        try {
            $reply = ForumReply::find($request->reply_id);
            $forum = Forum::find($reply->forum_id);
            if (Auth::user()->role_id == 1 || Auth::user()->id == $reply->user_id) {
                $child = ForumReply::where('parent_id', $reply->id)->delete();
                $reply->delete();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error(trans('frontend.You are not eligible to modify this reply'), trans('common.Failed'));
                return redirect()->back();
            }

        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
        //    return $reply_id;
    }

    public function ReplyofReplyDelete(Request $request)
    {
        try {
            //    return $request;
            $reply = ForumReply::find($request->reply_id);
            $forum = Forum::find($reply->parent_id);
            if (Auth::user()->role_id == 1 || Auth::user()->id == $reply->user_id) {
                $child = ForumReply::where('parent_id', $reply->id)->delete();
                $reply->delete();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error(trans('frontend.You are not eligible to modify this reply'), trans('common.Failed'));

                 return redirect()->back();
            }

        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }


//    -------------

//forum actions
    public function approval(Request $request)
    {
        $forum = ForumReply::findOrFail($request->item_id);
        $forum->approved_at = now();
        $forum->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function pin(Request $request)
    {
        $forum = ForumReply::findOrFail($request->item_id);
        $forum->pin = 1;
        $forum->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function unpin(Request $request)
    {
        $forum = ForumReply::findOrFail($request->item_id);
        $forum->pin = 0;
        $forum->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function lock(Request $request)
    {
        $forum = ForumReply::findOrFail($request->item_id);
        $forum->lock = 1;
        $forum->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function unlock(Request $request)
    {
        $forum = ForumReply::findOrFail($request->item_id);
        $forum->lock = 0;
        $forum->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $forum = ForumReply::findOrFail($request->item_id);
        $forum->deleted_at = now();
        $forum->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }
}
