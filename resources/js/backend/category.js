
import addDeleteForms from "../plugins";
$(function () {
    



    if ($('#category_table').length) {
        $('#category_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": '/admin/categories/ajaxData',
                "type": "POST"
            },
            "language": {
                "url": `${baseUrl}/json/${langDataTable}`
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
            "order": [[ 0, "desc" ]],
            "drawCallback": ( settings ) => {
                addDeleteForms();
            }
        });
    }

    if ($("#category_add").length) {
        $("#category_add").validate({
            errorClass: "alert alert-danger",
            errorElement: "div",
            rules:{
                name:'required'
            }
        });
    }

});
