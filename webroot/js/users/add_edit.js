define(function(require){
    // Dependencies
    var $= require('jquery');
     var jqueryvalidate = require('jqueryvalidate');
	
	$(document).ready(function() {	
                jQuery('#UserAddEditForm').validate({
                    errorClass: "error",
                    rules:{
                            "first":{
                                    required: true,
                                    minLength: 3,
                                    maxLength:50
                            },
                            "last":{
                                    required: true,
                                    minLength: 3,
                                    maxLength:50
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
                                    required: "Please enter firstname",
                                    minLength: "Please enter first name at least 3 characters.",
                                    maxLength: "Please enter first name between 3 to 50 characters."
                            },
                            "last":{
                                    required: "Please enter lastname",
                                    minLength: "Please enter last name at least 3 characters.",
                                    maxLength: "Please enter last name between 3 to 50 characters."
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
