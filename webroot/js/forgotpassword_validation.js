define(function(require){
    // Dependencies
     var $            = require('jquery');
     var jqueryvalidate = require('jqueryvalidate');
	
	$(document).ready(function() {	
                jQuery('#UserForgotPasswordForm').validate({
                    errorClass: "error",
                    rules:{
                            "data[User][email]":{
                                    required: true,
                                    email: true
                            }
                           
                    },
                    messages:{
                            "data[User][email]":{
                                    required: "Please enter Email Address",
                                    email: "Please enter valid Email Address"
                            }
                    }
            });
	});
});
