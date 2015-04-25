define(['jquery', 'basepath'], function($, basepath) {
    
    return function(id, path) {
        $.ajax({
            type: "POST",
            url: basepath + "gintonic_c_m_s/Albums/upload_photos/",
            dataType: 'json',
            data: {
                id: $('#user-id').val(),
                file_id: id,
            },
            success: function(response, status) {
                //$('#userphoto').attr('src', response.file);
                if (response.success) {
                    /*$('#contact-alert').html(
                            '<div class="alert alert-dismissable alert-success">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + response.message +
                            '</div>'
                            );*/
                    loadFiles(id);                    
                } else {
                    /*$('#contact-alert').html(
                            '<div class="alert alert-dismissable alert-danger">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + response.message +
                            '</div>'
                            );*/
                }
            },
            error: function(response, status) {
                /*$('#contact-alert').html(
                        '<div class="alert alert-dismissable alert-danger">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                        '<strong>Error:</strong> Something going wrong on server. Please try latter!!!' +
                        '</div>'
                        );*/
            }
        });
        
        function loadFiles(fileIds){
            
            $.ajax({
                url: basepath + "gintonic_c_m_s/Albums/loadFiles/",
                type: 'POST',
                data: {
                    fileIds: fileIds,
                    userId: $('#user-id').val(),
                    loggedInUserId: $('#logged-in-user-id').val(),
                },
                success: function (response) {
                    $('[data-photogalary]').append(response);
                    //$('[data-photogalary]').last('div').children('[data-delete-image]').bind('click');
                },
                error: function (response) {
                    
                }
            });
        }
    };

});