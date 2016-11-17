<?php if(empty($msg)) $msg = get_session_msg($this);?>
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

<body>

<!-- First Page -->
<div id="page1" class="fill menu-gap">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', 
	array('__page'=>'forgot_password', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); 
	
# Header content
$this->load->view('addons/header_public', array('__page'=>'forgot_password', 'signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
?>
</div>


<div class="center-block" style="width:100%;">
<div class="one-column-table">

<table class='microform'>
<?php if(!empty($area) && $area == 'recover_password'){?>

<tr><td class="h2 dark-grey" style="text-align:left;padding-bottom:0px;"><?php echo $recoverBoxTitle;?></td></tr>
<tr><td><div id='response_msg' style="display:block;width:100%;"><?php echo !empty($msg)? format_notice($this, $msg).'<br />': '&nbsp;';?></div>

<?php if(!empty($showRecoveryForm))
{?>
<br /><input type='password' id='yournewpassword' name='yournewpassword' placeholder="<?php echo $newPasswordFieldLabel;?>" value='' /></td></tr>
<tr><td><input type='password' id='repeatnewpassword' name='repeatnewpassword' class='submit-on-enter' data-targetbtn='resetpass' placeholder="<?php echo $repeatNewPasswordFieldLabel;?>" value='' /></td></tr>

<tr><td><button type="button" id="resetpass" name="resetpass" class="btn blue submitmicrobtn" style="width:100%;"><?php echo $recoverBtnLabel;?></button>
<input type='hidden' id='action' name='action' value='<?php echo base_url().'account/recover_password';?>' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='response_msg' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Resetting your password..' />
<?php 
echo "<input type='hidden' id='userid' name='userid' value='".$userId."' />"; 

}?>
</td></tr>




<?php
} else {
?>
<tr><td class="h2 dark-grey" style="text-align:left;padding-bottom:0px;"><?php echo $forgotBoxTitle;?></td></tr>
<tr><td><div id='response_msg' style="display:block;width:100%;"><?php echo !empty($msg)? format_notice($this, $msg).'<br />': '&nbsp;';?></div>
<br /><input type='text' id='youremail' name='youremail' class='email submit-on-enter' data-targetbtn='sendpasslink' placeholder="<?php echo $yourEmailFieldLabel;?>" value='' /></td></tr>
<tr><td><button type="button" id="sendpasslink" name="sendpasslink" class="btn blue submitmicrobtn" style="width:100%;"><?php echo $sendPassLinkBtnLabel;?></button>
<input type='hidden' id='action' name='action' value='<?php echo base_url().'account/forgot_password';?>' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='response_msg' />
<input type='hidden' id='redirectaction' name='redirectaction' value='<?php echo base_url().'account/login';?>' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Sending a link to reset your password..' />
</td></tr>
<?php } ?>


</table>
</div>
</div>

</div>

<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>





<?php echo minify_js('account__forgot_password', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js'));?>
</body>
</html>