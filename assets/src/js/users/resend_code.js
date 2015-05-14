define(function (require) {
    // Dependencies
    var $ = require('jquery');
    var jqueryvalidate = require('jqueryvalidate');

    jQuery('#UserResendVerificationForm').validate({
        rules: {
            "email": {
                required: true,
                email: true
            }
        },
        messages: {
            "email": {
                required: "Please enter Email Address",
                email: "Please enter valid Email Address"
            }
        }
    });
});
