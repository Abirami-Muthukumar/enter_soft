<?php

namespace Modules\Forum\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Repositories\GeneralSettingRepositoryInterface;

class SettingController extends Controller
{
    protected $generalSettingRepository;

    public function __construct(GeneralSettingRepositoryInterface $generalSettingRepository)
    {
        $this->generalSettingRepository = $generalSettingRepository;
    }

    public function index()
    {
        return view('forum::setting.index');
    }

    public function store(Request $request)
    {
        $data = [
            'forum_auto_online_course_status' => $request->get('forum_auto_online_course_status', 0),
            'forum_auto_offline_course_status' => $request->get('forum_auto_offline_course_status', 0),
            'forum_auto_live_class_status' => $request->get('forum_auto_live_class_status', 0),
            'forum_auto_online_quiz_status' => $request->get('forum_auto_online_quiz_status', 0),
            'forum_auto_offline_quiz_status' => $request->get('forum_auto_offline_quiz_status', 0),
            'forum_auto_learning_path_status' => $request->get('forum_auto_learning_path_status', 0),
            'forum_auto_approval_topic_status' => $request->get('forum_auto_approval_topic_status', 0),
            'forum_auto_approval_thread_status' => $request->get('forum_auto_approval_thread_status', 0),
        ];

        $this->generalSettingRepository->update($data);
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

}
