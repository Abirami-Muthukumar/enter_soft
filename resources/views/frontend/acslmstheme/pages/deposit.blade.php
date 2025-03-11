@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'acs LMS'}} | {{__('payment.Fund Deposit')}} @endsection
@section('css') @endsection
@section('js')
    <script src="{{asset('public/frontend/acslmstheme/js/deposit.js')}}"></script>


@endsection

@section('mainContent')
    <x-deposit-page-section :request="$request"/>
@endsection
