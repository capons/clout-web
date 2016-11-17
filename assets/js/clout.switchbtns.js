// JavaScript Document
//Show the div when it is clicked
$(document).ready(function ($) {
	$(".switchcontainer").click(function (e) {
		var thisId = $(this).attr('id');
		
		//If the OFF button is hidden
		if($(this).children('.offbtn').css('display') == 'none')
		{
			$(this).children('.onbtn').hide();
			$(this).children('.offbtn').show('slide', {direction: 'left'}, 100);
			//Record the value of the button
			$('#'+thisId+'_value').val('OFF');
		}
		//If the ON button is hidden
		else
		{
			$(this).children('.offbtn').hide();
			$(this).children('.onbtn').show('slide', {direction: 'right'}, 100);
			//Record the value of the button
			$('#'+thisId+'_value').val('ON');
		}
		
	});
});