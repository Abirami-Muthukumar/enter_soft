@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'acs LMS'}} | Invoice
@endsection
@section('css')
    <link href="{{asset('public/frontend/acslmstheme/css/my_invoice.css')}}{{assetVersion()}}" rel="stylesheet"/>
@endsection
@section('mainContent')

    <x-subscription-invoice-page-section :enroll="$enroll"/>

@endsection
@section('js')
    <script src="{{ asset('public/frontend/acslmstheme') }}/js/html2pdf.bundle.js{{assetVersion()}}"></script>
    <script src="{{ asset('public/frontend/acslmstheme/js/my_invoice.js') }}{{assetVersion()}}"></script>
@endsection
