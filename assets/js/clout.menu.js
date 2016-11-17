// JavaScript Document

// Handle clicking the menu icons
$(function(){
	$(document).on('click', '.menu-icon', function(e){
		$('.menu-details').css('display','block');
		$('.menu-details').animate({ width: '100%', left: '0' }, 400, 'swing');
		
	});
	
	
	
	// Close the menu if the user has clicked the menu header
	$(document).on('click', '.menu-details .menu-header', function(e){
		// Only if you click this area
		var fieldOffset = $(this).offset().left + $(this).width();
		if(e.pageX > (fieldOffset - 50)){
			$('.menu-details').animate({ width: '0', left: '-100%' }, 400, 'swing');
		}
	});
	
	
	
	// Toggle the sub-menu
	$(document).on('click', '.menu-details .menu-header > div', function(e){
		var toggleMenuDiv = $(this).parent('.menu-header').data('refdiv');
		toggleLayersOnCondition(toggleMenuDiv, toggleMenuDiv);
	});
	
	
	
	
	// Close menu if user clicks outside and it allows closing
	$(document).on('mouseup', 'body', function (e){
    	if($(".menu-details").length > 0 && $(".menu-details").is(':visible'))
		{
			var calloutContainer = $(".menu-details");
			var calloutContainerChildren = calloutContainer.find('table, div');
		
			//If the target of the click isn't the container... nor a descendant of the container, hide it
   			if (!calloutContainer.is(e.target) && calloutContainer.has(e.target).length === 0 && !calloutContainerChildren.is(e.target) && calloutContainerChildren.has(e.target).length === 0) 
    		{
       	 		$('.menu-details').animate({ width: '0', left: '-100%' }, 400, 'swing');
    		}
		}
	});
	
	
	
	// Click where the menu-icon
	$(document).on('click', '.title.link, .menu-item, .menu-user-item', function(e){
		if(typeof $(this).data('url') !== 'undefined'){
			document.location.href=getBaseURL()+$(this).data('url');
		}
	});
	
	$(document).on('click', '.navbar > .logo', function(e){
		if($(this).data('url')) document.location.href = getBaseURL()+$(this).data('url');
		else document.location.href=getBaseURL();
	});
});





