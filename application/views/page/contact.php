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
<div id="page1" class="fill menu-gap">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', 
	array('__page'=>'contact', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel,  'news'=>$menuNewsLable, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); 
	
# Header content
$this->load->view('addons/header_public', array('__page'=>'contact', 'signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
?>
</div>


<div class="center-block" style="width:100%;">
<div class="one-column-table">
<table class='microform'>
<tr><td class="h2 dark-grey" style="text-align:left;padding-bottom:0px;"><?php echo $contactUsBoxTitle;?></td></tr>
<tr><td><div id='response_msg' style="display:block;width:100%;"><?php echo !empty($msg)? format_notice($this, $msg).'<br />': '&nbsp;';?></div><input type='text' id='yourname' name='yourname' placeholder="<?php echo $yourNameFieldLabel;?>" value='' /></td></tr>
<tr><td><input type='text' id='youremail' name='youremail' class='email' placeholder="<?php echo $yourEmailFieldLabel;?>" value='' /></td></tr>
<tr><td><input type='text' id='yourphone' name='yourphone' class='numbersonly telephone optional' placeholder="<?php echo $yourPhoneFieldLabel;?>" value='' /></td></tr>
<tr><td><textarea id='yourmessage' name='yourmessage' placeholder="<?php echo $yourMessageFieldLabel;?>" style="height:80px;"></textarea></td></tr>
<tr><td><button id="contactsubmitbtn" name="contactsubmitbtn" class="btn blue submitmicrobtn" style="width:100%;"><?php echo $contactBtnLabel;?></button>
<input type='hidden' id='action' name='action' value='<?php echo base_url().'page/contact';?>' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='response_msg' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Sending your message..' />
</td></tr>

</table>
</div>
</div>

</div>

<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>




<script type="text/javascript" src="https://www.clout.com/assets/js/clout.googleanalytics.js"></script>
<?php echo minify_js('page__contact', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js'));?>

</body>
</html>