



/* Generically handles image pupup 	
 * Usage: 							
 * 	<td class='shadowbox closable' data-url='"+.base_url()+"user/facebookPhotos' style='background: url(".$icon_url.") no-repeat center top;'>&nbsp;</td>
 */
(function($) {
		/* Handles button click to scroll left */
		$(document).on('touchstart click', '.view-btn-left', function() {
			var activeDiv = $('.view-scrollable-images').find('.active');
			
			if(parseInt(activeDiv.data('index')) > 0) {
				/* The active div is not yet at the beginning so its ok to make the next left element active */
				activeDiv.prev().addClass('active');
				activeDiv.prev().removeClass('inactive');
				
				/* Disable the currently active div */
				activeDiv.removeClass('active');
				activeDiv.addClass('inactive');
				
				/* Enable right button after moving left */
				if($('.view-btn-right').hasClass('disable_click')) {
					$('.view-btn-right').removeClass('disable_click');
				}
			} 
			else {
				/* The active div is at the beginning */
				$('.view-btn-left').addClass('disable_click');
			}
		});
		
		
		
		
		/* Handles button click to scroll right */
		$(document).on('touchstart click', '.view-btn-right', function() {
			var activeDiv = $('.view-scrollable-images').find('.active');
			console.log('activeDiv.next().length ' + activeDiv.next().length);
			
			/* if active div is less than the last image index allow button click */
			if(parseInt(activeDiv.data('index')) + 1 < $('.scrollable-image').length) {
				/* The active div is not yet at the end so its ok to make the next right element active */
				activeDiv.next().addClass('active');
				activeDiv.next().removeClass('inactive');
				
				/* Disable the currently active div */
				activeDiv.removeClass('active');
				activeDiv.addClass('inactive');
				
				/* Enable left button after moving right */
				if($('.view-btn-left').hasClass('disable_click')) {
					$('.view-btn-left').removeClass('disable_click');
				}
			}
			else {
				/* The active div is at the end */
				$('.view-btn-right').addClass('disable_click');
			}
		});




		/* on close of popup image */
		$('body').on('touchstart click', '.expandable_closer', function() {
			$('.expandable_closer').parent().remove();
		});

})(jQuery);


function onScrollableImageLoad() {
		var bufferTop = 20;
		var bufferLeft = 20;

		/* 
		 * on click of the mini image, get the container's top position and left
		 * position and calculate the top and left position of the dynamic div with
		 * the big background image
		 */
		var containerWidth = $('.view-scrollable-image-container').width();
		var containerHeight = $('.view-scrollable-image-container').height();
		
	
		/* size the popup to 80 % of the container's width and height */
		var popupWidth = (parseInt(containerWidth) * 80) / 100;
		var popupHeight = (parseInt(containerHeight) * 80) / 100;
		
		var buttonWidth = 50;
		var imageWidth = (parseInt(popupWidth) * 60) / 100;
		
		//calc(120px * 0.7)
		
		updateDimension('.view-scrollable-images', bufferTop + 'px', bufferLeft + 'px', popupWidth + 'px', popupHeight + 'px');
		
		updateDimension('.view-btn-left', bufferTop + 'px', bufferLeft + 'px', buttonWidth + 'px', popupHeight + 'px');
		updateDimension('.scrollable-image', bufferTop + 'px', (buttonWidth + bufferLeft) + 'px', imageWidth + 'px', popupHeight + 'px');
		updateDimension('.view-btn-right', bufferTop + 'px', (buttonWidth + imageWidth + bufferLeft) + 'px', buttonWidth + 'px', popupHeight + 'px');

		$('.scrollable-image').css('background-size', $('.view-scrollable-images').data('size'));
		$('.view-btn-left').addClass('disable_click');	
}


function updateDimension(className, top, left, width, height) {
		$(className).css('top', top);
		$(className).css('left', left);
		$(className).css('width', width);
		$(className).css('height', height);
}

