<?php

namespace Modules\Forum\Entities;

use App\Traits\Tenantable;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\Org\Entities\OrgForumBranch;
use Modules\Org\Entities\OrgForumPosition;
use Modules\OrgSubscription\Entities\OrgCourseSubscription;

class Forum extends Model
{
    use Tenantable;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->withDefault([
            'name' => ''
        ]);
    }


    public function course()
    {

        return $this->belongsTo(Course::class, 'course_id', 'id')->where('status', 1);
    }

    public function path()
    {

        return $this->belongsTo(OrgCourseSubscription::class, 'path_id', 'id');
    }


    public function replies()
    {
        return $this->hasMany(ForumReply::class, 'forum_id', 'id')->where('status', 1)->orderBy('id', 'desc');
    }

    public function likes()
    {
        return $this->hasMany(ForumLike::class, 'forum_id', 'id')->orderBy('id', 'desc');
    }

    public function all_replies()
    {

        return $this->hasMany(ForumReply::class, 'forum_id', 'id')->where('status', 1)->orderBy('id', 'desc');
    }

    public function views()
    {

        return $this->hasMany(ForumView::class, 'forum_id', 'id');
    }

    public function view_info()
    {

        return $this->hasOne(ForumView::class, 'forum_id', 'id')->where('user_id', Auth::user()->id);
    }

    public function views_count()
    {

        return $this->views->count();
    }

    public function getIsLoginUserViewableAttribute()
    {
        if (\auth()->user()->role_id == 1) {
            return true;
        }
        if (\auth()->user()->role_id == 4) {
            return true;
        }
        if (\auth()->user()->role_id == 2) {
            if ($this->privacy == 0) {
                return true;
            } else {
                if ($this->course->user_id = \auth()->user()->id) {
                    return true;
                } else {
                    return false;
                }
            }

        }
        if ($this->privacy == 0) {
            return true;
        } else {
            if (!$this->course->enrollUsers->where('id', \auth()->user()->id)->count()) {
                return false;
            } else {
                return true;
            }
        }


    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault();
    }

    public function deletedUser()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id')->withDefault();
    }

    public function threads()
    {
        return $this->hasMany(Forum::class, 'parent_id', 'id');
    }

    public function topic()
    {
        return $this->belongsTo(Forum::class, 'id', 'parent_id')->withDefault();
    }

    public function forumOrgBranches()
    {
        return $this->hasMany(OrgForumBranch::class, 'forum_id');
    }

    public function forumOrgPositions()
    {
        return $this->hasMany(OrgForumPosition::class, 'forum_id');
    }

    public function forumLike()
    {
        return $this->hasOne(ForumLike::class, 'forum_id', 'id')->where('user_id', Auth::id());
    }

}
