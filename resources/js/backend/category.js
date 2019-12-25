$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#demo_table').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": {
                "url": '/admin/categories/ajaxData',
                "type": "POST"
            },
            "lengthMenu": [ 5, 10, 15, 25, 30 ],
          "columns": [
            { data: "id" },
            { data: "name" },
            { data: "slug" },
            { data: "created_at" },
            { data: "updated_at"},
            { data: "action"},

          ]
        });
});
