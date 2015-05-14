define(function(require) {
    // Dependencies
    var $ = require('jquery');
    var jqueryvalidate = require('jqueryvalidate');

    $(document).ready(function() {
        jQuery('#UserForgotPasswordForm').validate({
            errorClass: "error",
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
});
