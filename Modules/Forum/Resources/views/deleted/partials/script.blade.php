@includeIf('forum::deleted.partials.delete')
@includeIf('forum::deleted.partials.restore')
<script>
    $(document).on('click', '.restoreForum', function () {
        let id = $(this).data('id');
        let forumType = $(this).data('forumType');
        $('#restoreId').val(id);
        $('#restoreType').val(forumType);
        $("#restoreModal").modal('show');
    });

    $(document).on('click', '.deleteForum', function () {
        let id = $(this).data('id');
        let forumType = $(this).data('forumType');
        $('#deleteId').val(id);
        $('#deleteType').val(forumType);
        $("#deleteModal").modal('show');
    });

</script>
