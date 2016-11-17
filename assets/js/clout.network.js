// JavaScript Document

$(function() {
	$( ".optionheader" ).click(function(){
		 //Close any opened seciton child
		 $('.optionchild').hide('fast');
		 //Show the desired subsection using the parent div
		 $(this).parent('div').children('div').first().show('fast');
	});

	//Now how about network
	$(".networklisttable td").click(function(){
		 //Get a section ID
		 var divId = this.id;

		 if(divId != '')
		 {
		 //Remove all previous class shows
		 $("td").removeClass('bottomborder nobottomborder bluebold blackbold');

		 //Hide all current subsection divs
		 $('.networkdetaildiv').hide('fast');

		 var subSectionDivId = divId+"_details";
		 //Show this section's div
		 $('#'+subSectionDivId).show('fast');
		 $(this).parent('tr').find('td').addClass('bottomborder');

		 //Make the selected cell blue bold
		 $(this).removeClass('bottomborder');
		 //Change the color based on the type of section
		 if(divId.toLowerCase().indexOf("network") >= 0)
		 {
			 $(this).addClass('blackbold nobottomborder');
		 }
		 else
		 {
			 $(this).addClass('bluebold nobottomborder');
	     }
		 }
	});






	// What happens when you click the tab div
	$(document).on('click', '.tabdiv', function(){
		var clickedDiv = $(this);

		$('.tabdiv').each(function(){ $(this).removeClass('selected'); });
		clickedDiv.addClass('selected');

		updateFieldLayer(getBaseURL()+clickedDiv.data('tabcategory')+'/'+clickedDiv.attr('id'),'','','tabdivdetails','');
	});







	//Remove a div if clicked
	//Bind to element even if loaded later
	$(document).on('click', '.listdivs', function(){
		if($('#emailpastevalues').length){
			//First remove its value from the list of selected values
			var selectedEmail = $(this).html();
			var currentEmailArray = $('#emailpastevalues').val().split('|');
			currentEmailArray.splice( $.inArray(selectedEmail, currentEmailArray), 1 );
			$('#emailpastevalues').val(currentEmailArray.join('|'));
		}
		//Now remove the div
		$(this).remove();
	});






	// How to handle the accordion option divs
	$(document).on('click', '.accordion-options > .header', function(){
		var header = $(this);

		if(header.hasClass('open')){
			header.removeClass('open');
			header.parents('.accordion-options').first().find('.details').first().slideUp('fast');
		} else {
			header.addClass('open');
			header.parents('.accordion-options').first().find('.details').first().slideDown('fast');
		}
	});






	// How to handle the accordion option divs
	$(document).on('click', '#sendpasteemails', function(){
		if($('#emailpastevalues').val() != '' || $('#newemail').val() != ''){
			var contacts = [];
			var clicked = $(this);
			var urlExt = '/t/external';

			if($('#emailpastevalues').val() != '') contacts = $('#emailpastevalues').val().split('|');
			if($('#newemail').val() != '') contacts.push($('#newemail').val());
			if($(this).data('type') && $(this).data('type') == 'internal') urlExt = '/t/internal/r/paste_email';


			// Process the form data submitted
			$.ajax({
        		type: "POST",
       			url: getBaseURL()+"network/send_invitations"+urlExt,
      			data: {'contacts': contacts},
      			beforeSend: function() {
           			clicked.prop("disabled",true);
				},
				error: function( xhr, textStatus, errorThrown) {
    				//console.log(xhr.responseText);
					clicked.prop("disabled",false);
				},
      			success: function(data) {
					console.log(data);
					var form = clicked.parents('.microform').first();
					var url = form.find('#redirectaction').first().val();

					if(typeof url !== "undefined") location.href = url;
					else $('#paste_email_details').html(data);

					//Disable the sending button if still here
					clicked.prop("disabled",false);
				}
   			});
		}
		else showServerSideFadingMessage('Please enter or paste emails to continue.');
	});






	// --------------------------------------------------------------------------------------------------------
	// Add another link functionality
	// --------------------------------------------------------------------------------------------------------
	$(document).on('click', '#addanotherlink', function(e){
		$('button#addanotherlink.btn.green').prop("disabled",true);
		if($(this).hasClass('allow-custom')){
			updateFieldLayer(getBaseURL()+'network/custom_link','','','custom_link_details','');
			$(this).hide('fast');
		}
		else {
			updateFieldLayer(getBaseURL()+'network/share_your_link','','','share_your_link_details','');
			showServerSideFadingMessage('A new link to share has been added.');
		}
		$('button#addanotherlink.btn.green').prop("disabled",false);
	});

	$(document).on('click', '#cancelcustomlink', function(e){
		$('#addanotherlink').show('fast');
		$('#custom_link_details').hide('fast');
	});

	// user is posting a custom link
	$(document).on('click', '#addcustomlink', function(e){
		if($('#isvalidcode').val() == 'Y'){
			$.ajax({
        		type: "POST",
       			url: getBaseURL()+"network/custom_link",
      			data: {new_code: $('#newreferralcode').val()},
      			beforeSend: function() {},
				error: function( xhr, textStatus, errorThrown) {
    				console.log(xhr.responseText);
				},
      			success: function(data) {
					$('#share_your_link_details').html(data);
				}
   			});
		}
		else showServerSideFadingMessage('ERROR: Your custom referral code is not valid.');
	});













});
