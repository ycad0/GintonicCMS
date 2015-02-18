define(function(require){
    // Dependencies
    var $            = require('jquery');
     var jqueryvalidate = require('jqueryvalidate');
	
	$(document).ready(function() {	
                jQuery('#UserSignupForm').validate({
                    errorClass: "error",
                    rules:{
                            "first":{
                                    required: true
                            },
                            "last":{
                                    required: true
                            },
                            "email":{
                                    required: true,
                                    email: true
                            },
                            "password":{
                                    required: true
                            }
                    },
                    messages:{
                            "first":{
                                    required: "Please enter firstname"
                            },
                            "last":{
                                    required: "Please enter lastname"
                            },
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
