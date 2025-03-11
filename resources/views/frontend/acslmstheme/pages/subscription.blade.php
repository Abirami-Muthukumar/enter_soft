@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'acs LMS'}} | {{__('frontend.Subscription')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/acslmstheme/css/subscription.css')}}{{assetVersion()}}" rel="stylesheet"/>
@endsection


@section('mainContent')

    <x-breadcrumb :banner="trans('common.N/A')"
                  :title="trans('frontend.Choose Your Subscription Plan')"
                  :subTitle="trans('frontend.Subscription')"/>


    <x-subscription-page-section/>

@endsection
@section('js')
    <script src="{{asset('public/frontend/acslmstheme/js/subscription.js')}}{{assetVersion()}}"></script>
@endsection
