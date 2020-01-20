
import addDeleteForms from "../plugins";
$(function () {

    if ($('#editor').length > 0) {


        CKEDITOR.addCss('.cke_editable { font-size: 15px; padding: 2em; }');
        CKEDITOR.replace('editor', {
            extraPlugins: 'print,format,font,colorbutton,justify,uploadimage,embed,autoembed,emoji',
            height: 300,
            language: langCKeditor4,
            embed_provider: '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',
            uploadUrl: 'http://myblog.test/admin/media/storeCkEditor',

            filebrowserBrowseUrl: `${baseUrl}/admin/media`,
            filebrowserImageBrowseUrl: `${baseUrl}/admin/media`,
            filebrowserUploadUrl: `${baseUrl}/admin/media/storeCkEditor?_token=${$('meta[name="csrf-token"]').attr('content')}&&type=file`,
            filebrowserImageUploadUrl: `${baseUrl}/admin/media/storeCkEditor?_token=${$('meta[name="csrf-token"]').attr('content')}&&type=image`,
            filebrowserUploadMethod: 'form',

            removeDialogTabs: 'image:advanced;link:advanced'

        });

    }






    $(window).on('hashchange', function() {

        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            }else{
                getData(page);
            }
        }
    });

    $(document).on('click', '#imagelistModal .pagination a',function(event)
    {
        event.preventDefault();

        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        //
        var page=$(this).attr('href').split('page=')[1];
        //
        getData(page);
    });

    function getData(page){
        $('.cover-loader').fadeIn();

        $.ajax(
        {
            url: `admin/posts/store/?page=${page}`,
            type: "get",
            datatype: "html"
        }).done(function(data){
            $("#imagelistModal .modal-body").empty().hide().html(data).fadeIn(500);
            location.hash = '';
            $('.cover-loader').fadeOut();
        }).fail(function(jqXHR, ajaxOptions, thrownError){
            alert('No response from server');
            $('.cover-loader').fadeOut();
        });
    }




});
