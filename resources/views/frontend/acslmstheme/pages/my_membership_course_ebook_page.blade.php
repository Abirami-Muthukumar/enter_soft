@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'acs LMS'}} |
    @if( routeIs('myMembership'))
        {{__('membership.My Membership')}}
    @else
        {{__('membership.My Membership')}}
    @endif
@endsection
@section('css') @endsection
@section('js')
    <script src="{{asset('public/frontend/acslmstheme/js/my_course.js')}}"></script>
@endsection

@section('mainContent')

    <x-my-membership-course-ebook :planId="$plan_id"/>

@endsection
