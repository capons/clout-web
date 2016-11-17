// JavaScript Document

$(function() {
	$(document).on('click', '.view-mail-details', function(){ 
		 $('#paginationdiv__mailsearch_list').slideUp('fast');
		 $('#mail_pagination_div').hide('fast');
		 $(this).parents('tr').first().find('b').each(function(){
			 $(this).contents().unwrap();
		 });
		 
		 updateFieldLayer(getBaseURL()+'message/view_details/m/'+$(this).data('id'),'','','mail_details_div','');
	});
	
	$(document).on('click', '#backtoinbox', function(){ 
		 $('#mail_details_div').slideUp('fast');
		 $('#mail_details_div').html('');
		
		 $('#paginationdiv__mailsearch_list').slideDown('fast');
		 $('#mail_pagination_div').show('fast');
	});
	
	$(document).on('click', '#messagefilterbtn', function(){ 
		 $('#messagefilter').slideDown('fast');
		 $('#messagefilterbtn').hide('fast');
	});
	
	$(document).on('click', '#mailsearchbtn', function(){ 
		 hideLayerSet('mail_details_div<>messagefilter');
		 showLayerSet('paginationdiv__mailsearch_list<>mail_pagination_div');
		 if($(window).width() > 700) $('#messagefilterbtn').show('fast');
		 
		 // Update the pagination URL
		 url = $(this).parents('.microform').first().find('#action').val();
		 if($('#mailsearchphrase').val() != '') url += '/phrase/'+replace_bad_chars($('#mailsearchphrase').val());
		 if($('#message__messagetypes').val() != '') url += '/type/'+replace_bad_chars($('#message__messagetypes').val());
		 if($('#message__level1categories').val() != '') url += '/category/'+$('#message__level1categories').val();
		 if($('#message__cashbackrange').val() != '') url += '/cashback/'+replace_bad_chars($('#message__cashbackrange').val());
		 if($('#message__placesearch').val() != '') url += '/location/'+replace_bad_chars($('#message__placesearch').val());
		 
		 $('#paginationdiv__mailsearch_action').val(url);
	});
	
	
});