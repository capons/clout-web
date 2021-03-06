<?php $this->load->view('addons/head', array('title'=>$pageTitle, 'description'=>(!empty($pageDescription) ? $pageDescription : '')));?>
<body class="have-side-menu">

	<!-- intro section -->
	<section id="welcome" class="intro" style="background-image: url('<?php echo base_url();?>assets/images/landing/banks.jpg')">
		<div class="">
      <?php # Header content
      $this->load->view('addons/header_public_new', array('signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
      ?>

			<div class="wrapper fullheight">
				<div class="logo" data-url="/">
					<h1><span>Clout</span></h1>
				</div>
				<div class="intro__text">
					<div class="intro__subtitle"><?php echo $page1AboveTitle?></div>
					<h2 class="intro__title"><span class="sub"><?php echo $page1Title?></span></h2>
					<div class="intro__subtitle"><?php echo $page1UnderTitle?></div>
					<a href="<?php echo base_url();?>page/contact" class="btn__green"><?php echo $requestBtnLabel?></a>
				</div>

				<div class="intro-footer">
					<div class="table">
						<div class="table-cell">
							<div class="intro-footer__text1">
								<?php echo $page1Content?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

  <div class="navbar navbar-fixed-top side-menu">
  	<div class="menu-icon">&nbsp;</div>
    <?php
    # Vertical menu content
    $this->load->view('addons/vertical_menu',
    	array('__page'=>'banks', '__isnew'=>'true', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel,  'news'=>$menuNewsLable, 'banks'=>$menuBanksLabel, 'investor'=>$menuInvestorLabel, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); ?>
  </div>

  <?php $this->load->view('addons/footer_public'); ?>

	<?php echo minify_js('page__banks', array('jquery.min.js', 'scrollr.min.js', 'clout.menu.js', 'app.js'));?>

</body>
</html>
