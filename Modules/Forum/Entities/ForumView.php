<?php

namespace Modules\Forum\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class ForumView extends Model
{
    use Tenantable;

    protected $fillable = [];
}
