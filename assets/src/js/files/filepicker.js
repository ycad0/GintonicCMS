require(['jquery'], function ($) {
    $('.upload').click(function(){
        $('.upload').button('loading');
        var callback = $(this).attr('data-upload-callback');
        var multipleFiles = $(this).attr('data-multiple');
        var dirname = $(this).attr('data-dir');
        var dirurl = "";
        if (typeof dirname !== 'undefined'){
            dirurl = "/dir:"+dirname;
        }
        $.get("/gintonic_c_m_s/files/add/"+callback+dirurl, function(data){
            $('#modal-loader').html(data);
            $('#file-modal').modal('show');
            $('.upload').button('reset');            
       
            if (multipleFiles === 'true'){
                $('#FileTmpFile').prop('multiple','multiple');
            }
        });
    });
    // Function called when an image is added. id is the file id in the database
    function uploadComplete(id, path, callbackModule){
        $('#file-modal').modal('hide');
        require([callbackModule], function(callback){
            callback(id, path);
        });
    };
    
    // Global so it can be called outside of require.js
    window.uploadComplete = uploadComplete;
    //Allow to Edit Title
    $('.editTitle').on('click',function(){
        $('#Fileid').val($(this).data('pk'));
        $('#FileTitle').val($(this).data('value'));
        $('.modal-footer').children('input[type="submit"]').show();
        $('.modal-footer').children('button.btn-primary').hide();
        $('#editTitleModal').modal();
    });
    $('.getFileLink').on('click',function(){
        $('#FileLink').val($(this).data('value'));
        $('#getFileLinkModal').modal();
    });
    $('#FileUpdateForm').on('submit',function (e){
        $('.modal-footer').children('input[type="submit"]').hide();
        $('.modal-footer').children('button').show();
        e.preventDefault();
        $.ajax({
            url: $(this).prop('action'),
            type: 'POST',
            dataType:'json',
            data:$(this).serialize(),
            success: function (response) {
                if(response.status=='success'){
                    $('#editTitleModal').modal('hide');
                    $('#title_'+response.id).html(response.value);
                    $('[data-pk="'+response.id+'"').data('value',response.value);
                }
            }
        });    
    });
});
