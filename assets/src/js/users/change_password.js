define(function(require){
    // Dependencies
     var $ = require('jquery');
     var jqueryvalidate = require('jqueryvalidate');
	
	$(document).ready(function() {	
                jQuery('#UserChangePasswordForm').validate({
                    errorClass: "error",
                    rules:{
                            "current_password":{
                                    required: true,
                            },
                            "new_password":{
                                    required: true,
                            },
                            "confirm_password":{
                                    required: true,
                                    equalTo:'#new-password'
                            }
                    },
                    messages:{
                            "current_password":{
                                    required: "Please enter current password."
                            },
                            "new_password":{
                                    required: "Please enter new password."
                            },
                            "confirm_password":{
                                    required: "Please enter confirm password.",
                                    equalTo: "Please enter confirm password same as new password."
                            }
                    }
            });
	});
});
