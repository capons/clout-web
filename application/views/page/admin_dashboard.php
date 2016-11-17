<?php $this->load->view('addons/head', array('title'=>$pageTitle, 'description'=>(!empty($pageDescription) ? $pageDescription : '')));?>
<body class="have-side-menu">

	<!-- intro section -->
	<section id="welcome" class="intro">
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
					<a href="<?php echo base_url();?>account/sign_up" class="btn__green"><?php echo $signUpBtnLabel?></a>
				</div>
			</div>
		</div>
	</section>

   <div class="navbar navbar-fixed-top side-menu">
  	<div class="menu-icon">&nbsp;</div>
    <?php
    # Vertical menu content
    $this->load->view('addons/vertical_menu',
    	array('__page'=>'affiliates', '__isnew'=>'true', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel,  'news'=>$menuNewsLable, 'banks'=>$menuBanksLabel, 'investor'=>$menuInvestorLabel, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); ?>
  </div> 

  <?php $this->load->view('addons/footer_public'); ?>

	<?php echo minify_js('page__admin_dashboard', array('jquery.min.js', 'scrollr.min.js', 'clout.menu.js', 'app.js'));?>

</body>
</html>
