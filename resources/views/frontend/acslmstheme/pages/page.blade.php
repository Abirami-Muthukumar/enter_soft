@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'acs LMS'}} | {{$page->title}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')



    <x-breadcrumb :banner="$page->banner" :title="$page->title"
                  :subTitle="trans('frontend.Pages')"/>

    <x-front-page-section :page="$page"/>

@endsection
