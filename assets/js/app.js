var scrl;
var isMobile = window.isMobile = navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i );
var config = {
	softScrollDuration: 800
}

$(document).ready(function () {

	// 100% height for
	h100PercentBlock(true);
	$(window).on('resize', h100PercentBlock );

	// soft link
	$('.js--soft-scroll').on('click', function (e) {
		e.preventDefault();
		var target = $(this).data('target') || $(this).attr('href') || false;
		if(target){
			softScroll(target);
		}
	});

	// Scrollr
	if (!isMobile) {
		var $sections = $('body > section');
		// setup targets
		$sections.each(function(i, el) {
			['data-emit-events', 'data-bottom-top', 'data--50-top', 'data-center-top', 'data-center-bottom'].forEach(function(item){
				if (typeof $(el).attr(item) == 'undefined') {
					$(el).attr(item, '');
				}
			});
		});

		setTimeout(function () {
			scrl = skrollr.init({
				// smoothScrolling: true,
				// smoothScrollingDuration: 100,
				forceHeight: false,
				render: function(data) {
	        //Log the current scroll position.
			  },
				keyframe: function(el, name, direction) {
					var $el = $(el);

					switch (name) {
						// scrollTo trigger
						case 'data-50Top':
							if (direction == 'down') {
								if ($el.data('scroll-to')) {
									if ($el.data('scroll-to') == 'next') {
										$targetEl = $sections.eq($el.index()+1) || false;
									}else{
										$targetEl = $($el.data('scroll-to')) || false;
									}
								}else{
									// $targetEl = $sections.eq($el.index()+1) || false;
									$targetEl = false;
								}
								if ($targetEl) {

									// if (window.softScrollDelay) {
										clearTimeout(window.softScrollDelay);
									// }
									window.softScrollDelay = setTimeout(function () {
										softScroll($targetEl);
										window.softScrollDelay = false;
									}, 250);

								}
							}
							break;
						case 'dataCenterTop':
							if (direction == 'down') {
								$el.addClass('animation-in').removeClass('animation-out');
							}else{
								$el.addClass('animation-out').removeClass('animation-in');
							}
							break;
						case 'dataCenterBottom':
							if (direction == 'up') {
								$el.addClass('animation-in').removeClass('animation-out');
							}else{
								$el.addClass('animation-out').removeClass('animation-in');
							}
							break;
						default:

					}
		    }
			});
		}, 300);
	}


	// Map filter
	$('.map__filter-list .checkbox-custom').on('click', function (e) {
		// e.preventDefault();
	});
	$('.map__filter-list .checkbox-custom').on('change', function (e) {
		// e.preventDefault();
		if ($(this).val()) {
			$('.map__marker').fadeOut(300);
			$('#' + $(this).val() + 'Marker').fadeIn(300);
		}
	});

	// Special url
	$(document).on('click', '[data-url]', function(){
	if(typeof $(this).data('url') !== 'undefined' && $(this).data('url') !== ""){
		document.location.href=getBaseURL()+$(this).data('url');
	}
});

});

function softScroll(target) {
	if (window.softScrollLock)
		return false;

	var $targetEl = false;
	var scrollTopOffset = false;
	switch (typeof target) {
		case 'number':
			scrollTopOffset = target;
			break;
		case 'string':
			$targetEl = $(target) || false;
			break;
		case 'object':
			$targetEl = target || false;
			break;
		default:
	}
	scrollTop = scrl.getScrollTop();
	if (scrollTopOffset === false)
		scrollTopOffset = $targetEl.offset().top || 0;

	if (scrollTopOffset !== false) {
		window.softScrollLock = true;
		if (scrl) {
			var winHeight = parseInt($(window).height());
			var distanceBitweenSlides = Math.abs(scrollTop - scrollTopOffset);
			var softScrollDuration = config.softScrollDuration;
			if (distanceBitweenSlides < winHeight) {
				softScrollDuration = (distanceBitweenSlides / winHeight) * softScrollDuration;
			}
			scrl.setScrollTop(scrollTop, true);
			setTimeout(function () {
				scrl.animateTo(scrollTopOffset, {
					duration: softScrollDuration,
					done: function () {
						window.softScrollLock = false;
					}
				});
			}, 75);

		}else{
			if (isMobile) {
				$('body').animate({'scrollTop': scrollTopOffset}, config.softScrollDuration, function () {
						window.softScrollLock = false;
					}
				);
			}else{
				window.softScrollLock = false;
			}
		}
	}
}

function h100PercentBlock(firstRun) {
	if (firstRun) {
		var style_el = document.createElement('style');
		style_el.id = 'fullheight';
		style_el.type = 'text/css';
		document.getElementsByTagName('head')[0].appendChild(style_el);
	}
	document.getElementById("fullheight").innerHTML = '.fullheight{height:' + window.innerHeight + 'px}';
}

//Get system base URL
function getBaseURL()
{
   var pageURL = document.location.href;
   var urlArray = pageURL.split("/");
   var BaseURL = urlArray[0]+"//"+urlArray[2]+"/";
   //Dev environments have the installation sitting in a separate folder
   if(urlArray[2] == 'localhost:8888' || urlArray[2] == '0.0.0.0')
   {
		BaseURL = BaseURL+'clout-dev/dev-v1.3.2-web/';
   }
   return BaseURL;
}
