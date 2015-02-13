define(function(require){
    // Dependencies
    var $            = require('jquery');
     var jqueryvalidate = require('jqueryvalidate');
	
	$(document).ready(function() {	
                jQuery('#UserSignupForm').validate({
                    errorClass: "error",
                    rules:{
                            "data[User][first]":{
                                    required: true
                            },
                            "data[User][last]":{
                                    required: true
                            },
                            "data[User][email]":{
                                    required: true,
                                    email: true
                            },
                            "data[User][password]":{
                                    required: true
                            }
                    },
                    messages:{
                            "data[User][first]":{
                                    required: "Please enter firstname"
                            },
                            "data[User][last]":{
                                    required: "Please enter lastname"
                            },
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
