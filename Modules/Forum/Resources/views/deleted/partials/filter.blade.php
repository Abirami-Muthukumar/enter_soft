<div class="col-lg-12">
    <div class="white_box mb_30">
        <div class="white_box_tittle list_header">
            <h4>{{__('courses.Advanced Filter')}} </h4>
        </div>
        <form>
            <div class="row">
                <div class="col-lg-3 mt-30">

                    <label class="primary_input_label" for="type">{{__('chat.type')}}</label>
                    <select class="primary_select" name="topic_type" id="type">
                        <option data-display="{{__('common.Select')}} {{__('chat.type')}}"
                                value="">{{__('common.Select')}} {{__('chat.type')}}</option>
                        <option
                            value="1" {{request('topic_type')==1?'selected':''}}>{{__('forum.L&D TOPIC')}}
                        </option>
                        <option
                            value="2" {{request('topic_type')==2?'selected':''}}>{{__('forum.ORG TOPIC')}}
                        </option>
                    </select>

                </div>
                <div class="col-lg-3 mt-30">

                    <label class="primary_input_label" for="category">{{__('courses.Category')}}</label>
                    <select class="primary_select" name="category" id="category">
                        <option data-display="{{__('common.Select')}} {{__('courses.Category')}}"
                                value="">{{__('common.Select')}} {{__('courses.Category')}}</option>
                        @foreach($categories as $category)
                            @include('backend.categories._single_select_option',['category'=>$category,'level'=>1])
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 mt-30">
                    <label class="primary_input_label"
                           for="topic">{{__('courses.Course')}} / {{__('courses.Quiz')}} </label>
                    <select class="primary_select" name="topic" id="topic">
                        <option data-display="{{__('common.Select')}}"
                                value="">{{__('common.Select')}}</option>
                        @foreach($topics as $topic)
                            <option
                                value="{{$topic->id}}" {{request('topic')==$topic->id?'selected':''}}>{{$topic->title}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="col-lg-3 mt-30">
                    <label class="primary_input_label" for="branch">{{__("forum.ORG Chart")}}</label>
                    <select class="primary_select" name="branch" id="branch">
                        <option data-display="{{__('common.Select')}}"
                                value="">{{__('common.Select')}}</option>
                        @foreach($branches as $branch)
                            @include('org::branch._single_select_option',['branch'=>$branch,'level'=>1,'selected_option'=>request('branch')??''])
                        @endforeach
                    </select>

                </div>


                <div class="col-12 mt-20">
                    <div class="search_course_btn text-end">
                        <button type="submit"
                                class="primary-btn radius_30px   fix-gr-bg">{{__('courses.Filter')}} </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="col-12">
    <div class="box_header common_table_header">
        <div class="main-title d-md-flex">


            <ul class="d-flex">
                <li>


                    <a class="primary-btn radius_30px   fix-gr-bg"
                       href="{{route('forum.deleted_topic')}}">
                        <i class="ti-trash"></i>{{__('forum.Deleted Topics')}}
                    </a>
                </li>
                <li>


                    <a class="primary-btn radius_30px   fix-gr-bg"
                       href="{{route('forum.deleted_thread')}}">
                        <i class="ti-trash"></i>{{__('forum.Deleted Threads')}}
                    </a>
                </li>
            </ul>

        </div>

    </div>
</div>
