// JavaScript Document


// Initialize the calendars on the page
$(function() {
	if($('.calendar').length > 0){
		// This will require including the timepicker-addon js file
		if($('.calendar.showtime').length > 0){
			$('.calendar.showtime').datetimepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'mm/dd/yy',
				timeFormat: "hh:mm tt"
			});
		}
	}




	//Handle cases where a user is entering an email
	$(document).on('change', '.future-date', function(e){
		if($(this).val() != ''){
			var now = new Date();
			var entered = new Date($(this).val());
			if(entered < now){
				var reject = false;
				if($(this).hasClass('strict')) reject = true;
				// also reject if not strict but does not have the same date as today
				if(now.getMonth()+'/'+now.getDate()+'/'+now.getFullYear() !== entered.getMonth()+'/'+entered.getDate()+'/'+entered.getFullYear()) reject = true;
				
				if(reject) {
					showServerSideFadingMessage('ERROR: Only current or future dates are allowed for this field.');
					$(this).val('');
				}
			}
		}
	});

});









// set datepicker by function call (e.g. on click)
function setDatePicker(obj)
{
	// Date only
	$( ".calendar.clickactivated:not(.showtime)" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'mm/dd/yy'
	});

	var focusFieldObj = $( ".calendar.clickactivated:not(.showtime)" );
	if(typeof obj !== "undefined") focusFieldObj = $(obj);
	focusFieldObj.focus();

	// This will require including the timepicker-addon js file
	if($('.calendar.showtime').length > 0){
		// Date and time
		$('.showtime.clickactivated').datetimepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'mm/dd/yy',
			timeFormat: "hh:mm tt"
		});

		focusFieldObj = $('.showtime.clickactivated');
		if(typeof obj !== "undefined") focusFieldObj = $(obj);
		focusFieldObj.focus();
	}
}
