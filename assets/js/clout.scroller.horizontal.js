// JavaScript Document

$(function(){
	// Set scroll wrapper width
	setScrollerWidth();
	$(window).resize(function() { setScrollerWidth(); });
	
	// What to do when one clicks next
	var totalDivs = $('.scroller-inner').children('div').length;
	var divsPerView = getDivsPerView();
	var currentDiv = 0;
	var btnWidth = $('.back-btn').width();
	
	// Going forward
	$(document).on('click','.next-btn.active', function(){
		if((currentDiv + divsPerView) < totalDivs) {
			currentDiv += divsPerView;
			$('.back-btn').addClass('active');
			if(currentDiv >= totalDivs) $('.next-btn').removeClass('active');
		} else {
			currentDiv = 0;
			$('.back-btn').removeClass('active');
		}
		
		var nextDivOffset = $('.scroller-inner div:nth-child('+(currentDiv == 0? 1: currentDiv)+')').offset().left - $('.scroller-inner').offset().left;
		$('.scroller-inner').offset({top: $('.scroller-inner').offset().top, left: (- nextDivOffset + btnWidth) });
	});
	
	
	// Going backward
	$(document).on('click','.back-btn.active', function(){
		if((currentDiv - divsPerView) > 0) {
			currentDiv -= divsPerView;
			$('.next-btn').addClass('active');
		} else {
			currentDiv = 0;
			$('.back-btn').removeClass('active');
		}
		
		var nextDivOffset = $('.scroller-inner div:nth-child('+(currentDiv == 0? 1: currentDiv)+')').offset().left - $('.scroller-inner').offset().left;
		$('.scroller-inner').offset({top: $('.scroller-inner').offset().top, left: (- nextDivOffset + btnWidth) });
	});
	
	
	
	// What happens if you click the inner scroller categories div
	$(document).on('click','.scroller-inner.categories > div', function(){
		var clickedDiv = $(this);
		// First clear background color on all other divs
		$('.scroller-inner').children('div').each(function(){
			$(this).css('background-color','#FFFFFF');
		});
		//Add background color to clicked div
		clickedDiv.css('background-color','#FFE79B');
		$('#search__category').val(clickedDiv.data('id'));
		$('#storesearchgo').click();
		if($('#search__level1categories').length > 0) $('#search__level1categories').val(clickedDiv.data('id'));
	});
	
	
	
	// What happens if you click the inner scroller div
	$(document).on('click','.scroller-inner.photos > div', function(){
		var clickedDiv = $(this);
		// First clear background color on all other divs
		$('.scroller-inner').children('div').each(function(){
			$(this).css('background-color','#FFFFFF');
		});
		//Add background color to clicked div
		clickedDiv.css('background-color','#FFE79B');
		
		//Then get its image URL and show that on the big screen
		var bgImage = clickedDiv.css("background-image").replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
		clickedDiv.parents('.microform').find('.large-photo-preview').first().css("background-image",  bgImage);
	});
	
	
});


// Set the width of the scroller area
function setScrollerWidth(){
	$('.scroller-outer').width($(window).width() - 60);
}

// Get the number of divs per view
function getDivsPerView(){
	var divWidth = $('.scroller-inner').children('div').first().outerWidth(true);//Get outer width with margin
	var visibleWidth = $('.scroller-outer').innerWidth();
	return Math.floor((visibleWidth-$('.back-btn').width())/divWidth);
}