@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'acs LMS'}} | {{__('certificate.My Certificates')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <x-my-certificate-page-section/>
@endsection