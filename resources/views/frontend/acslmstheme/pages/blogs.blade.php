@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'acs LMS'}} | {{__('frontend.Blog')}} @endsection
@section('css') @endsection
@section('js')
    <script src="{{asset('public/frontend/acslmstheme/js/blogs.js')}}"></script>
@endsection

@section('mainContent')

    <x-breadcrumb :banner="$frontendContent->blog_page_banner"
                  :title="trans('frontend.Explore Our Blog Posts')"
                  :subTitle="trans('frontend.Blogs')"/>


    <x-blog-page-section/>

@endsection
