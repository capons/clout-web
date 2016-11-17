<?php $this->load->view('addons/head', array('title'=>$pageTitle, 'description'=>(!empty($pageDescription) ? $pageDescription : '')));?>
<body>

	<!-- intro section -->
	<section id="welcome" class="intro" data-scroll-to="#howItWorks">
		<div class="intro__bg">
      <?php # Header content
      $this->load->view('addons/header_public_new', array('signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
      ?>

			<div class="wrapper fullheight">
				<div class="logo">
					<h1><span>Clout</span></h1>
				</div>
				<div class="intro__text">
					<div class="intro__subtitle"><?php echo $topSlideAboveTitle?></div>
					<h2 class="intro__title"><?php echo $topSlideTitle?></h2>
					<div class="intro__subtitle"><?php echo $topSlideUnderTitle?></div>
					<a href="<?php echo base_url();?>account/sign_up" class="btn__green"><?php echo $topSlideBtn?></a>
					<!-- <a target="_blank" href="https://www.youtube.com/channel/UC9kZvg4jHgDo4hoU3angg6g" class="link__green"><img src="/assets/images/icon-video.png" />Watch video</a> -->
				</div>

				<div class="intro__partners">
					<div class="intro__partner-item">
						<img src="<?php echo base_url();?>assets/images/logo-ae.png" alt="" />
						<img src="<?php echo base_url();?>assets/images/logo-visa.png" alt="" />
						<img src="<?php echo base_url();?>assets/images/logo-mastercard.png" alt="" />
						<img src="<?php echo base_url();?>assets/images/logo-stm.png" alt="" />
						<img src="<?php echo base_url();?>assets/images/logo-discover.png" alt="" />
					</div>
					<div class="intro__partners-text"><?php echo $topSlideFooter?></div>
				</div>
			</div>
		</div>

	</section>

	<!-- how it works section-->
	<section id="howItWorks" data-scroll-to-off="#scrollTargetMoreCash" class="features fullheight">

		<h3 class="block-title"><?php echo $hiwSlideTitle?></h3>
		<div class="block-subtitle"><?php echo $hiwSlideUnderTitle?></div>
		<div class="feature__list">
			<div class="feature__wrapper">
				<!-- item  -->
				<div class="feature__item">
					<div class="feature__image"><img src="<?php echo base_url();?>assets/images/feature-item1.png" /></div>
					<div class="feature__title"><?php echo $hiwSlideC1Title?></div>
					<div class="feature__text"><?php echo $hiwSlideC1Txt?></div>
				</div>
				<!-- item  -->
				<div class="feature__item t-delay-300">
					<!-- <div class="feature__image-border" data-bottom-top="transform: rotate(0deg);" data-top-bottom="transform: rotate(180deg);"></div> -->
					<div class="feature__image"><img src="<?php echo base_url();?>assets/images/feature-item2.png" /></div>
					<div class="feature__title"><?php echo $hiwSlideC2Title?></div>
					<div class="feature__text"><?php echo $hiwSlideC2Txt?></div>
				</div>
				<!-- item  -->
				<div class="feature__item t-delay-600">
					<div class="feature__image t-delay-600"><img src="<?php echo base_url();?>assets/images/feature-item3.png" /></div>
					<div class="feature__title"><?php echo $hiwSlideC3Title?></div>
					<div class="feature__text"><?php echo $hiwSlideC3Txt?></div>
				</div>
				<!-- item  -->
				<div class="feature__item t-delay-900">
					<div class="feature__image"><img src="<?php echo base_url();?>assets/images/feature-item4.png" /></div>
					<div class="feature__title"><?php echo $hiwSlideC4Title?></div>
					<div class="feature__text"><?php echo $hiwSlideC4Txt?></div>
				</div>
			</div>
		</div>
	</section>


	<!-- rewards programm section  -->
	<section id="scrollTargetMoreCash" data-scroll-to-off="next" class="rewards-programm textimage" >
		<div class="wrapper">
			<h3 class="block__title" data-bottom-top="transform: translate(0%, -200%); opacity:0;" data-center-top="transform: translate(0%, 0%); opacity:1;" data-anchor-target="#scrollTargetMoreCash"><?php echo $moreSlideTitle?></h3>
			<div class="clearfix">
				<div class="textimage__column-text table">
					<div class="table-row">
						<div class="table-cell">
							<div class="textimage__title" data-center-top="transform: translate(0%, -200%); opacity:0;" data-top="transform: translate(0%, 0%); opacity:1;"  data-anchor-target="#scrollTargetMoreCash"><?php echo $moreSlideTitle2?></div>
							<div class="textimage__text"  data-anchor-target="#scrollTargetMoreCash"><?php echo $moreSlideTxt?></div>
						</div>
					</div>
				</div>
				<div class="textimage__column-image" data-anchor-target="#scrollTargetMoreCash">
					<img src="<?php echo base_url();?>assets/images/image_more-cash-back.jpg" alt="more cash back">
				</div>
			</div>
		</div>
	</section>

	<!-- we believe section  -->
	<section id="scrollTargetBelieve" data-scroll-to-off="#scrollTargetFreeStuff" class="believe" >
		<div class="wrapper">
			<div class="believe__text1"><?php echo $believeSlideTitle?></div>
			<div class="believe__text2"><?php echo $believeSlideTitle2?></div>
		</div>
	</section>

	<!-- free stuff section  -->
	<section id="scrollTargetFreeStuff" data-scroll-to-off="next" class="free-stuff textimage textimage_inverted" >
		<div class="wrapper">
			<div class="clearfix">
				<div class="textimage__column-text table">
					<div class="table-row">
						<div class="table-cell">
							<div class="textimage__title" data-bottom-top="transform: translate(0%, -200%); opacity:0;" data-center-top="transform: translate(0%, 0%); opacity:1;" data-anchor-target="#scrollTargetFreeStuff"><?php echo $freeSlideTitle?></div>
							<div class="textimage__text"  data-anchor-target="#scrollTargetFreeStuff"><?php echo $freeSlideUnderTitle?></div>
						</div>
					</div>
				</div>
				<div class="textimage__column-image" data-anchor-target="#scrollTargetFreeStuff">
					<img src="<?php echo base_url();?>assets/images/image_free-stuff.jpg" alt="free stuff">
				</div>
			</div>
			<div class="block-button">
				<div class="block-button__link"><?php echo $freeSlideUnderTxt?></div>
			</div>

		</div>
	</section>

	<!-- VIP Invitations section  -->
	<section id="sectionVipInvitations" data-scroll-to-off="next" class="get-invited textimage" >
		<div class="wrapper">
			<div class="clearfix">
				<div class="textimage__column-text table">
					<div class="table-row">
						<div class="table-cell">
							<div class="textimage__title" data-bottom-top="transform: translate(0px, -200%); opacity:0;" data-center-top="transform: translate(0px, 0%); opacity:1;" data-anchor-target="#sectionVipInvitations"><?php echo $privilegedSlideTitle?></div>
							<div class="textimage__text"  data-anchor-target="#sectionVipInvitations"><?php echo $privilegedSlideUnderTitle?></div>
						</div>
					</div>
				</div>
				<div class="textimage__column-image"  data-anchor-target="#sectionVipInvitations">
					<img src="<?php echo base_url();?>assets/images/image_get-invited.jpg" alt="VIP Invitations">
				</div>
			</div>
			<div class="block-button">
				<div class="block-button__link"><?php echo $privilegedSlideTxt?></div>
			</div>

		</div>
	</section>

	<!-- vip automated section  -->
	<section id="sectionVipAutomated" data-scroll-to-off="next" class="vip-automated textimage textimage_inverted"  >
		<div class="wrapper">
			<h3 class="block__title" data-bottom-top="transform: translate(0px, -200%); opacity:0;" data-center-top="transform: translate(0px, 0%); opacity:1;" data-anchor-target="#sectionVipAutomated"><?php echo $vipSlideTitle?></h3>
			<div class="clearfix">
				<div class="textimage__column-image">
					<img src="<?php echo base_url();?>assets/images/image_vip.jpg" alt="vip automated">
				</div>
				<div class="textimage__column-text table">
					<div class="table-row">
						<div class="table-cell">
							<div class="textimage__text textimage_text-vip">
								<p class="lighter"><?php echo $vipSlideP1?></p>
								<p><?php echo $vipSlideP2?> </p>
								<p><?php echo $vipSlideP3?></p>
								<a href="<?php echo base_url();?>account/sign_up" class="btn__green"><?php echo $vipSlideButton?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- life of freedom section -->
	<section id="scrollTargetFreedom" data-scroll-to-off="next" class="freedom fullheight" >
		<!-- <img src="/assets/images/bg-freedom.jpg" alt="start your life of freedom today" > -->
		<div class="freedom__info clearfix">
			<div class="wrapper">
				<div class="freedom__text"><?php echo $jetSlideTxt?></div>
				<a href="<?php echo base_url();?>account/sign_up" class="btn__green" data-50-top="transform: scale(.2); opacity:0;" data-top="transform: scale(1); opacity:1;" data-anchor-target="#scrollTargetFreedom"><?php echo $jetSlideButton?></a>
			</div>
		</div>
	</section>

	<!-- 50m merchants section -->
	<section id="scrollTarget50m" data-scroll-to-off="next" class="merchants fullheight" >
		<div class="wrapper">
			<div class="table">
				<div class="table-row">
					<div class="table-cell">
						<div class="intro__title" data-center-top="transform: translate(0%, -200%); opacity:0;" data-top="transform: translate(0%, 0%); opacity:1;" data-anchor-target="#scrollTarget50m"><?php echo $m50SlideTitle?></div>
						<div class="merchants__subtitle"  data-anchor-target="#scrollTarget50m"><?php echo $m50SlideTxt?></div>
						<div  data-anchor-target="#scrollTarget50m"><a href="<?php echo base_url();?>account/sign_up" class="btn__green" ><?php echo $m50SlideButton?></a></div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- map section -->
	<section class="map fullheight" >
		<!-- search bar -->
		<div class="map__searchbar">
			<div class="wrapper celarfix">
				<div class="table">
					<div class="table-cell">
						<div class="map__search-text"><?php echo $mapSlideAboveTxt?></div>
						<div class="map__search-icon">
							<img src="<?php echo base_url();?>assets/images/icon-search.png" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- map -->
		<div class="map__holder">

			<div class="map">

				<div class="map__filter">
					<ul class="map__filter-list">
						<li class="map__filter-item">
							<input id="checkbox-1" class="checkbox-custom" name="map-point" type="radio" value="restaurants" checked>
							<label for="checkbox-1" class="checkbox-custom-label"><?php echo $mapSlideRestaurants?></label>
						</li>
						<li class="map__filter-item">
							<input id="checkbox-2" class="checkbox-custom" name="map-point" type="radio" value="shopping">
					    <label for="checkbox-2" class="checkbox-custom-label"><?php echo $mapSlideShopping?></label>
						</li>
						<li class="map__filter-item">
							<input id="checkbox-3" class="checkbox-custom" name="map-point" type="radio" value="grocery">
							<label for="checkbox-3" class="checkbox-custom-label"><?php echo $mapSlideGrocery?></label>
						</li>
						<li class="map__filter-item">
							<input id="checkbox-4" class="checkbox-custom" name="map-point" type="radio" value="hotels">
					    <label for="checkbox-4" class="checkbox-custom-label"><?php echo $mapSlideHotels?></label>
						</li>
					</ul>
					<div class="map__filter-more">
						<a class="link__green" href="https://www.clout.com/account/sign_up"><?php echo $mapSlideLink?></a>
					</div>
				</div>

				<!-- marker  -->
				<div id="restaurantsMarker" class="map__marker" style="top: 50%; left: 50%;">
					<div class="map__dialog">
						<div class="table"><div class="table-cell">
							<div class="map__dialog-title"><?php echo $mapSlideRestaurantsTitle?></div>
							<div class="map__dialog-text">
								<?php echo $mapSlideRestaurantsTxt?>
							</div>
						</div></div>
						<div class="map__dialog-score">
							<div class="map__dialog-pts">716</div>
							<div class="map__dialog-label"><?php echo $mapSlideScore?></div>
						</div>
					</div>
				</div>
				<!-- marker  -->
				<div id="shoppingMarker" class="map__marker" style="top: 40%; left: 60%; display:none;">
					<div class="map__dialog">
						<div class="table"><div class="table-cell">
							<div class="map__dialog-title"><?php echo $mapSlideShoppingTitle?></div>
							<div class="map__dialog-text">
							<?php echo $mapSlideShoppingTxt?>
							</div>
						</div></div>
						<div class="map__dialog-score">
							<div class="map__dialog-pts">922</div>
							<div class="map__dialog-label"><?php echo $mapSlideScore?></div>
						</div>
					</div>
				</div>
				<!-- marker  -->
				<div id="groceryMarker" class="map__marker" style="top: 20%; left: 50%; display:none;">
					<div class="map__dialog">
						<div class="table"><div class="table-cell">
							<div class="map__dialog-title"><?php echo $mapSlideGroceryTitle?></div>
							<div class="map__dialog-text">
								 <?php echo $mapSlideGroceryTxt?>
							</div>
						</div></div>
						<div class="map__dialog-score">
							<div class="map__dialog-pts">650</div>
							<div class="map__dialog-label"><?php echo $mapSlideScore?></div>
						</div>
					</div>
				</div>
				<!-- marker  -->
				<div id="hotelsMarker" class="map__marker" style="top: 30%; left: 35%; display:none;">
					<div class="map__dialog">
						<div class="table"><div class="table-cell">
							<div class="map__dialog-title"><?php echo $mapSlideHotelsTitle?></div>
							<div class="map__dialog-text">
								 <?php echo $mapSlideHotelsTxt?>
							</div>
						</div></div>
						<div class="map__dialog-score">
							<div class="map__dialog-pts">701</div>
							<div class="map__dialog-label"><?php echo $mapSlideScore?></div>
						</div>
					</div>
				</div>

			</div>



		</div>
	</section>

	<!-- list of banks section-->
	<section class="banks" >
		<div class="wrapper">
			<div class="table">
				<div class="table-cell">
					<h3 class="block__title"><?php echo $mapSlideBottomTitle?></h3>
					<h4 class="block__subtitle"><?php echo $mapSlideBottomTxt?></h4>
					<!-- <a href="#" class="link__green">Complete list of available banks</a> -->
				</div>
			</div>
		</div>
	</section>

	<!-- video section -->
	<section class="video " >
		<div class="wrapper">
			<h3 class="block__title"><?php echo $videoSlideTitle?></h3>
			<!-- <div class="video__text">Clout Card members receive an annual air travel credit toward flight-related purchases including airline tickets, baggage fees, upgrades and more. For your convenience, Clout automatically applies the credit to your account.</div> -->
		</div>
		<div class="video__holder">
			<div class="video__player">
				<iframe width="100%" height="100%" src="https://www.youtube.com/embed/or2BsEGD9I0?list=PL4BKP8nkyTP7g85jlOFqWeC4GTRvS5i4o" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="video__bags-bh"></div>
		</div>

	</section>

	<!-- footer partners section -->
	<!-- <section class="partners">
		<img class="logo-nyt" src="/assets/images/logo-ny-times.png" alt="">
		<img class="logo-ut" src="/assets/images/logo-usa-today.png" alt="">
		<img class="logo-bi" src="/assets/images/logo-business-insider.png" alt="">
		<img class="logo-mash" src="/assets/images/logo-mashable.png" alt="">
		<img class="logo-tcr" src="/assets/images/logo-tech-crunch.png" alt="">
	</section> -->

	<!-- table of contents section -->

	<section class="contents" >
		<div class="wrapper clearfix">
			<!-- <div class="contents__item">
				<div class="contents__title"><a href="#">vip program</a></div>
				<div class="contents__link">How we treat our top VIP’s</div>
			</div> -->
			<div class="contents__item">
				<div class="contents__title"><a href="<?php echo base_url();?>page/businesses"><?php echo $linkSlideBusinessesTitle?></a></div>
				<div class="contents__link"><?php echo $linkSlideBusinessesTxt?></div>
			</div>

			<div class="contents__item">
				<div class="contents__title"><a href="<?php echo base_url();?>page/banks"><?php echo $linkSlideBanksTitle?></a></div>
				<div class="contents__link"><?php echo $linkSlideBanksTxt?></div>
			</div>

			<div class="contents__item">
				<div class="contents__title"><a href="<?php echo base_url();?>page/affiliates"><?php echo $linkSlideAffiliatesTitle?></a></div>
				<div class="contents__link"><?php echo $linkSlideAffiliatesTxt?></div>
			</div>

			<div class="contents__item">
				<div class="contents__title"><a href="<?php echo base_url();?>page/investor"><?php echo $linkSlideInvestorTitle?></a></div>
				<div class="contents__link"><?php echo $linkSlideInvestorTxt?></div>
			</div>

		</div>
	</section>


	<footer class="footer">
		<div class="wrapper">
			<div class="clearfix">
				<a href="#" class="logo js--soft-scroll" data-target="#welcome"></a>

				<nav class="nav">
					<a href="https://www.clout.com/page/contact " class="nav__item"><?php echo $footerMenuContacts?></a>
					<a href="https://www.clout.com/page/privacy" class="nav__item"><?php echo $footerMenuPrivacy?></a>
					<a href="https://www.clout.com/page/terms" class="nav__item"><?php echo $footerMenuTerms?></a>
					<a href="https://www.clout.com/account/login" class="nav__item"><?php echo $footerMenuLogin?></a>
					<a href="https://www.clout.com/account/sign_up" class="nav__item"><?php echo $footerMenuSignup?></a>
				</nav>
			</div>


			<div class="footer__socials">
				<a href="https://www.facebook.com/Clout" target="_blank" class="socials_item socials_item-fb">
					<svg preserveAspectRatio="none" class="soc-icon" viewBox="0 0 32 32">
						<use xlink:href="#iconFb"></use>
					</svg>
				</a>
				<a href="https://www.linkedin.com/company/clout-com" target="_blank" class="socials_item socials_item-ln">
					<svg preserveAspectRatio="none" class="soc-icon" viewBox="0 0 430.117 430.117">
						<use xlink:href="#iconLn"></use>
					</svg>
				</a>
				<a href="https://www.youtube.com/channel/UC9kZvg4jHgDo4hoU3angg6g" target="_blank" class="socials_item socials_item-yt">
					<svg preserveAspectRatio="none" class="soc-icon" viewBox="0 0 32 32">
						<use xlink:href="#iconYt"></use>
					</svg>
				</a>
			</div>

			<div class="footer__copyrights">
				<?php echo $footerCopyright?>
			</div>
		</div>
	</footer>

	<!-- facebook -->
	<svg height="0" width="0" style="position:absolute;margin-left: -100%; display: none;">
		<path id="iconFb" d="M20.146,16.506h-2.713c0,4.031,0,8.994,0,8.994h-4.021c0,0,0-4.914,0-8.994h-1.912v-3.177h1.912v-2.056 c0-1.472,0.752-3.773,4.058-3.773l2.978,0.011v3.085c0,0-1.811,0-2.161,0c-0.353,0-0.854,0.164-0.854,0.865v1.868h3.065 L20.146,16.506z"/>
	</svg>

	<!-- linked -->
	<svg height="0" width="0" style="position:absolute;margin-left: -100%; display: none;">
		<path id="iconLn" d="M430.117,261.543V420.56h-92.188V272.193c0-37.271-13.334-62.707-46.703-62.707   c-25.473,0-40.632,17.142-47.301,33.724c-2.432,5.928-3.058,14.179-3.058,22.477V420.56h-92.219c0,0,1.242-251.285,0-277.32h92.21   v39.309c-0.187,0.294-0.43,0.611-0.606,0.896h0.606v-0.896c12.251-18.869,34.13-45.824,83.102-45.824   C384.633,136.724,430.117,176.361,430.117,261.543z M52.183,9.558C20.635,9.558,0,30.251,0,57.463   c0,26.619,20.038,47.94,50.959,47.94h0.616c32.159,0,52.159-21.317,52.159-47.94C103.128,30.251,83.734,9.558,52.183,9.558z    M5.477,420.56h92.184v-277.32H5.477V420.56z"/>
	</svg>

	<!-- youtube -->
	<svg height="0" width="0" style="position:absolute;margin-left: -100%; display: none;">
		<path id="iconYt" d="M8.791,22.401c-1.816-0.37-2.281-1.623-2.292-6.184c-0.008-3.221,0.129-4.316,0.674-5.373 c0.422-0.819,0.931-1.078,2.411-1.23c1.437-0.147,9.074-0.155,12.11-0.012c4.232,0.261,3.751,2.194,3.799,6.028 c0.049,3.976-0.062,4.84-0.747,5.854c-0.679,1.004-0.419,0.972-8.288,1.01C12.461,22.515,9.147,22.475,8.791,22.401L8.791,22.401z M19.098,15.968c-1.775-1.15-3.672-2.369-4.633-2.947c0.042,1.611,0.007,4.542,0.032,5.985 C15.904,18.158,18.047,16.737,19.098,15.968L19.098,15.968z"/>
	</svg>
<script type="text/javascript" src="https://www.clout.com/assets/js/clout.googleanalytics.js"></script>
	<?php echo minify_js('page__home', array('jquery.min.js', 'scrollr.min.js', 'app.js'));?>
</body>
</html>
