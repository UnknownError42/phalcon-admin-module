$('table#datatable').DataTable({
    serverSide: true,
    ajax: {
        url: '{{ url(router.getRewriteUri()) }}',
        method: 'POST'
    },
    columns: [ {{ columns }} ],
    drawCallback: function () {
        popover();
    }
});