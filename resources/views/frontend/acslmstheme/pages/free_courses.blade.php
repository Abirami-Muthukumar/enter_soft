@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'acs LMS'}} | {{__('courses.Courses')}} @endsection
@section('css') @endsection

@section('js')
    <script src="{{asset('public/frontend/acslmstheme/js/classes.js')}}"></script>
@endsection
@section('mainContent')
    <x-breadcrumb :banner="trans('common.N/A')"
                  :title="trans('frontend.Get free courses')"
                  :subTitle="trans('frontend.Free')"/>

    <x-free-course-page-section :request="$request" :categories="$categories" :languages="$languages"/>
@endsection

