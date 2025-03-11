@extends('backend.master')
@push('styles')
    <style>
        .nice-select .list {
            width: 100%;
        }
    </style>
@endpush

@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center mt-50">

                @includeIf('forum::deleted.partials.filter')

                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        <th scope="col">{{__('common.Type')}}</th>
                                        <th scope="col">{{__('forum.Topic title')}}</th>
                                        <th scope="col">{{__('forum.Category')}}</th>
                                        {{--                                        <th scope="col">{{__('org.Org')}}</th>--}}
                                        <th scope="col">{{__('forum.Deleted Date')}}</th>
                                        <th scope="col">{{__('forum.Deleted By')}}</th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>

    </section>
    @includeIf('forum::deleted.partials.script')
@endsection
@push('scripts')

    @php
        $topic_type =request('topic_type');
             $category =request('category');
             $topic =request('topic');
             $org =request('branch');
             $url = url()->current()."?topic_type={$topic_type}&category={$category}&topic={$topic}&org={$org}";
    @endphp

    <script>

        dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.ajax = '{!! $url !!}';
        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id', orderable: true},
            {data: 'topic_type', name: 'topic_type'},
            {data: 'title', name: 'title'},
            {data: 'category_name', name: 'category.name'},
            {data: 'deleted_at', name: 'deleted_at'},
            {data: 'deleted_by_name', name: 'deletedUser.name'},
            {data: 'action', name: 'action', orderable: false},

        ];

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>

@endpush
