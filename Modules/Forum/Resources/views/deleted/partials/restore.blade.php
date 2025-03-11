<div class="modal fade admin-query" id="restoreModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('common.Restore')}}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                        class="ti-close "></i></button>
            </div>

            <div class="modal-body">
                <form action="{{route('forum.topic.restore')}}" method="post">
                    @csrf
                    <div class="text-center">
                        <h4>{{__('forum.Are you sure to restore')}}? </h4>
                    </div>
                    <input type="hidden" name="id" value="" id="restoreId">
                    <input type="hidden" name="type" value="" id="restoreType">
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg"
                                data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                        <button class="primary-btn fix-gr-bg"
                                type="submit">{{__('common.Confirm')}}</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
