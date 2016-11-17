// JavaScript Document


// Make shadow page link show popup
$(function() {
	
	// Load the shadow box
	$(document).on('touchstart click', '.shadowpage', function(e){
		e.preventDefault();
		var parent = $(document);
		var parentWindow = $(window);
		var clickedItem = $(this);
		
		// Remove the shadow box if it is already on the page
		if($('#__shadowpage').length > 0) $('#__shadowpage').remove();
		
		// Get url of the trigger element
		var url = $(this).attr('href')? $(this).attr('href'): getBaseURL()+$(this).data('href');
		
		//If viewing on a mobile screen, open a popup instead
		if(isMobile())
		{
			openMobileWindow(url+'/isMobileWindow/Y');
		}
		
		// normal display
		else 
		{
			// Put the div and iframe to load the link href
			$("<div id='__shadowpage' style='position:absolute;display:none;min-height:200px;overflow-y:auto;overflow-x:auto;'><iframe src='"+url+"' style='width:100%;height:100vh;' marginheight='0' frameborder='0' id='__shadowpage_iframe' allowfullscreen></iframe></div>").prependTo('body');
			
			// resize and reposition the div
			$('#__shadowpage').offset({ top:0, left:0 });
			$('#__shadowpage').height(parent.height());
			$('#__shadowpage').width(parent.width());
			
			// Position iFrame
			var iFrame = $('#__shadowpage iframe');
			iFrame.offset({ top:  $(window).scrollTop(), left: 0 });
		}
		
		
		//Show the shadowbox after loading the iframe
		$('#__shadowpage').fadeIn('fast');
	});
	
	
	// Close the shadowbox
	$(document).on('touchstart click', '#__shadowpage_closer', function(e){
		if(!isMobile()){
			$('#__shadowpage', window.parent.document).fadeOut('fast');
			$('#__shadowpage', window.parent.document).remove();
		}
	});
	
	
	
	
	
	//Close the shadow box if the user resizes the window
	$(window).resize(function() { 
		if($('#__shadowpage', window.parent.document).length) $('#__shadowpage', window.parent.document).remove();
	});

	
});

	