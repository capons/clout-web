// JavaScript Document

$(function() {
	$(document).on('change', '#settingphotourl__fileurl', function() {
		if($('#settingphotosubmit').length == 0) $(this).after("<button type='submit' id='settingphotosubmit' name='settingphotosubmit' class='submitmicrobtn' style='display:none;'>Submit</button>");
		
		$('#settingphotosubmit').click();
	});
	
	
	
	//Requires a verification code
	$(document).on('click', '.privacy-table .radio-item.temporary', function() {
		var clickedDiv = $(this);
		var itemId = $(this).data('id');
		var itemType = $(this).data('type');
		
		$(this).parents('.privacy-table').first().find('.extra-info').each(function(){
			$(this).remove();
		});
		
		
		clickedDiv.children('div').last().append("<div class='extra-info'><input type='text' name='verificationcode' id='verificationcode' value='' class='smalltextfield one-field-submit on-focus-out' data-action='account/settings/a/activate_contact/d/"+itemId+"/t/"+itemType+"'  data-resultsdiv='saved_"+itemType+"_list' placeholder='Enter Code' style='min-width:80px;max-width:100%;' /></div>");
		
		$('#verificationcode').focus();
	});
	
	
	
	
	
	
	
	
	
	// Add new access rule
	$(document).on('click', '.add-access-rule', function(event){
		var clickedBtn = $(this);
		var formObj = $(this).parents('.microform').first();
		var formObjDiv = formObj.parents('div').first();
		var inputs = formObj.find('input, textarea, select');
		var activate = true;
		
		inputs.each(function(){
			if(!$(this).hasClass('optional') && $(this).attr('type') != 'hidden' && $(this).val().length < 1){
				//console.log('FIELD ID: '+$(this).attr('id'));
				activate = false;
				return false;
			}
		});
		
		
		if(inputs.length > 0 && activate)
		{
			var parameters = {
        		type: "POST",
       			url: getBaseURL()+'setting/add_rule',
				// How to handle getting the "form" data
      			data: inputs.serializeArray(),
				// What to do as the data is being processed
      			beforeSend: function() {},
				error: function( xhr, textStatus, errorThrown) {
    				//console.log('LOG: '+xhr.responseText);
					showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
				},
      	 		success: function(data) {
					if(data.match(/error/i)) {
						//console.log('END LOG: '+data);
						showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
					} 
					//Submission was successful
					else {
						showServerSideFadingMessage('The rule data has been saved.');
						
						var parentRow = formObjDiv.parents('.add-more-row').first();
						parentRow.before(data);
						//Show the header if its hidden
						parentRow.parents('table').first().find('thead').first().show('fast');
					}
				}
			}
		
			//Run the ajax parameters
			$.ajax(parameters);
		}
		// A non-optional field has not been entered
		else {
			showServerSideFadingMessage('ERROR: All non-optional fields are required to continue.');
		}
	});
	
	
	
	
	
	
	
	
	
	
	// Save permission group
	$(document).on('click', '.save-permission-group', function(event){
		var formObj = $(this).parents('.microform').first();
		var inputs = formObj.find('input, textarea, select');
		
		if($.trim($('#permissiongroupname').val()) !='')
		{
			var parameters = {
        		type: "POST",
       			url: formObj.find('#action').first().val(),
				// How to handle getting the "form" data
      			data: inputs.serializeArray(),
				// What to do as the data is being processed
      			beforeSend: function() {},
				error: function( xhr, textStatus, errorThrown) {
    				//console.log('LOG: '+xhr.responseText);
					showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
				},
      	 		success: function(data) {
					showServerSideFadingMessage('The permission data has been saved.');
					document.location.href= formObj.find('#redirect').first().val();
				}
			}
		
			//Run the ajax parameters
			$.ajax(parameters);
		}
		// A non-optional field has not been entered
		else {
			showServerSideFadingMessage('ERROR: Enter the group details to proceed.');
		}
	});
	
	
	
	
});