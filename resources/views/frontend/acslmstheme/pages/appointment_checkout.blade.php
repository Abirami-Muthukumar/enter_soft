@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'acs LMS'}} | {{__('common.Checkout')}}
@endsection
@section('css')
    <link rel="stylesheet"
          href="{{ asset('Modules\Appointment\Resources\assets\frontend\css\appointment.css') }}{{assetVersion()}}"/>
@endsection
@section('mainContent')

    <x-appointment-checkout-page-section :request="$request"/>

@endsection
@section('js')
    <script src="{{asset('public/frontend/acslmstheme/js/select2.min.js')}}"></script>
    <script src="{{asset('public/frontend/acslmstheme/js/checkout.js')}}"></script>
    <script src="{{asset('public/frontend/acslmstheme/js/city.js')}}"></script>
@endsection
