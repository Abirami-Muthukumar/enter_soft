@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'acs LMS'}} | {{__('common.Checkout')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/acslmstheme/css/select2.min.css')}}{{assetVersion()}}" rel="stylesheet"/>
@endsection
@section('mainContent')

    <x-breadcrumb :banner="$frontendContent->about_page_banner" :title="trans('frontend.Complete Your Purchase')"
                  :subTitle="trans('frontend.Checkout')"/>

    <x-checkout-page-section :request="$request"/>

@endsection
@section('js')
    <script src="{{asset('public/frontend/acslmstheme/js/select2.min.js')}}"></script>
    <script src="{{asset('public/frontend/acslmstheme/js/checkout.js')}}"></script>
    <script src="{{asset('public/frontend/acslmstheme/js/city.js')}}"></script>
@endsection
