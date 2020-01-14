
import addDeleteForms from "../plugins";
$(function () {
    if ($('#editor').length > 0) {
        CKEDITOR.addCss('.cke_editable { font-size: 15px; padding: 2em; }');

        CKEDITOR.replace('editor', {
            language: langCKeditor4,
          toolbar: [{
              name: 'document',
              items: ['Print']
            },
            {
              name: 'clipboard',
              items: ['Undo', 'Redo']
            },
            {
              name: 'styles',
              items: ['Format', 'Font', 'FontSize']
            },
            {
              name: 'colors',
              items: ['TextColor', 'BGColor']
            },
            {
              name: 'align',
              items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
            },
            '/',
            {
              name: 'basicstyles',
              items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
            },
            {
              name: 'links',
              items: ['Link', 'Unlink']
            },
            {
              name: 'paragraph',
              items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
            },
            {
              name: 'insert',
              items: ['Image', 'Table']
            },
            {
              name: 'tools',
              items: ['Maximize']
            },
            {
              name: 'editing',
              items: ['Scayt']
            }
          ],

          extraAllowedContent: 'h3{clear};h2{line-height};h2 h3{margin-left,margin-top}',

          // Adding drag and drop image upload.
          extraPlugins: 'print,format,font,colorbutton,justify,uploadimage',
          uploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',

          // Configure your file manager integration. This example uses CKFinder 3 for PHP.
          filebrowserBrowseUrl: 'http://myblog.test/ckfinder/browser',
          filebrowserImageBrowseUrl: 'http://myblog.test/ckfinder/browser?type=Images',
          filebrowserUploadUrl: 'http://myblog.test/ckfinder/connector?command=QuickUpload&type=Files',
          filebrowserImageUploadUrl: 'http://myblog.test/ckfinder/connector?command=QuickUpload&type=Images',

          height: 560,

          removeDialogTabs: 'image:advanced;link:advanced'
        });
    }



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
