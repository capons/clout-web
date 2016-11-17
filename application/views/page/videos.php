<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": ".$pageTitle;?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.search.css" type="text/css" media="screen">
    <style type="text/css">
		#page1 {
			position: relative;
		}
		.container {
			width: 100%;
		}
		.row {
			width: 100%;
			margin: auto;
		}
		.col-sm-6 {
			margin: 15px 0px;
		}
		.videoWrapper {
			position: relative;
			padding-bottom: 56.25%;
			padding-top: 25px;
			height:0;
		}
		
		.videoWrapper iframe {
			position: absolute;
			top:0;
			left:0;
			height:100%;
			width:100%;
			border:none;
		}
		.absolute_center {
			margin: auto;
			top: 0;
			bottom: 0;
			right: 0;
			left: 0;	
		}
	</style>
</head>

<body>

<!-- First Page -->
<div id="page1" class="fill">
	
	<div class="navbar navbar-fixed-top">
	<?php 
	# Vertical menu content
	$this->load->view('addons/vertical_menu', 
		array('__page'=>'videos', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel,  'news'=>$menuNewsLable, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); 
		
	# Header content
	$this->load->view('addons/header_public', array('__page'=>'videos', 'signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
	?>
	</div>
	
	
	<div class="center-block menu-gap" style="width:100%;">
		<div class="one-column-table absolute_center container">
			<div class="row">
				<div class="col-sm-6">
					<div class="videoWrapper table-highlight-border">
						<iframe width="320" height="180" class="absolute_center"
							src="https://www.youtube.com/embed/8Dmnrf-v9AA?rel=0&amp;autoplay=0&amp;modestbranding=1&amp;showinfo=0&amp;autohide=1&version=3" 
							title="What CLOUT used to be." allowfullscreen>
						</iframe>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="videoWrapper table-highlight-border">
						<iframe width="320" height="180" class="absolute_center"
							src="https://www.youtube.com/embed/bx4ehxmWYX4?rel=0&amp;autoplay=0&amp;modestbranding=1&amp;showinfo=0&amp;autohide=1&version=3" 
							title="Everyone's a VIP in something!"  allowfullscreen>
						</iframe>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="videoWrapper table-highlight-border">
						<iframe width="320" height="180" class="absolute_center"
							src="https://www.youtube.com/embed/tY5lvTae3hs?rel=0&amp;autoplay=0&amp;modestbranding=1&amp;showinfo=0&amp;autohide=1&version=3" 
							title="Upgrade your income!" allowfullscreen>
						</iframe>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="videoWrapper table-highlight-border">
						<iframe width="320" height="180" class="absolute_center"
							src="https://www.youtube.com/embed/q4jeURXdx_k?rel=0&amp;autoplay=0&amp;modestbranding=1&amp;showinfo=0&amp;autohide=1&version=3" 
							title="Reach customers for FREE!" allowfullscreen>
						</iframe>
					</div>
				</div>
			
				<div class="col-sm-6">
					<div class="videoWrapper table-highlight-border">
						<iframe width="320" height="180" class="absolute_center" 
							src="https://www.youtube.com/embed/or2BsEGD9I0?rel=0&amp;autoplay=0&amp;modestbranding=1&amp;showinfo=0&amp;autohide=1&version=3" 
							title="Add cashback to any card!" allowfullscreen>
						</iframe>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>




<script type="text/javascript" src="https://www.clout.com/assets/js/clout.googleanalytics.js"></script>
<?php echo minify_js('page__videos', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js', 'clout.search.js'));?>

</body>
</html>