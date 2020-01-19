
import addDeleteForms from "../plugins";
$(function () {
    if ($('#tag_table').length) {
        $('#tag_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": '/admin/tags/ajaxData',
                "type": "POST"
            },
            "language": {
                "url": "http://myblog.test/json/"+langDataTable
            },
            "lengthMenu": [ 5, 10, 15, 25, 30 ],
            "columns": [
                { data: "id" , orderable: false},
                { data: "tag_name" },
                { data: "slug" },
                { data: "created_at" },
                { data: "updated_at"},
                { data: "action" , orderable: false},

            ],
            "order": [[ 1, "desc" ]],
            "drawCallback": ( settings ) => {
                addDeleteForms();
            }
        });
    }



    //Validate
    if ($("#tag_add_edit").length) {
        $("#tag_add_edit").validate({
            errorClass: "alert alert-danger",
            errorElement: "div",
            rules:{
                tag_name:'required'
            }
        });
    }


});
