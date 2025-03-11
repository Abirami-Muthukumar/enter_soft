@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'acs LMS'}} | {{__('frontend.Offer Courses')}} @endsection
@section('css') @endsection

@section('js')
    <script src="{{asset('public/frontend/acslmstheme/js/classes.js')}}"></script>
@endsection
@section('mainContent')

    <x-breadcrumb :banner="trans('common.N/A')"
                  :title="trans('frontend.Special Offers Just for You')"
                  :subTitle="trans('frontend.Offer')"/>

    <x-offer-page-section :request="$request"/>
@endsection

