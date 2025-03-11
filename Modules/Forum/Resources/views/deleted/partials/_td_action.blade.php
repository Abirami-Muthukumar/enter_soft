<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{trans('common.Action')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">

        <button class="dropdown-item restoreForum"
                data-id="{{$query->id}}"
                data-forumType="{{$query->parent_id==0?'topic':'thread'}}"
                type="button">{{__('forum.Restore')}}</button>

        @if($query->topic_type==1)
            <a class="dropdown-item"
               href="{{route('forum.threads',$query->id)}}"
               type="button"> {{__('forum.View')}}
            </a>
        @else
            <a class="dropdown-item"
               href="{{route('forum.thread',$query->id)}}"
               type="button"> {{__('forum.View')}}
            </a>
        @endif


        <button class="dropdown-item deleteForum"
                data-id="{{$query->id}}"
                data-forumType="{{$query->parent_id==0?'topic':'thread'}}"
                type="button">{{__("forum.Delete")}}
        </button>

    </div>
</div>
