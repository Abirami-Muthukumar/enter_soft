@extends('backend.master')
@push('styles')
    <style>
        .fixed-width ul {
            width: 50%;
        }

        @media (max-width: 767px) {
            .fixed-width ul {
                width: 100%;
            }
        }
    </style>
@endpush

@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row">
                <div class="col-lg-12">
                    <div class="white_box_tittle list_header">
                        <h4>{{__('common.All')}} {{__('setting.Setting')}} </h4>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">

                <div class="col-lg-12">
                    <div class="  student-details header-menu">
                        <form id="" method="post" action="{{route('forum.setting')}}">
                            @csrf
                            <div class="add-visitor">
                                <div class="row pt-0">
                                </div>
                                <div class="tab-content">

                                    <div role="tabpanel"
                                         class="tab-pane fade  show active white-box   "
                                         id="element">
                                        <div class="row">
                                            <div class="col-lg-4">

                                                <div class="input-effect fixed-width ">
                                                    <h3> {{__('forum.Auto Create Topics')}}
                                                    </h3>
                                                    <ul class="">
                                                        <li class="pb-2">
                                                            <span>{{__('forum.Online Course')}} </span>
                                                            <label class="switch_toggle float-end"
                                                                   for="forum_auto_online_course_status">
                                                                <input type="checkbox"
                                                                       class=""
                                                                       name="forum_auto_online_course_status"
                                                                       id="forum_auto_online_course_status"
                                                                       {{Settings('forum_auto_online_course_status')==1?'checked':''}}
                                                                       value="1">
                                                                <i class="slider round"></i>
                                                            </label>
                                                        </li>

                                                        <li class="pb-2">
                                                            <span>{{__('forum.Offline Course')}} </span>
                                                            <label class="switch_toggle float-end"
                                                                   for="forum_auto_offline_course_status">
                                                                <input type="checkbox"
                                                                       class=""
                                                                       name="forum_auto_offline_course_status"
                                                                       id="forum_auto_offline_course_status"
                                                                       {{Settings('forum_auto_offline_course_status')==1?'checked':''}}
                                                                       value="1">
                                                                <i class="slider round"></i>
                                                            </label>
                                                        </li>

                                                        <li class="pb-2">
                                                            <span>{{__('forum.Live Class')}} </span>
                                                            <label class="switch_toggle float-end"
                                                                   for="forum_auto_live_class_status">
                                                                <input type="checkbox"
                                                                       class=""
                                                                       name="forum_auto_live_class_status"
                                                                       id="forum_auto_live_class_status"
                                                                       {{Settings('forum_auto_live_class_status')==1?'checked':''}}
                                                                       value="1">
                                                                <i class="slider round"></i>
                                                            </label>
                                                        </li>


                                                        <li class="pb-2">
                                                            <span>{{__('forum.Online Quiz')}} </span>
                                                            <label class="switch_toggle float-end"
                                                                   for="forum_auto_online_quiz_status">
                                                                <input type="checkbox"
                                                                       class=""
                                                                       name="forum_auto_online_quiz_status"
                                                                       id="forum_auto_online_quiz_status"
                                                                       {{Settings('forum_auto_online_quiz_status')==1?'checked':''}}
                                                                       value="1">
                                                                <i class="slider round"></i>
                                                            </label>
                                                        </li>


                                                        <li class="pb-2">
                                                            <span>{{__('forum.Offline Quiz')}} </span>
                                                            <label class="switch_toggle float-end"
                                                                   for="forum_auto_offline_quiz_status">
                                                                <input type="checkbox"
                                                                       class=""
                                                                       name="forum_auto_offline_quiz_status"
                                                                       id="forum_auto_offline_quiz_status"
                                                                       {{Settings('forum_auto_offline_quiz_status')==1?'checked':''}}
                                                                       value="1">
                                                                <i class="slider round"></i>
                                                            </label>
                                                        </li>

                                                        <li class="pb-2">
                                                            <span>{{__('forum.Learning Path')}} </span>
                                                            <label class="switch_toggle float-end"
                                                                   for="forum_auto_learning_path_status">
                                                                <input type="checkbox"
                                                                       class=""
                                                                       name="forum_auto_learning_path_status"
                                                                       id="forum_auto_learning_path_status"
                                                                       {{Settings('forum_auto_learning_path_status')==1?'checked':''}}
                                                                       value="1">
                                                                <i class="slider round"></i>
                                                            </label>
                                                        </li>


                                                    </ul>

                                                </div>
                                            </div>


                                            <div class="col-lg-4">
                                                <div class="input-effect fixed-width">
                                                    <h3>{{__('forum.Approval Topics')}}
                                                    </h3>

                                                    <ul class="">

                                                        <li class="pb-2">
                                                            <span>{{__('forum.Auto Approval')}} </span>
                                                            <label class="switch_toggle float-end"
                                                                   for="forum_auto_approval_topic_status">
                                                                <input type="checkbox"
                                                                       class=""
                                                                       name="forum_auto_approval_topic_status"
                                                                       id="forum_auto_approval_topic_status"
                                                                       {{Settings('forum_auto_approval_topic_status')==1?'checked':''}}
                                                                       value="1">
                                                                <i class="slider round"></i>
                                                            </label>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-effect fixed-width">
                                                    <h3>{{__('forum.Approval thread')}} </h3>
                                                    <ul class="">


                                                        <li class="pb-2">
                                                            <span>{{__('forum.Auto Approval')}} </span>
                                                            <label class="switch_toggle float-end"
                                                                   for="forum_auto_approval_thread_status">
                                                                <input type="checkbox"
                                                                       class=""
                                                                       name="forum_auto_approval_thread_status"
                                                                       id="forum_auto_approval_thread_status"
                                                                       {{Settings('forum_auto_approval_thread_status')==1?'checked':''}}
                                                                       value="1">
                                                                <i class="slider round"></i>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-40 ">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="primary-btn fix-gr-bg text-center"

                                                >
                                                    <i class="ti-check"></i>

                                                    {{__('common.Update')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="tab-pane fade white-box active show mt-3 " id="SMS" role="tabpanel"
                                     aria-labelledby="SMS-tab">
                                    <input type="hidden" name="g_set" value="1">
                                    <div class="General_system_wrap_area d-block">
                                        <div class="single_system_wrap">
                                            <h5>{{__('forum.To run automatic remove 30 days oldest deleted topic/thread')}}
                                                .</h5>
                                            <div class="single_system_wrap_inner text-center">

                                                <p style="overflow-wrap: anywhere;">{{ 'cd ' . base_path() . '/ && php artisan forum:oldest-delete >> /dev/null 2>&1' }}</p>

                                            </div>
                                            <h6>{{__('forum.In cPanel you should set time interval 24 hours')}}.</h6>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
