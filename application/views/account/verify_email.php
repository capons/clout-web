<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": Verify Email";?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">
    <style>
		#page1 {
			position: relative;
		}
	</style>
</head>

<body>
<script type='text/javascript' src='<?php echo base_url();?>/assets/js/clout.fblogin.js'></script>



<!-- First Page -->
<div id="page1" class="fill menu-gap">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', 
	array('__page'=>'signup', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); 
	
# Header content
$this->load->view('addons/header_public', array('__page'=>'signup', 'signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
?>
</div>




<div class="center-block" style="width:100%;">
<div class="one-column-table">

<form id='verifyemailform' action='<?php echo base_url().'account/verify_email';?>'  method='post'>
<table>
<tr><td class="h2 dark-grey"><?php echo $boxTitle;?></td></tr>
<tr><td><?php if(!empty($msg)) echo format_notice($this, $msg);?></td></tr>

<tr><td style="padding-bottom:0px;"><button type="submit" id="resendlinkbtn" name="resendlinkbtn" class="btn green" style="width:100%;"><?php echo $resendLinkBtnLabel;?></button>
<input type='hidden' name='emailaddress' id='emailaddress' value='<?php echo $this->native_session->get('__email_address');?>'>
<input type='hidden' name='verifyemailform_required' id='verifyemailform_required' value='emailaddress'>
<input type='hidden' name='verifyemailform_displaylayer' id='verifyemailform_displaylayer' value='verify_form_area'></td></tr>

</table>
</form>


</div>
</div>

</div>

<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>





<?php echo minify_js('account__verify_email', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js'));?>
</body>
</html>