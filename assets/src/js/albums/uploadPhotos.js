define(['jquery'], function($) {
    
    return function(id, path) {
        $.ajax({
            type: "POST",
            url: "gintonic_c_m_s/albums/uploadPhotos/",
            dataType: 'json',
            data: {
                id: $('#user-id').val(),
                file_id: id,
            },
            success: function(response, status) {
                if (response.success) {
                    loadFiles(id);                    
                }
            },
            error: function(response, status) {
            }
        });
        
        function loadFiles(fileIds){
            
            $.ajax({
                url: "gintonic_c_m_s/Albums/loadFiles/",
                type: 'POST',
                data: {
                    fileIds: fileIds,
                    userId: $('#user-id').val(),
                    loggedInUserId: $('#logged-in-user-id').val(),
                },
                success: function (response) {
                    $('[data-photogalery]').append(response);
                }
            });
        }
    };

});
