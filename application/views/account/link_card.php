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
    <style type="text/css">
		#page1 {
			position: relative;
		}

	</style>
</head>

<body>

<!-- First Page -->
<div id="page1">

<div class="navbar navbar-fixed-top" style='display:none;'>
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', 
	array('__page'=>'signup', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); 
	
# Header content
$this->load->view('addons/header_public', array('__page'=>'signup', 'signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
?>
</div>


<table class='normal-table center-table'>
<tr><td class='h2 light-grey-bg bottom-border-grey' style="height:13vh;"><?php echo $pageHeading;?></td></tr>
<tr><td class='h3' style="height:15vh;"><?php echo str_replace('_BASE_URL_', base_url(), $pageInstruction);?></td></tr>
<tr><td class='horizontal-margin-30'>
<?php $this->load->view('account/choose_bank', array('featuredBanks'=>$featuredBanks));?>
</td></tr>
<tr><td style="vertical-align:top;"><div><a href='<?php echo base_url().'page/link_help/f/page';?>' class='shadowbox closable'><?php echo $questionLink;?></a></div>
</td></tr>
</table>


</div>

<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>




<script type="text/javascript" src="https://www.clout.com/assets/js/clout.googleanalytics.js"></script>
<?php echo minify_js('account__link_card', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js'));?>

</body>
</html>