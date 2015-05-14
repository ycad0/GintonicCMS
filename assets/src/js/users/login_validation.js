define(function(require){
    // Dependencies
     var $= require('jquery');
     var jqueryvalidate = require('jqueryvalidate');
	
	$(document).ready(function() {	
                jQuery('#UserLoginForm').validate({
                    errorClass: "error",
                    rules:{
                            "email":{
                                    required: true,
                                    email: true
                            },
                            "password":{
                                    required: true
                            }
                    },
                    messages:{
                            "email":{
                                    required: "Please enter Email Address",
                                    email: "Please enter valid Email Address"
                            },
                            "password":{
                                    required: "Please enter Password"
                            }
                    }
            });
	});
});
