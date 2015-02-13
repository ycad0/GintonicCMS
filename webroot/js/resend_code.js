define(function(require){
    // Dependencies
	var $            = require('jquery');
	var jqueryvalidate = require('jqueryvalidate');
	
	jQuery('#UserResendVerificationForm').validate({
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
