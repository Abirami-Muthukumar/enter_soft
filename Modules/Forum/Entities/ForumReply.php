<?php

namespace Modules\Forum\Entities;

use App\Traits\Tenantable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ForumReply extends Model
{
    use Tenantable;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function repliesofReply()
    {

        return $this->hasMany(ForumReply::class, 'parent_id', 'id');
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id')->withDefault();
    }

    public function replyLike()
    {
        return $this->hasOne(ForumReplyLike::class, 'reply_id', 'id')->where('user_id', Auth::id());
    }

}
