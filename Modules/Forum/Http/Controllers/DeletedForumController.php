<?php

namespace Modules\Forum\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\Forum\Entities\Forum;
use Modules\Org\Entities\OrgBranch;
use Yajra\DataTables\Facades\DataTables;

class DeletedForumController extends Controller
{
    public function data()
    {
        $data['categories'] = Category::whereNull('parent_id')->where('status', 1)->orderBy('position_order', 'asc')->get();
        $data['topics'] = Course::select('id', 'title', 'status')->whereIn('type', [1, 2])->where('status', 1)->latest()->get();
        if (isModuleActive('Org')) {
            $data['branches'] = OrgBranch::select('id', 'group', 'code')->where('parent_id', 0)->orderBy('order')->get();
        } else {
            $data['branches'] = [];
        }

        return $data;
    }

    public function topic(Request $request)
    {
        if ($request->ajax()) {
            return $this->topicData();
        }

        $data = $this->data();
        return view('forum::deleted.topic', $data);
    }

    public function topicData()
    {
        $query = Forum::with('category', 'course', 'deletedUser')->select('forums.*');

        if (!empty(request('topic_type'))) {
            $query->where('topic_type', 1);
        }

        if (!empty(request('category'))) {
            $query->where('course.category_id', request('category'));
        }
        if (!empty(request('topic'))) {
            $query->where('course.id', request('topic'));
        }
        if (!empty(request('org'))) {
            $query->where('course.id', request('org'));
        }
        $query->where(['topic_type' => 1, 'parent_id' => 0])->whereNotNull('deleted_at')
            // ->whereMonth('deleted_at', '>=', Carbon::now()->month)
            ->latest();
        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('topic_type', function ($query) {
                return $query->topic_type == 1 ? trans('forum.L&D Topic') : trans('forum.Org Topic');

            })
            ->addColumn('category_name', function ($query) {
                return @$query->category->name;

            })
            ->addColumn('org', function ($query) {
                return 'org static';

            })
            ->editColumn('deleted_at', function ($query) {
                return $query->created_at->diffForHumans();

            })
            ->addColumn('deleted_by_name', function ($query) {
                return $query->deletedUser->name;

            })
            ->addColumn('action', function ($query) {
                return view('forum::deleted.partials._td_action', compact('query'));

            })->rawColumns(['action'])
            ->make(true);
    }

    public function thread(Request $request)
    {

        if ($request->ajax()) {
            return $this->threadData();
        }

        $data = $this->data();

        return view('forum::deleted.thread', $data);
    }

    public function threadData()
    {
        $query = Forum::with('category', 'deletedUser');
        if (!empty(request('topic_type'))) {
            $query->where('topic_type', request('topic_type'));
            if (request('topic_type') == 2) {
                $query->with('forumOrgBranches', 'forumOrgBranches.branch');
            }
        }
        //$date = date('Y-m-d H:i:s');

        $query->where('topic_type', 2)->whereNotNull('deleted_at')
            // ->whereMonth('deleted_at', '>=', Carbon::now()->month)
            ->latest();

        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('topic_type', function ($query) {
                return $query->topic_type == 1 ? trans('forum.L&D Topic') : trans('forum.Org Topic');

            })
            ->addColumn('category_name', function ($query) {
                return '';
            })
            ->addColumn('org', function ($query) {

                $org = [];
                if ($query->topic_type != 1) {
                    foreach ($query->forumOrgBranches as $branch) {
                        $org[] = OrgBranch::where('id', $branch->branch_id)->first()->group;
                    }
                }
                return implode(', ', $org);

            })
            ->editColumn('deleted_at', function ($query) {
                return $query->created_at->diffForHumans();

            })
            ->addColumn('deleted_by_name', function ($query) {
                return @$query->deletedUser->name;

            })
            ->addColumn('action', function ($query) {
                return view('forum::deleted.partials._td_action', compact('query'));

            })->rawColumns(['action'])
            ->make(true);
    }


}
