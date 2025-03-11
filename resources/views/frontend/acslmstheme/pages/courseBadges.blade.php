@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'acs LMS'}} | {{__('frontend.Course Badges')}}
@endsection
@section('css')
    <style>
        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .course_badge_section .dashboard_badge_carousel {
                min-height: initial;
            }
        }

        .course_badge_section .dashboard_badge_carousel {
            min-height: initial;
        }
    </style>

@endsection
@section('js')
    <script>
        "use strict";
        $(document).ready(function () {
            $("#course_badge_carousel").owlCarousel({
                loop: false,
                margin: 10,
                nav: false,
                dots: false,
                items: 5,
                center: true,
                responsive: {
                    0: {
                        items: 3
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
                    },
                    1500: {
                        items: 7
                    }
                }
            });
        });


        function copyCurrentUrl(url) {
            var copyText = document.createElement("input");
            copyText.value = url;
            document.body.appendChild(copyText);
            copyText.select();
            document.execCommand("copy");
            document.body.removeChild(copyText);
            toastr.success("{{__('frontend.Link Copied')}}");
        }
    </script>
@endsection

@section('mainContent')
    <div>
        <div class="main_content_iner main_content_padding">
            <div class="dashboard_lg_card">
                <div class="container-fluid g-0">
                    <div class="my_courses_wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div
                                    class="section__title3 gap-3 d-flex flex-wrap align-items-center justify-content-between">
                                    <h3 class="mb-0">
                                        {{ __("frontend.Course Badges") }}
                                    </h3>
                                    @php
                                        $user = auth()->user();
                                    @endphp
                                    <button class="theme_btn height_50" onclick="copyCurrentUrl('{{$user->username?route('profileUniqueUrl',$user->username):''}}?tab=course_badges')"
                                            >
                                        {{__('communication.Copy Link')}}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex align-items-center course_badge_section">
                            <div class="col-12">
                                <div class="dashboard_badge_carousel mt-4 owl-carousel" id="course_badge_carousel">

                                    @foreach($badges as $badge)
                                        @if($badge->course->course_badge)
                                            <div class="dashboard_badge_item text-center">
                                                <div class="img"><img
                                                        src="{{asset($badge->course->course_badge)}}"
                                                        alt=""></div>

                                            </div>
                                        @endif
                                    @endforeach

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
