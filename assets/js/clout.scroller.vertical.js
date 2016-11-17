// JavaScript Document
$(function(){
	
	// How to handle the automatically scrolling div
	if($('#scrolltarget').length && $('#scrolltarget').parents('.continous-scroll').first().length){
		// Autmatically loads on scroll
		if($('#scrolltarget').hasClass('load-on-scroll')){
			$( window ).scroll(function() {
				if(isScrolledIntoView($('#scrolltarget'))){
					showWaitDiv('start');
					loadNextList();
					showWaitDiv('end');
				}
			}); 
		}
		
		// Requires clicking to load next list
		if($('#scrolltarget').hasClass('load-on-click')){ 
			$(document).on('click', '#scrolltarget', function(){ 
				$('#scrolltarget').parents('.continous-scroll').first().append("<img src='"+getBaseURL()+"assets/images/loading.gif' class='loading-image'>");
				
				loadNextList(); 
			}); 
		}
	}  
});




// Load the next list 
function loadNextList()
{
				//First collect the basic list information
				var containerDiv = $('#scrolltarget').parents('.continous-scroll').first();
				var url = containerDiv.data('url')? containerDiv.data('url'): (containerDiv.data('type')? getBaseURL()+'lists/load/t/'+containerDiv.data('type'): '');
				
				var page = containerDiv.data('page')? containerDiv.data('page'): 1;
				var noPerPage = containerDiv.data('noperpage')? containerDiv.data('noperpage'): 10;
				// Add these to the URL
				url += (url != ''? '/p/'+(page+1)+'/n/'+noPerPage: '');
				
				
				// Also collect any other information in the other fields if provided
				if(containerDiv.data('fields')){
					var fields = containerDiv.data('fields').split('|');
					$.each(fields, function(index, value){
						var fieldKeyParts = value.split('=');
						url += ($('#'+fieldKeyParts[0]).length && $('#'+fieldKeyParts[0]).val() != ''? '/'+fieldKeyParts[1]+'/'+replaceBadChars($('#'+fieldKeyParts[0]).val()): '');
					});
				}
				
				//remove the row if it is made for just this button as it will be recreated on next load
				if($('#scrolltarget').parents('td').first().hasClass('load-next-row')){
					$('#scrolltarget').parents('tr').first().remove();
				}
				else $('#scrolltarget').remove();
				
				
				// Load the next data
				$.when( $.ajax(url) ).then(function( data, textStatus, jqXHR ) {
					var containerId = containerDiv.attr('id');
					// Remove loading image if present
					if($('.loading-image').length) $('.loading-image').remove();
					
					if($('#'+containerId+' > table:not(.msg)').length) {
						containerDiv.children('table').first().find('tbody').first().append(data);
					} else {
						containerDiv.append(data);
						
						//Update the item width if store items have been loaded
						if($('.store-item').length){
							var width = containerDiv.find('.store-item').first().width();
							containerDiv.find('.store-item').each(function(){
								$(this).css('max-width', width+'px');
							});
							
							// Check if the order by has been selected already
							if($('#sort__searchsortoptions__hidden').length){
								var orderBy = $('#sort__searchsortoptions__hidden').val().toLowerCase();
								reorderStoreItems(orderBy);
							}
						}
					}
					
					// Reposition the msg table
					if(containerDiv.find('.msg').length > 0) { 
						var msg = containerDiv.find('.msg').first();
						var msgHtml = msg.get(0).outerHTML;
						msg.remove();
						containerDiv.append(msgHtml);
					}
					
					
					//Increment to load the next page
					containerDiv.data('page', (page+1));
				});
}






// Check if an element has scrolled into view
function isScrolledIntoView(elem)
{
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();
    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();
    return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom) && (elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}


