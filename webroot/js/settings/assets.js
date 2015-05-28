define(["jquery"], function (e) {
    
    var $ = require("jquery");
    
    $('.setup').on('click', function() {
        
        url = $(this).data('src');
        id = $(this).data('id');
        
        $.ajax({
            url: url,
            success: function(response){
                console.log(response);
            }
        });
        
    });
});