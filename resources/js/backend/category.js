
import addDeleteForms from "../plugins";
$(function () {


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
        "language": {
            "url": "http://myblog.test/json/"+langDataTable
        },
        "lengthMenu": [ 5, 10, 15, 25, 30 ],
        "columns": [
            { data: "id" , orderable: false},
            { data: "name" },
            { data: "slug" },
            { data: "created_at" },
            { data: "updated_at"},
            { data: "parent_of"},
            { data: "action" , orderable: false},

        ],
        "order": [[ 1, "desc" ]],
        "drawCallback": ( settings ) => {
            addDeleteForms();
        }
    });

    $("#category_add").validate({
        errorClass: "alert alert-danger",
        errorElement: "div",
        rules:{
            name:'required'
        }
    });

});
