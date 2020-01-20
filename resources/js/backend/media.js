import addDeleteForms from "../plugins";

$(function () {


    if ($('#media-dropzone').length) {

        // Media DropZone Config
        new Dropzone('#media-dropzone', {

                autoProcessQueue: true,
                uploadMultiple: true,
                acceptedFiles:"image/*,application/pdf,application/octet-stream,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/plain,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                paramName: "files",
                parallelUploads: 100,
                previewsContainer:".dropzone-previews",
                addRemoveLinks: true,
                maxFiles: 2,
                sending: function(file, xhr, formData) {
                    formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                },
                init: function() {
                  var myDropzone = this;

                  // First change the button to actually tell Dropzone to process the queue.
                 document.querySelector('button[type="submit"]').addEventListener("click", function(e) {
                    // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                  });

                  // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
                  // of the sending event because uploadMultiple is set to true.
                  this.on("sendingmultiple", function() {
                    // Gets triggered when the form is actually being sent.
                    // Hide the success button or the complete form.
                  });
                  this.on("successmultiple", function(files, response) {

                    window.location.href = response.link;
                  });
                  this.on("errormultiple", function(files, response) {
                    console.log(response);
                  });
                  this.on("dragover", function() {
                    $('.needsclick').addClass('borderOver');
                  });
                  this.on("dragleave", function() {
                    $('.needsclick').removeClass('borderOver');
                  });
                  this.on("addedfile", function() {
                    $('.needsclick').addClass('addedfile');
                  });
                  this.on("removedfile", function(file) {

                    if (myDropzone.files.length === 0) {
                        $('.needsclick').removeClass('addedfile');
                    }

                  });

                }

        	  });
    }

    //DataTable Media Config
    var dtmedia = $('#media_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": '/admin/media/ajaxData',
            "type": "POST"
        },
        "language": {
            "url": "http://myblog.test/json/"+langDataTable
        },
        "lengthMenu": [ 20, 50, 100 ],
        "columns": [
            { data: "id" , orderable: false},
            { data: "thumb" , orderable: false},
            { data: "url" },
            { data: "name" },
            { data: "mime_type" },
            { data: "created_at" },
            { data: "action" },
            { data: "model_id" },
            { data: "collection_name" },
            { data: "file_name" },
            { data: "disk" },
            { data: "size" },
            { data: "manipulations" },
            { data: "custom_properties" },
            { data: "responsive_images" },
            { data: "order_column" },
            { data: "updated_at" },


        ],
        "order": [[ 16, "desc" ]],
        "drawCallback": ( settings ) => {
            addDeleteForms();
        }
    });

    dtmedia.column(0).visible(false);
    dtmedia.column(7).visible(false);
    dtmedia.column(8).visible(false);
    dtmedia.column(9).visible(false);
    dtmedia.column(10).visible(false);
    dtmedia.column(11).visible(false);
    dtmedia.column(12).visible(false);
    dtmedia.column(13).visible(false);
    dtmedia.column(14).visible(false);
    dtmedia.column(15).visible(false);
    dtmedia.column(16).visible(false);



    //Copy or Paste Url image
    $(document).on('click','.click-copy-url',function(){
        let id = $(this).attr('data-id_media');
        var copyText = document.getElementById(`copy_url${id}`);
        var url = $(`#copy_url${id}`).val()
        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/
        /* Copy the text inside the text field */
        document.execCommand("copy");

        var checkParam = getUrlParam('CKEditor');

        if (checkParam) {
            returnFileUrl(url);
        }

    });

    //Get Url Param by Javascript
    function getUrlParam( paramName ) {
       let reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' );
       let match = window.location.search.match( reParam );
       return ( match && match.length > 1 ) ? match[1] : null;
    }
    // Close CK Editor And Paste url
    function returnFileUrl(fileUrl) {

        let funcNum = getUrlParam( 'CKEditorFuncNum' );

        window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
        window.close();
    }


});
