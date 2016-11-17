<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
	<title><?php echo SITE_TITLE.": Unsubscribe";?></title>
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
	array('__page'=>'contact', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); 
	
# Header content
$this->load->view('addons/header_public', array('__page'=>'contact', 'signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
?>
</div>


<div class="center-block" style="width:100%;">
<div class="one-column-table" id='response_msg'>
<table class='microform'>
<tr><td class="h2 dark-grey" style="text-align:left;padding-bottom:0px;">Unsubscribe</td></tr>

<?php 
if(!empty($msg)){
	echo "<tr><td>".format_notice($this, $msg)."</td></tr>";
}
else {
?>
<tr><td style="text-align:left;">We have received a request to unsubscribe <span style='font-weight:bold;'><?php echo $emailAddress;?></span> from our message lists.
<br />If you are a registered user of Clout, <a href='<?php echo base_url().'account/login';?>'>Log In</a> to change your message settings instead.
<br />
<br />Please explain why you would not like to receive any more messages from Clout.</td></tr>
<tr><td><textarea id='reason' name='reason' placeholder="Reason (optional)" class='optional' style="height:80px;"/></textarea></td></tr>
<tr><td><button id="unsubscribebtn" name="unsubscribebtn" class="btn blue submitmicrobtn" style="width:100%;">Confirm</button>
<input type='hidden' id='action' name='action' value='<?php echo base_url().'message/unsubscribe';?>' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='response_msg' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Removing your email from all our sending lists..' />
<input type='hidden' id='emailaddress' name='emailaddress' value='<?php echo $emailAddress;?>' />
</td></tr>
<?php }?>

</table>
</div>
</div>

</div>

<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>





<?php echo minify_js('message__unsubscribe', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js'));?>

</body>
</html>