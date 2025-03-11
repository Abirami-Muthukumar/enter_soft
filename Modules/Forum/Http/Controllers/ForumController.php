<?php

namespace Modules\Forum\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\CourseSetting\Entities\Category;
use Modules\Forum\Entities\Forum;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\Forum\Entities\ForumLike;
use Modules\Forum\Entities\ForumReply;
use Modules\Forum\Entities\ForumReplyLike;
use Modules\Forum\Entities\ForumView;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;
use Illuminate\Http\Request;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgForumBranch;
use Modules\Org\Entities\OrgForumPosition;
use Modules\Org\Entities\OrgPosition;
use Modules\OrgSubscription\Entities\OrgCourseSubscription;

class ForumController extends Controller
{

    public function topic()
    {
        return redirect()->route('forum.index');
    }

    public function index(Request $request)
    {
        try {
            $query =
                Course::where('status', 1)
                    ->with('category', 'forums.replies', 'forums.views', 'forums.user')
                    ->where('type', 1);

            if ($request->get('category_id')) {
                $query->where(function ($q) use ($request) {
                    $categories = explode(',', $request->get('category_id'));
                    $q->whereIn('category_id', $categories);
                    $q->orWhereIn('subcategory_id', $categories);
                });
            }

            $courses = $query->paginate(10);

            $perPage = $courses->perPage();
            $currentPage = $courses->currentPage();
            $total = $courses->total();
            $lastPage = $courses->lastPage();

            $data_from = ($currentPage * $perPage) - $perPage + 1;
            $data_to = $currentPage * $perPage;
            if ($currentPage == $lastPage) {
                $data_to = $total;
            }
            $categories = Category::where('status', 1)->orderBy('position_order', 'asc')->get();
            $data = [];
            $check_cat = '';
            if (isModuleActive('Org')) {
                $data['positions'] = OrgPosition::orderBy('order')->get();
                $data['branches'] = OrgBranch::where('parent_id', 0)->orderBy('order')->get();

                $query = Forum::where('forums.topic_type', 1)
                    ->where('forums.parent_id', 0)
                    ->where(function ($q) {
                        $q->whereHas('course', function ($q2) {
                            $q2->where('status', 1);
                        });
                        $q->orWhereHas('path', function ($q3) {
                            $q3->where('status', 1);
                        });
                    })
                    ->whereNull('forums.deleted_at')
                    ->with('course', 'course.category', 'course.user')
                    ->withCount('threads', 'views', 'replies', 'likes')
                    ->orderBy('pin', 'desc');

                $search = $request->get('query');
                if (!empty($search)) {
                    $query->whereLike('forums.title', $search);
                }
                if ($request->filter && $request->filter != 'all') {
                    $query->where('filter', $request->filter);
                }
                $order = $request->get('order', 'latest_topic');

                if ($order == 'latest_topic') {
                    $query->orderBy('forums.created_at', 'desc');
                } elseif ($order == 'latest_reply') {
                    $query->orderBy('forums.last_activity', 'desc');
                } elseif ($order == 'most_reply') {
                    $query->orderBy('forums.total_replies', 'desc');
                } elseif ($order == 'most_like') {
                    $query->orderBy('forums.total_likes', 'desc');
                }
                if ($request->menu == "following") {
                    $query->where('total_likes', '>', 0);
                }
                if ($request->category) {
                    $check_cat = explode(',', $request->category);
                    if (!empty($check_cat)) {
                        unset($check_cat[count($check_cat) - 1]);
                    }
                    $query->whereIn('category_id', $check_cat);
                } else {
                    $check_cat = [];
                }

                $filter = $request->filter;
                $menu = $request->menu;
                // $category = $request->category;
                $data['topics'] = $query->paginate(10);
            }
            return view(theme('pages.forum'), $data, compact('courses', 'data_from', 'data_to', 'categories', 'check_cat'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function CourseForum($course_id)
    {
        $course_info = null;
        if ($course_id != 0) {
            $course_info = Course::find($course_id);
            if (!$course_info) {
                Toastr::error(trans('frontend.Course Not Found'), trans('common.Failed'));
                return redirect()->back();
            }
        }
        $courses = Course::with('forums')->where('status', 1)->where('type', 1)->get();

        if (Auth::user()->role_id == 2) {


            $forums = Forum::query();
            $forums = $forums->where('status', 1)
                ->where(function ($pr) {
                    $pr->where('privacy', 1)
                        ->WhereHas('course', function ($query) {
                            $query->where('user_id', Auth::user()->id);
                        });
                })
                ->orWhere('privacy', 0)
                ->orderBy('id', 'desc')->with('views', 'replies', 'user');
            if ($course_id != 0) {
                $forums = $forums->where('course_id', $course_id)->where('lesson_id', null);
            }
            $recent_forums = $forums->get();
            $forums = $forums->paginate(10);
            //Unread Forums
            $unread_forums = Forum::query();
            $unread_forums = $unread_forums->where('status', 1)
                ->where(function ($pr) {
                    $pr->where('privacy', 1)
                        ->WhereHas('course', function ($query) {
                            $query->where('user_id', Auth::user()->id);
                        });
                })
                ->orWhere('privacy', 0)
                ->orderBy('id', 'desc')->with('views', 'replies', 'user');
            if ($course_id != 0) {
                $unread_forums = $unread_forums->where('course_id', $course_id)->where('lesson_id', null);
            }
            $unread_forums = $unread_forums->doesntHave('view_info')
                ->paginate(10);

            $viewed_forums = Forum::query();
            $viewed_forums = $viewed_forums->where('status', 1)
                ->where(function ($pr) {
                    $pr->where('privacy', 1)
                        ->WhereHas('course', function ($query) {
                            $query->where('user_id', Auth::user()->id);
                        });
                })
                ->orWhere('privacy', 0);
            if ($course_id != 0) {
                $viewed_forums = $viewed_forums->where('course_id', $course_id)->where('lesson_id', null);
            }
            $viewed_forums = $viewed_forums->with('views', 'replies', 'user')
                ->withCount('views')
                ->whereHas('views')->where('status', 1)
                ->orderBy('views_count', 'desc')
                ->take(10)->get();
        } elseif (Auth::user()->role_id == 3) {
            $forums = Forum::query();
            $forums = $forums->where('status', 1)
                ->where(function ($pr) {
                    $pr->where('privacy', 1)
                        ->WhereHas('course', function ($query) {
                            $query->WhereHas('enrolls', function ($ce) {
                                $ce->where('user_id', Auth::user()->id);
                            });
                        });
                })
                ->orWhere('privacy', 0)
                ->orderBy('id', 'desc')->with('views', 'replies', 'user');
            if ($course_id != 0) {
                $forums = $forums->where('course_id', $course_id)->where('lesson_id', null);
            }
            $recent_forums = $forums->get();
            $forums = $forums->paginate(10);
            //Unread Forums
            $unread_forums = Forum::query();
            $unread_forums = $unread_forums->where('status', 1)
                ->where(function ($pr) {
                    $pr->where('privacy', 1)
                        ->WhereHas('course', function ($query) {
                            $query->WhereHas('enrolls', function ($ce) {
                                $ce->where('user_id', Auth::user()->id);
                            });
                        });
                })
                ->orWhere('privacy', 0)
                ->orderBy('id', 'desc')->with('views', 'replies', 'user');
            if ($course_id != 0) {
                $unread_forums = $unread_forums->where('course_id', $course_id)->where('lesson_id', null);
            }
            $unread_forums = $unread_forums->doesntHave('view_info')->paginate(10);
            //View forums
            $viewed_forums = Forum::query();


            $viewed_forums = $viewed_forums->where('status', 1)
                ->where(function ($pr) {
                    $pr->where('privacy', 1)
                        ->WhereHas('course', function ($query) {
                            $query->WhereHas('enrolls', function ($ce) {
                                $ce->where('user_id', Auth::user()->id);
                            });
                        });
                })
                ->orWhere('privacy', 0);
            if ($course_id != 0) {
                $viewed_forums = $viewed_forums->where('course_id', $course_id)->where('lesson_id', null);
            }
            $viewed_forums = $viewed_forums->with('views', 'replies', 'user')
                ->withCount('views')->whereHas('views')
                ->where('status', 1)
                ->orderBy('views_count', 'desc')
                ->take(10)->get();
        } else {

            $forums = Forum::query();
            if ($course_id != 0) {
                $forums = $forums->where('course_id', $course_id)->where('lesson_id', null);
            }
            $forums = $forums->where('status', 1)->orderBy('id', 'desc')->with('views', 'replies', 'user');
            $recent_forums = $forums->get();
            $forums = $forums->paginate(10);
            //Unread Forums
            $unread_forums = Forum::query();
            if ($course_id != 0) {
                $unread_forums = $unread_forums->where('course_id', $course_id)->where('lesson_id', null);
            }
            $unread_forums = $unread_forums->doesntHave('view_info')->with('views', 'replies', 'user')
                ->where('status', 1)->orderBy('id', 'desc')->paginate(10);

            //Most viewd forum
            $viewed_forums = Forum::query();
            if ($course_id != 0) {
                $viewed_forums = $viewed_forums->where('course_id', $course_id)->where('lesson_id', null);
            }
            $viewed_forums = $viewed_forums->with('views', 'replies', 'user')
                ->withCount('views')->whereHas('views')
                ->where('status', 1)
                ->orderBy('views_count', 'desc')
                ->take(10)->get();
        }

        $perPage = $forums->perPage();
        $currentPage = $forums->currentPage();
        $total = $forums->total();
        $lastPage = $forums->lastPage();

        $data_from = ($currentPage * $perPage) - $perPage + 1;
        $data_to = $currentPage * $perPage;
        if ($currentPage == $lastPage) {
            $data_to = $total;
        }


        return view(theme('pages.forum_courses'), compact('courses', 'forums', 'recent_forums', 'unread_forums', 'viewed_forums', 'data_from', 'data_to', 'course_info'));
    }


    public function LessonForum($lesson_id)
    {

        $lesson_info = Lesson::find($lesson_id);
        $course_info = Course::find($lesson_info->course_id);
        $course_id = $lesson_info->course_id;

        if (!$course_info) {
            Toastr::error(trans('frontend.Course Not Found'), trans('common.Failed'));
            return redirect()->back();
        }
        // return $course_info;
        if (Auth::user()->role_id == 2) {
            $courses = Course::where('status', 1)->where('type', 1)->get();

            $forums = Forum::query();
            $forums = $forums->where('status', 1)
                ->where(function ($pr) {
                    $pr->where('privacy', 1)
                        ->WhereHas('course', function ($query) {
                            $query->where('user_id', Auth::user()->id);
                        });
                })
                ->orWhere('privacy', 0)
                ->orderBy('id', 'desc')->with('views', 'replies', 'user');
            $forums = $forums->where('course_id', $course_id)->where('lesson_id', $lesson_id);

            $recent_forums = $forums->get();
            $forums = $forums->paginate(10);
            //Unread Forums
            $unread_forums = Forum::query();
            $unread_forums = $unread_forums->where('status', 1)
                ->where(function ($pr) {
                    $pr->where('privacy', 1)
                        ->WhereHas('course', function ($query) {
                            $query->where('user_id', Auth::user()->id);
                        });
                })
                ->orWhere('privacy', 0)
                ->orderBy('id', 'desc')->with('views', 'replies', 'user');
            $unread_forums = $unread_forums->where('course_id', $course_id)->where('lesson_id', $lesson_id);
            $unread_forums = $unread_forums->doesntHave('views')
                ->paginate(10);
            //Viewed Forums
            $viewed_forums = Forum::query();
            $viewed_forums = $viewed_forums->where('status', 1)
                ->where(function ($pr) {
                    $pr->where('privacy', 1)
                        ->WhereHas('course', function ($query) {
                            $query->where('user_id', Auth::user()->id);
                        });
                })
                ->orWhere('privacy', 0);
            $viewed_forums = $viewed_forums->where('course_id', $course_id)->where('lesson_id', $lesson_id);
            $viewed_forums = $viewed_forums->with('views', 'replies', 'user')
                ->withCount('views')
                ->whereHas('views')->where('status', 1)
                ->orderBy('views_count', 'desc')
                ->take(10)->get();
        } elseif (Auth::user()->role_id == 3) {
            $courses = Course::where('status', 1)->where('type', 1)->get();
            $forums = Forum::query();
            $forums = $forums->where('status', 1)
                ->where(function ($pr) {
                    $pr->where('privacy', 1)
                        ->WhereHas('course', function ($query) {
                            $query->WhereHas('enrolls', function ($ce) {
                                $ce->where('user_id', Auth::user()->id);
                            });
                        });
                })
                ->orWhere('privacy', 0)
                ->orderBy('id', 'desc')->with('views', 'replies', 'user');
            $forums = $forums->where('course_id', $course_id)->where('lesson_id', $lesson_id);
            $recent_forums = $forums->get();
            $forums = $forums->paginate(10);
            //Unread Forums
            $unread_forums = Forum::query();
            $unread_forums = $unread_forums->where('status', 1)
                ->where(function ($pr) {
                    $pr->where('privacy', 1)
                        ->WhereHas('course', function ($query) {
                            $query->WhereHas('enrolls', function ($ce) {
                                $ce->where('user_id', Auth::user()->id);
                            });
                        });
                })
                ->orWhere('privacy', 0)
                ->orderBy('id', 'desc')->with('views', 'replies', 'user');
            $unread_forums = $unread_forums->where('course_id', $course_id)->where('lesson_id', $lesson_id);
            $unread_forums = $unread_forums->doesntHave('views')->paginate(10);
            //View forums
            $viewed_forums = Forum::query();

            if (isset($request->course) && $request->course != 0) {
                $viewed_forums = $viewed_forums;
            }

            $viewed_forums = $viewed_forums->where('status', 1)
                ->where(function ($pr) {
                    $pr->where('privacy', 1)
                        ->WhereHas('course', function ($query) {
                            $query->WhereHas('enrolls', function ($ce) {
                                $ce->where('user_id', Auth::user()->id);
                            });
                        });
                })
                ->orWhere('privacy', 0);
            $viewed_forums = $viewed_forums->where('course_id', $course_id)->where('lesson_id', $lesson_id);
            $viewed_forums = $viewed_forums->with('views', 'replies', 'user')
                ->withCount('views')->whereHas('views')
                ->where('status', 1)
                ->orderBy('views_count', 'desc')
                ->take(10)->get();
        } else {

            $courses = Course::where('status', 1)->where('type', 1)->get();
            $forums = Forum::query();
            $forums = $forums->where('course_id', $course_id)->where('lesson_id', $lesson_id);
            $forums = $forums->where('status', 1)->orderBy('id', 'desc')->with('views', 'replies', 'user');
            $recent_forums = $forums->get();
            $forums = $forums->paginate(10);
            //Unread Forums
            $unread_forums = Forum::query();
            $unread_forums = $unread_forums->where('course_id', $course_id)->where('lesson_id', $lesson_id);
            $unread_forums = $unread_forums->doesntHave('view_info')
                ->where('status', 1)->with('views', 'replies', 'user')->orderBy('id', 'desc')->paginate(10);

            //Most viewd forum
            $viewed_forums = Forum::query();
            $viewed_forums = $viewed_forums->where('course_id', $course_id)->where('lesson_id', $lesson_id);
            $viewed_forums = $viewed_forums->with('views', 'replies', 'user')
                ->withCount('views')->whereHas('views')
                ->where('status', 1)
                ->orderBy('views_count', 'desc')
                ->take(10)->get();
        }
        // return $forums;

        $perPage = $forums->perPage();
        $currentPage = $forums->currentPage();
        $total = $forums->total();
        $lastPage = $forums->lastPage();

        $data_from = ($currentPage * $perPage) - $perPage + 1;
        $data_to = $currentPage * $perPage;
        if ($currentPage == $lastPage) {
            $data_to = $total;
        }


        return view(theme('pages.forum_lesson'), compact('courses', 'forums', 'recent_forums', 'unread_forums', 'viewed_forums', 'data_from', 'data_to', 'course_info', 'lesson_info'));
    }


    public function CreateForum($course_id, $lesson_id = null)
    {

        $lesson_info = Lesson::find($lesson_id);
        $course_info = Course::find($course_id);

        if (!$course_info->IsLoginUserEnrolled) {
            Toastr::error(trans('frontend.You are not enrolled for this course'), trans('common.Failed'));
            return redirect()->back();
        }
        $courses = Course::where('status', 1)->where('type', 1)->get();


        return view(theme('pages.forum_form'), compact('courses', 'course_info', 'lesson_info'));;
    }

    public function ViewForum($forum_id)
    {
        $forum = Forum::findOrFail($forum_id);
        try {

            if ($forum->privacy == 1) {
                if ($forum->course_id != null) {
                    if (!$forum->course->IsLoginUserEnrolled) {
                        Toastr::error(trans('frontend.You are not eligible to access this forum'), trans('common.Failed'));
                        return redirect()->back();
                    }
                } else {
                    if (Auth::user()->role_id != 1 && Auth::user()->role_id != 4 && !$forum->group->isGroupMember($forum->group_id, Auth::user()->id)) {
                        Toastr::error(trans('frontend.You are not member of this group'), trans('common.Failed'));
                        return redirect()->back();
                    }
                }
            }

            $courses = Course::where('status', 1)->where('type', 1)->get();


            $view = new ForumView();
            $view->user_id = Auth::user()->id;
            $view->forum_id = $forum_id;
            $view->save();

            $total_view = ForumView::where('forum_id', $forum_id)->count();
            Forum::where('id', $forum_id)->update([
                'total_views' => $total_view
            ]);

            $parent = Forum::find($forum->parent_id);
            if ($parent) {
                $parent->update(['total_views' => $total_view]);
            }

            if ($forum->course_id != null) {
                $recent_discussion = Forum::where('course_id', $forum->course_id)->where('id', '!=', $forum_id)->where('status', 1)->orderBy('id', 'desc')->take(3)->get();
            } else {
                $recent_discussion = Forum::where('group_id', $forum->group_id)->where('id', '!=', $forum_id)->where('status', 1)->orderBy('id', 'desc')->take(3)->get();
            }


            return view(theme('pages.forum_details'), compact('forum', 'recent_discussion', 'courses'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    //    public function createTopic()
    //    {
    //        return view(theme('pages.forum_new_topic'));
    //    }

    public function thread(Request $request, $thread_id)
    {
        $thread = Forum::where('id', $thread_id)->firstOrFail();

        if (Auth::user()->role_id == 3) {
            $org_chart = OrgForumBranch::with('branch')->where('forum_id', $thread->id)->first();
            if ($org_chart) {
                if (Auth::user()->org_chart_code != $org_chart->branch->code) {
                    Toastr::error(trans('org.You have no permission to access this content'), trans('common.Failed'));
                    return redirect()->back();
                }
            }
        }

        $comments = ForumReply::orderBy('pin', 'desc')->with('repliesofReply')->where('forum_id', $thread_id)->where('parent_id', null)->paginate(10);
        return view(theme('pages.forum_thread'), compact('thread', 'comments'));
    }

    public function threads(Request $request, $topic_id = null)
    {
        $data = [];

        $topic = Forum::where('id', $topic_id)->first();

        if (@$topic->lock == 1) {
            Toastr::error(trans('frontend.Please, unlock first'), trans('common.Failed'));
            return redirect()->back();
        }

        $query = Forum::query()->orderBy('pin', 'desc');

        $search = $request->get('query');
        if (!empty($search)) {
            $query->whereLike('forums.title', $search);
        }

        $order = $request->get('order', 'latest_thread');

        if ($order == 'latest_thread') {
            $query->orderBy('forums.created_at', 'desc');
        } elseif ($order == 'latest_reply') {
            $query->orderBy('forums.last_activity', 'desc');
        } elseif ($order == 'most_reply') {
            $query->orderBy('forums.total_replies', 'desc');
        } elseif ($order == 'most_like') {
            $query->orderBy('forums.total_likes', 'desc');
        }

        if ($request->get('type') == 'org') {
            $data['positions'] = OrgPosition::orderBy('order')->get();
            $data['branches'] = OrgBranch::where('parent_id', 0)->orderBy('order')->get();


            $query->where('forums.topic_type', 2);
        } else {
            $query->where('forums.parent_id', $topic_id);
        }
        if ($request->menu == "following") {
            $query->where('total_likes', '>', 0);
        }

        if ($request->category) {
            $check_cat = explode(',', $request->category);
            if (!empty($check_cat)) {
                unset($check_cat[count($check_cat) - 1]);
            }
            $query->whereHas('forumOrgBranches', function ($q) use ($check_cat) {
                $q->whereIn('branch_id', $check_cat);
            });
        } else {
            $check_cat = [];
        }


        if ($request->positions) {
            $check_pos = explode(',', $request->positions);
            if (!empty($check_pos)) {
                unset($check_pos[count($check_pos) - 1]);
            }
            $query->whereHas('forumOrgPositions', function ($q) use ($check_pos) {
                $q->whereIn('position_id', $check_pos);
            });
        } else {
            $check_pos = [];
        }

        $threads = $query->whereNull('deleted_at')->latest()->paginate(10);

        return view(theme('pages.forum_threads'), $data, compact('topic', 'threads', 'check_pos', 'check_cat'));
    }

    public function createThread(Request $request)
    {
        if ($request->type == 'org') {
            $data['branches'] = OrgBranch::select('id', 'group', 'code')->where('parent_id', 0)->orderBy('order')->get();
            $data['positions'] = OrgPosition::orderBy('order')->get();
        } else {
            $data['categories'] = Category::whereNull('parent_id')->where('status', 1)->orderBy('position_order', 'asc')->get();
        }
        return view(theme('pages.forum_new_thread'), $data);
    }

    public function createThreadSubmit(Request $request)
    {
        if ($request->topic_type == 'org') {
            $rules = [
                'title' => 'required',
                'description' => 'required',
                'branch' => 'required',
                'position' => 'required'

            ];
        } else {
            $rules = [
                'title' => 'required',
                'description' => 'required',
                'category' => 'required',
            ];
        }

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $course_id = 0;
            $path_id = 0;
            $category_id = 0;
            $parent_id = (int)$request->get('topic_id', 0);
            if ($request->topic_type != 'org') {
                $topic = explode('|', $request->course_id);
                $topicType = $topic[1] ?? '';
                $topicID = (int)$topic[0] ?? 0;

                if ($topicType == 'course_id') {
                    $course_id = $topicID;
                    $course = Course::findOrFail($course_id);
                    $parent = Forum::updateOrCreate([
                        'course_id' => (int)$course_id,
                    ], [
                        'title' => $course->title,
                        'description' => $course->about,
                        'created_by' => (int)Auth::id(),
                        'course_id' => (int)$course_id,
                        'path_id' => (int)$path_id,
                        'category_id' => $request->category,
                        'parent_id' => $parent_id,
                        'filter' => $request->filter
                    ]);
                    $parent_id = $parent->id;
                } elseif ($topicType == 'path_id') {
                    $path_id = $topicID;
                    $path = OrgCourseSubscription::findOrFail($path_id);
                    $parent = Forum::updateOrCreate([
                        'path_id' => (int)$path_id,
                    ], [
                        'title' => $path->title,
                        'description' => $path->about,
                        'created_by' => (int)Auth::id(),
                        'course_id' => (int)$course_id,
                        'path_id' => (int)$path_id,
                        'category_id' => $request->category,
                        'parent_id' => $parent_id,
                        'filter' => $request->filter
                    ]);
                    $parent_id = $parent->id;
                }
            }

            $forum = Forum::create([
                'title' => $request->title,
                'description' => $request->description,
                'created_by' => (int)Auth::id(),
                'course_id' => (int)$course_id,
                'path_id' => (int)$path_id,
                'category_id' => $request->category,
                'parent_id' => $parent_id,
                'topic_type' => ($request->topic_type == 'org') ? 2 : 1,
                'approved_at' => (bool)Settings('forum_auto_approval_thread_status') == true ? now() : null,
                'filter' => $request->filter
            ]);
            if ($request->topic_type == 'org') {
                if ((array)$request->branch) {
                    foreach ($request->branch as $branch) {
                        OrgForumBranch::create([
                            'forum_id' => $forum->id,
                            'branch_id' => $branch,
                        ]);
                    }
                }
                if ((array)$request->position) {
                    foreach ($request->position as $position) {
                        OrgForumPosition::create([
                            'forum_id' => $forum->id,
                            'position_id' => $position,
                        ]);
                    }
                }
            }

            Forum::where('id', $parent_id)->update([
                'last_activity' => now()
            ]);

            if (richTextWordLength($request->description) >= 20) {
                orgLeaderboardPointCheck('Interaction', Settings('question_thread'), $forum->course_id, 'thread');
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            if ($request->topic_type == 'org') {
                return redirect()->route('forum.threads', ['type' => 'org']);
            }
            return redirect()->route('forum.index');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function getCourseList(Request $request)
    {
        $filter = $request->filterSelect;
        $courses = [];
        $paths = [];
        $result = [];

        if ($filter != 'path') {
            $query = Course::select('id', 'title')->where('status', 1);
            if ($filter == 'offline_quiz') {
                $query->where('type', 2)->where('mode_of_delivery', '!=', 1);
            } elseif ($filter == 'online_quiz') {
                $query->where('type', 2)->where('mode_of_delivery', 1);
            } elseif ($filter == 'live_class') {
                $query->where('type', 3);
            } elseif ($filter == 'offline_course') {
                $query->where('type', 1)->where('mode_of_delivery', '!=', 1);
            } elseif ($filter == 'online_course') {
                $query->where('type', 1)->where('mode_of_delivery', 1);
            }
            $courses = $query->latest()->pluck('title', 'id');
        }
        if ($filter == 'all' || $filter == 'path') {
            $paths = OrgCourseSubscription::where('type', 2)->where('status', 1)->orderBy('order')->pluck('title', 'id');
        }
        foreach ($courses as $key => $course) {
            $result[$key . '|' . 'course_id'] = $course;
        }

        foreach ($paths as $key => $path) {
            $result[$key . '|' . 'path_id'] = $path;
        }
        return $result;
    }

    //forum actions
    public function approval(Request $request)
    {
        $forum = Forum::findOrFail($request->item_id);
        $forum->approved_at = now();
        $forum->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function pin(Request $request)
    {
        $forum = Forum::findOrFail($request->item_id);
        $forum->pin = 1;
        $forum->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function unpin(Request $request)
    {
        $forum = Forum::findOrFail($request->item_id);
        $forum->pin = 0;
        $forum->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function lock(Request $request)
    {
        $forum = Forum::findOrFail($request->item_id);
        $forum->lock = 1;
        $forum->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function unlock(Request $request)
    {
        $forum = Forum::findOrFail($request->item_id);
        $forum->lock = 0;
        $forum->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $forum = Forum::findOrFail($request->item_id);
        $forum->deleted_at = now();
        $forum->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function finalDelete(Request $request)
    {
        $forum = Forum::findOrFail($request->id);
        $forum->delete();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function restore(Request $request)
    {
        $forum = Forum::findOrFail($request->id);
        $forum->deleted_at = null;
        $forum->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function threadLikeUnlike($thread_id)
    {
        $thread = Forum::find($thread_id);
        $check = ForumLike::where('forum_id', $thread->id)->where('user_id', Auth::id())->first();
        if ($check) {
            $check->delete();
        } else {
            ForumLike::create([
                'forum_id' => $thread->id,
                'user_id' => Auth::id(),
            ]);
        }
        $like_count = ForumLike::where('forum_id', $thread->id)->count();
        $thread->update(['total_likes' => $like_count]);
        $parent = Forum::find($thread->parent_id);
        if ($parent) {
            $parent->update(['total_likes' => $like_count]);
        }
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function replyLikeUnlike($reply_id)
    {
        $reply = ForumReply::findOrFail($reply_id);
        $check = ForumReplyLike::where('reply_id', $reply->id)->where('user_id', Auth::id())->first();
        if ($check) {
            $check->delete();
        } else {
            ForumReplyLike::create([
                'reply_id' => $reply->id,
                'user_id' => Auth::id(),
            ]);
        }
        $like_count = ForumReplyLike::where('reply_id', $reply_id)->count();
        $reply->update(['total_likes' => $like_count]);
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function editThread(Request $request, $id)
    {
        $data['edit'] = Forum::findOrFail($id);
        $data['child'] = Forum::where('parent_id', $id)->first();
        if ($data['edit']->topic_type == 2) {
            $data['edit_branch'] = OrgForumBranch::where('forum_id', $id)->pluck('branch_id')->toArray();
            $data['edit_position'] = OrgForumPosition::where('forum_id', $id)->pluck('position_id')->toArray();
            $data['branches'] = OrgBranch::select('id', 'group', 'code')->where('parent_id', 0)->orderBy('order')->get();
            $data['positions'] = OrgPosition::orderBy('order')->get();
        } else {
            $data['categories'] = Category::whereNull('parent_id')->where('status', 1)->orderBy('position_order', 'asc')->get();
        }
        return view(theme('pages.edit_forum'), $data);
    }

    public function updateThreadSubmit(Request $request, $id)
    {
        if ($request->course_id) {
            $rules = [
                'title' => 'required',
                'description' => 'required',
                'category' => 'required',
            ];
        } else {
            $rules = [
                'title' => 'required',
                'description' => 'required',
            ];
        }

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $course_id = 0;
            $path_id = 0;
            $category_id = 0;
            $parent_id = (int)$request->get('topic_id', 0);
            // if ($request->topic_type != 'org') {
            $topic = explode('|', $request->course_id);
            $topicType = $topic[1] ?? '';
            $topicID = (int)$topic[0] ?? 0;
            $course_id = $topicID;

            // if ($topicType == 'course_id') {
            //     $course_id = $topicID;
            //     $course = Course::findOrFail($course_id);
            //     $parent = Forum::updateOrCreate([
            //         'course_id' => (int)$course_id,
            //     ], [
            //         'title' => $course->title,
            //         'description' => $course->about,
            //         'created_by' => (int)Auth::id(),
            //         'course_id' => (int)$course_id,
            //         'path_id' => (int)$path_id,
            //         'category_id' => $request->category,
            //         'filter' => $request->filter
            //     ]);
            // } elseif ($topicType == 'path_id') {
            //     $path_id = $topicID;

            //     $path = OrgCourseSubscription::findOrFail($path_id);
            //     $parent = Forum::updateOrCreate([
            //         'path_id' => (int)$path_id,
            //     ], [
            //         'title' => $path->title,
            //         'description' => $path->description,
            //         'created_by' => (int)Auth::id(),
            //         'course_id' => (int)$course_id,
            //         'path_id' => (int)$path_id,
            //         'category_id' => $request->category,
            //         'filter' => $request->filter
            //     ]);
            // }
            // }

            if ($request->course_id) {


                $forum = Forum::where('id', $id)->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'created_by' => (int)Auth::id(),
                    'course_id' => (int)$course_id,
                    'path_id' => (int)$path_id,
                    'category_id' => $request->category,
                    // 'parent_id' => $parent_id,
                    // 'topic_type' => ($request->topic_type == 'org') ? 2 : 1,
                    'approved_at' => (bool)Settings('forum_auto_approval_thread_status') == true ? now() : null,
                    'filter' => $request->filter
                ]);
            } else {

                OrgForumBranch::where('forum_id', $id)->delete();
                OrgForumPosition::where('forum_id', $id)->delete();

                $forum = Forum::where('id', $id)->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'created_by' => (int)Auth::id(),
                    // 'course_id' => (int)$course_id,
                    // 'path_id' => (int)$path_id,
                    // 'category_id' => $request->category,
                    // 'parent_id' => $parent_id,
                    // 'topic_type' => ($request->topic_type == 'org') ? 2 : 1,
                    // 'approved_at' => (bool)Settings('forum_auto_approval_thread_status') == true ? now() : null,
                    // 'filter' => $request->filter
                ]);

                if (empty($request->course_id)) {
                    if ((array)$request->branch) {
                        foreach ($request->branch as $branch) {
                            OrgForumBranch::create([
                                'forum_id' => $id,
                                'branch_id' => $branch,
                            ]);
                        }
                    }
                    if ((array)$request->position) {
                        foreach ($request->position as $position) {
                            OrgForumPosition::create([
                                'forum_id' => $id,
                                'position_id' => $position,
                            ]);
                        }
                    }
                }
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function studentList(Request $request)
    {
        try {
            $query =
                Course::where('status', 1)
                    ->with('category', 'forums.replies', 'forums.views', 'forums.user')
                    ->where('type', 1);
            if ($request->get('category_id')) {
                $query->where(function ($q) use ($request) {
                    $categories = explode(',', $request->get('category_id'));
                    $q->whereIn('category_id', $categories);
                    $q->orWhereIn('subcategory_id', $categories);
                });
            }

            $courses = $query->paginate(10);

            $perPage = $courses->perPage();
            $currentPage = $courses->currentPage();
            $total = $courses->total();
            $lastPage = $courses->lastPage();

            $data_from = ($currentPage * $perPage) - $perPage + 1;
            $data_to = $currentPage * $perPage;
            if ($currentPage == $lastPage) {
                $data_to = $total;
            }
            $categories = Category::where('status', 1)->orderBy('position_order', 'asc')->get();
            $data = [];
            if (isModuleActive('Org')) {
                $data['positions'] = OrgPosition::orderBy('order')->get();
                $data['branches'] = OrgBranch::where('parent_id', 0)->orderBy('order')->get();


                $query = Forum::where('forums.topic_type', 1)
                    ->where('forums.parent_id', 0)
                    ->where(function ($q) {
                        $q->whereHas('course', function ($q2) {
                            $q2->where('status', 1);
                        });
                        $q->orWhereHas('path', function ($q3) {
                            $q3->where('status', 1);
                        });
                    })
                    ->whereNull('forums.deleted_at')
                    ->with('course', 'course.category', 'course.user')
                    ->withCount('threads', 'views', 'replies', 'likes')
                    ->orderBy('pin', 'desc');
                $search = $request->get('query');
                if (!empty($search)) {
                    $query->whereLike('forums.title', $search);
                }
                if ($request->filter && $request->filter != 'all') {
                    $query->where('filter', $request->filter);
                }
                $order = $request->get('order', 'latest_topic');

                if ($order == 'latest_topic') {
                    $query->orderBy('forums.created_at', 'desc');
                } elseif ($order == 'latest_reply') {
                    $query->orderBy('forums.last_activity', 'desc');
                } elseif ($order == 'most_reply') {
                    $query->orderBy('forums.total_replies', 'desc');
                } elseif ($order == 'most_like') {
                    $query->orderBy('forums.total_likes', 'desc');
                }
                if ($request->menu == "following") {
                    $query->where('total_likes', '>', 0);
                }
                if ($request->category) {
                    $check_cat = explode(',', $request->category);
                    $query->whereIn('category_id', $check_cat);
                } else {
                    $check_cat = [];
                }

                $filter = $request->filter;
                $menu = $request->menu;
                // $category = $request->category;
                $data['topics'] = $query->paginate(10);
            }
            return view(theme('pages.forum'), $data, compact('courses', 'data_from', 'data_to', 'categories', 'check_cat'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function threadAjaxLikeUnlike(Request $request)
    {
        $thread = Forum::find($request->thread_id);
        $check = ForumLike::where('forum_id', $thread->id)->where('user_id', Auth::id())->first();
        if ($check) {
            $check->delete();
        } else {
            ForumLike::create([
                'forum_id' => $thread->id,
                'user_id' => Auth::id(),
            ]);
        }
        $like_count = ForumLike::where('forum_id', $thread->id)->count();
        $thread->update(['total_likes' => $like_count]);
        $parent = Forum::find($thread->parent_id);
        if ($parent) {
            $parent->update(['total_likes' => $like_count]);
        }
        $self_like = ForumLike::where('forum_id', $thread->id)->where('user_id', Auth::id())->first();
        return response()->json([
            'parent' => $parent,
            'self_like' => $self_like
        ]);
    }


}
