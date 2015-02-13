define(function(require){
    // Dependencies
     var $            = require('jquery');
     var jqueryvalidate = require('jqueryvalidate');
	
	$(document).ready(function() {	
                jQuery('#UserLoginForm').validate({
                    errorClass: "error",
                    rules:{
                            "data[User][email]":{
                                    required: true,
                                    email: true
                            },
                            "data[User][password]":{
                                    required: true
                            }
                    },
                    messages:{
                            "data[User][email]":{
                                    required: "Please enter Email Address",
                                    email: "Please enter valid Email Address"
                            },
                            "data[User][password]":{
                                    required: "Please enter Password"
                            }
                    }
            });
	});
});
