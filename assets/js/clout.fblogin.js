//Initialize the API
window.fbAsyncInit = function() {
  	FB.init({
    	appId      : '808224532637074',
    	cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    	xfbml      : true,  // parse social plugins on this page
    	version    : 'v2.5' // use version 2.5
  	});

	// Get the user's login status and process based on that
	FB.getLoginStatus(function(fresponse) {
    	statusChangeCallback(fresponse);
	});
};


// Load the SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


  
// This is called with the results from FB.getLoginStatus().
function statusChangeCallback(response) {
    // The response object is returned with a status field that lets the
    // app know the current login status of the user.
    if (response.status === 'connected') {
      	// Logged in. Now populate the values as returned
      	populateValues(response);
    } else if (response.status === 'not_authorized') {
      	//console.log('The user is not authorized to login');
    } else {
		//console.log('The user to login');
    }
}

  
function fb_login() {
    if(typeof FB !== 'undefined'){
		FB.login( function(response) {
			statusChangeCallback(response);
		}, 
		{ 
			scope: 'email,public_profile,user_birthday,user_location' 
		});
	} else {
		$('#enable_tracking_msg').slideDown('fast');
	}
} 


// Populate the form fields from the form response
function populateValues(fresponse) {
	FB.api('/me?fields=id,email,name,first_name,last_name,age_range,link,birthday,gender,timezone', function(response) {
     
	 if(typeof response.id !== 'undefined'){
	 	var fbdata = {
			facebookId: response.id, 
	 		email: (typeof response.email !== 'undefined'? response.email: ''), 
			name: (typeof response.name !== 'undefined'? response.name: ''), 
			firstName: (typeof response.first_name !== 'undefined'? response.first_name: ''), 
			lastName: (typeof response.last_name !== 'undefined'? response.last_name: ''), 
			ageRange: (typeof response.age_range !== 'undefined'? 
						'min='+(typeof response.age_range.min !== 'undefined'? response.age_range.min: 'none')+','+
						'max='+(typeof response.age_range.max !== 'undefined'? response.age_range.max: 'none')
					   : ''), 
			gender: (typeof response.gender !== 'undefined'? response.gender: ''), 
			birthday: (typeof response.birthday !== 'undefined'? response.birthday: ''), 
			profileLink: (typeof response.link !== 'undefined'? response.link: ''), 
			timezoneOffset: (typeof response.timezone !== 'undefined'? response.timezone: ''), 
	 	};
	 	// save the facebook details for later re-use
		saveFacebookDetails(fbdata);
	 }
	
	 if(typeof response.id !== 'undefined') $('#facebookid').val(response.id);
	 if(typeof response.first_name !== 'undefined') {
		 $('#firstname').val(response.first_name);
		 $('#firstname').prop("readonly", true);
	 }
	 if(typeof response.last_name !== 'undefined') {
		 $('#lastname').val(response.last_name);
		 $('#lastname').prop("readonly", true);
	 }
	 if(typeof response.gender !== 'undefined') {
		 $('#gender__gender').val(capitalizeFirstLetter(response.gender));
		 $('#gender__gender option:not(:selected)').attr('disabled', true);
	 }
	  
	 if(typeof response.birthday !== 'undefined') var age = response.birthday.split('/');
	 if(typeof age !== 'undefined') {
		 $('#birthmonth__monthnumber').val(age[0]);
		 $('#birthmonth__monthnumber option:not(:selected)').attr('disabled', true);
	 }
	 if(typeof age !== 'undefined') {
		 $('#birthday__monthday').val(age[1]);
	  	 $('#birthday__monthday option:not(:selected)').attr('disabled', true);
	 }
	 if(typeof age !== 'undefined') {
		 $('#birthyear__pastyear').val(age[2]);
	  	 $('#birthyear__pastyear option:not(:selected)').attr('disabled', true);
	 }
	  
	 if(typeof response.email !== 'undefined') {
		 $('#emailaddress').val(response.email);
		 $('#emailaddress').prop("readonly", true); //Prevent changing the email address
		  
		 $('#signupwithfb').hide('fast');
		 $('#signupwithfb_msg').show('fast');
	  	  
		 $('#emailverified').val('Y');
	 }
    }); 
	
	
	
	FB.api('/'+fresponse.authResponse.userID+'/picture?type=large', function(response) {
        if(typeof fresponse.authResponse.userID !== 'undefined'){
			var fbdata = {
				facebookId: fresponse.authResponse.userID, 
	 			photoUrl: (typeof response.data.url !== 'undefined'? response.data.url: ''), 
				isSilhouette: (typeof response.data.is_silhouette !== 'undefined'? response.data.is_silhouette: '')
			}
			
			saveFacebookDetails(fbdata);
		}
	});

}






// save facebook details for use in the user's account profile
function saveFacebookDetails(fbdata)
{
	$.ajax({
        type: "POST",
       	url: getBaseURL()+"account/save_facebook_data",
      	data: fbdata,
      	beforeSend: function() {
           	//Do nothing
		},
      	 success: function(data) {
			//Do nothing (silence) - as the user is submitting the form with more data
		}
   	});
}