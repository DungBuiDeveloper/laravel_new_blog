import addDeleteForms from "../plugins";
$(function () {


    $('.nav-custom .nav-item').click(function() {

        $('#type_thumb').val('image');
        if ($(this).find('.nav-link').attr('href') == '#video_thumbnail') {
            $('#type_thumb').val('video');
        }

    })
    //Get embed When input video change
    $(document).on("change","#video",function() {
        let media = convertMedia($(this).val() , true);
        if (media === false) {
            alert('Invalid Url');
            $(this).val('');
            return true;
        }else {
            $('.preview_video').empty().append(media);
        }
    });
    //Click get image for thumb
    $(document).on("click",".get_info_iamge",function() {
        let data = JSON.parse($(this).find('.info').html());
        let preview = $(this).find('img').attr('src');
        $('#thumbnail').val(data.id);
        preview = `<img src="${preview}" alt="preview image" />`;
        $('.preview_image').empty();
        $('.preview_image').append(preview);
        $("#imagelistModal .close").click();
    });

    if ($('#post_add_edit').length) {

        $('input').on('blur', function() {
            console.log($("#post_add_edit").valid());

        });

        //Validate

        $("#post_add_edit").validate({
            errorClass: "alert alert-danger",
            errorElement: "div",
            rules:{
                title:{
                    required:true,
                },
                the_excerpt:{
                    required:true,
                }
            }
        });

        //Dropzone
        new Dropzone('#post_add_edit', {

            autoProcessQueue: true,
            uploadMultiple: false,
            url:'/admin/media/storeOnlyImage',
            acceptedFiles:"image/*",
            paramName: "files",
            parallelUploads: 100,
            previewsContainer:".dropzone-previews",
            addRemoveLinks: true,
            clickable: ".needsclick",
            maxFiles: 1,
            sending: function(file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            },
            init: function() {
              var myDropzone = this;

              // First change the button to actually tell Dropzone to process the queue.
             document.querySelector('button[type="submit"]').addEventListener("click", function(e) {
                // Make sure that the form isn't actually being sent.
                if (myDropzone.files.length !== 0) {

                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                }

              });

              // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
              // of the sending event because uploadMultiple is set to true.
              this.on("sendingmultiple", function() {
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.

              });
              this.on("success", function(files, response) {
                $('#thumbnail').val(response.id_image);
                myDropzone.removeFile(files);
                $('.preview_image').empty();
                $('.preview_image').append(`<img src="${response.url_image}" alt="preview image">`);

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



    //DataTable init
    if ($('#post_table').length) {
        $('#post_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": '/admin/posts/ajaxData',
                "type": "POST"
            },
            "language": {
                    "url": `${baseUrl}/json/${langDataTable}`
            },
            "lengthMenu": [ 5, 10, 15, 25, 30 ],
            "columns": [
                { data: "id" , orderable: false},
                { data: "title" },
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



});
