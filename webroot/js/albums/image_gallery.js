define(['jquery'], function ($) {

    var $ = require('jquery');

    $(document).ready(function () {

        $('[data-delete-image]').on('click', function () {
            imageId = this.id;
            fileId = $(this).data('fileid');
            fileName = $(this).data('filename');

            $.ajax({
                url: "/gintonic_c_m_s/Albums/deleteImage/",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: imageId,
                    fileId: fileId,
                    fileName: fileName
                },
                success: function (response) {
                    
                    if (response.success) {
                        
                        /*$('#contact-alert').html(
                                '<div class="alert alert-dismissable alert-success">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + response.message +
                                '</div>'
                                );*/
                        $('#'+imageId).parent().remove();
                    } else {
                        /*$('#contact-alert').html(
                                '<div class="alert alert-dismissable alert-danger">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + response.message +
                                '</div>'
                                );*/
                    }
                },
                error: function (response, status) {
                    /*$('#contact-alert').html(
                            '<div class="alert alert-dismissable alert-danger">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            '<strong>Error:</strong> Something going wrong on server. Please try latter!!!' +
                            '</div>'
                            );*/
                }
            });
        });
    });
    
    
});
