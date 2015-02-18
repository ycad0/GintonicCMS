/*
    Gintonic Web
    Author:    Philippe Lafrance
    Link:      http://gintonicweb.com

*/
require(['jquery'], function(){
    $('#decoy-password').focus(function(){
        $(this).val('');
    });
    $('#decoy-password').on('input', function() {
        $('#UserPassword').val($('#decoy-password').val());
    });
});