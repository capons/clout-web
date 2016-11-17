<?php if(empty($msg)) $msg = get_session_msg($this);
if($this->native_session->get('__facebook_msg')){
	$msg = $this->native_session->get('__facebook_msg');
	$this->native_session->delete('__facebook_msg');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo SITE_TITLE.": ".$pageTitle;?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen" >
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">
    <style type="text/css">
		#page1 {
			position: relative;
		}
	</style>
</head>

<body onload="setUserBrowserLocation();">

<!-- First Page -->
<div id="page1" class="fill menu-gap">

<div class="navbar navbar-fixed-top">
<?php
# Vertical menu content
$this->load->view('addons/vertical_menu',
	array('__page'=>'login', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel, 'news'=>$menuNewsLable, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel));

# Header content
$this->load->view('addons/header_public', array('__page'=>'login', 'signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
?>
</div>



<div class="center-block" style="width:100%;">
<div class="one-column-table">
<form id='loginform' method="post" action='<?php echo base_url(); ?>account/login'>
<table>
<tr><td class="h2 dark-grey" style="text-align:left;"><?php echo $loginBoxTitle;?></td></tr>

<?php if(!empty($msg)) echo "<tr><td style='text-align:left;'>".format_notice($this,$msg)."</td></tr>";?>
<tr><td><input type='text' id='loginusername' name='loginusername' autocapitalize='off' autocomplete='off' class='submit-on-enter' data-targetbtn="submitloginform" placeholder="<?php echo $userNameFieldLabel;?>" value='' /></td></tr>
<tr><td><input type='password' id='loginpassword' name='loginpassword' autocapitalize='off' class="submit-on-enter" data-targetbtn="submitloginform" placeholder="<?php echo $passwordFieldLabel;?>" value='' /></td></tr>
<tr><td style="padding-bottom:0px;"><button type="submit" id="submitloginform" name="submitloginform" class="btn green" style="width:100%;"><?php echo $loginBtnLabel;?></button></td></tr>

<tr><td style="padding-top:0px;padding-bottom:0px;"><div class='h3'><a href="<?php echo base_url();?>account/sign_up"><?php echo $signUpLinkLabel;?></a></div>

<?php if($this->native_session->get('__store_id')) { ?>
	<input type='hidden' id='redirectaction' name='redirectaction' value='<?php echo base_url().'search/store/id/'.format_id($this->native_session->get('__store_id')); ?>' />
<?php } ?>
	<input type='hidden' id='action' name='action' value='<?php echo base_url(); ?>account/login' />
	<input type='hidden' id='tempmessage' name='tempmessage' value='Login in progress..' />
	<input type='hidden' id='errormessage' name='errormessage' value='ERROR: All fields are required except where indicated.' />

<div class='h3'><a href="<?php echo base_url();?>account/forgot_password"><?php echo $forgotPasswordLinkLabel;?></a></div>
</td></tr>
</table>
</form>
</div>
</div>

</div>

<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>




<script type="text/javascript" src="https://www.clout.com/assets/js/clout.googleanalytics.js"></script>
<?php echo minify_js('account__login', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js'));?>

</body>
</html>
