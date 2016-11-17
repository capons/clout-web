<?php if(empty($msg)) $msg = get_session_msg($this);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": Invite Friends";?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
	
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">

	<style type="text/css">
		.one-column-table table td {
			padding: 5px !important;
		}
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
$this->load->view('addons/vertical_menu', array('__page'=>'login')); 
	
# Header content
$this->load->view('addons/header_public', array('__page'=>'invite', 'signup'=>'Sign Up', 'login'=>'Login'));
?>
</div>


<div class="center-block" style="width:100%;">
<div class="one-column-table" style="border: 0px; width:100%; max-width:50%;">
<table>
<tr><td class="h3 dark-grey">Clout is currently in BETA.
<?php 
if($directInvitationCount >= MINIMUM_INVITE_COUNT){
	echo "<br />Build your network early. Invite more friends.";
} else {
	echo "<br />You can gain early access now by signing up ".MINIMUM_INVITE_COUNT." friends.";
}
?>
</td></tr>
<?php if(!empty($msg)) echo "<tr><td style='text-align:left;'>".format_notice($this,$msg)."</td></tr>";?>
<tr><td>

<div class="one-column-table microform" style="border: #CCC 1px solid; width:99%; max-width:99%;">
<table>
<tr><td class="h3 dark-grey" style="text-align:center;"><?php 
$extraNeeded = MINIMUM_INVITE_COUNT - $directInvitationCount;
if($directInvitationCount > 0 && $extraNeeded < MINIMUM_INVITE_COUNT && $directInvitationCount < MINIMUM_INVITE_COUNT){
	echo 'Invite at least '.$extraNeeded.' more friend'.($extraNeeded > 1? 's': '').' to continue.<br>';
}
else if(empty($directInvitationCount)) echo 'Invite '.MINIMUM_INVITE_COUNT.' friends to continue.<br>';

if(!empty($directInvitationCount)){
	echo "(<a href='javascript:;' onclick=\"updateFieldLayer('".base_url()."network/invited_emails','','','invited_email_list','');\">".$directInvitationCount." invited</a> so far)";
}?>
<br /><div id='invited_email_list' style='width:100%;'></div></td></tr>
<tr><td><div class='textfield mocktextfield' style='font-size:16px; width:100%;min-height:150px; float:left;'>
   <input name='newemail' type='text' id='newemail' value='' style='border: 0px;margin-bottom:20px;' placeholder='Enter or paste email addresses here'><input type='hidden' value='' name='emailpastevalues' id='emailpastevalues'>
    </div></td></tr>
<tr><td>
<table><tr>
<td><button type="button" id="sendpasteemails" name="sendpasteemails" class="btn blue" style="width:100%;">Send</button> 
<input type='hidden' name='resultsdiv' id='resultsdiv' value=''>
<input type='hidden' name='redirectaction' id='redirectaction' value='<?php echo base_url().'account/thank_you';?>'></td>
<td style="white-space:nowrap;"><a href="<?php echo base_url();?>network/home">Skip Sending Invitations</a>
</td>
</tr></table>


</td></tr>
</table>
</div>

</td></tr>


<tr><td style="padding-top:0px;padding-bottom:0px;">Otherwise, you will receive an email when Clout opens to the general public.
<BR />See how referring your friends can make you money. <a href='https://www.youtube.com/embed/tY5lvTae3hs' class="shadowbox closable black" data-type="in-sys-load">Watch Video</a>.
</td></tr>
</table>
</div>
</div>

</div>

<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>





<?php echo minify_js('network__invite_five', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js', 'clout.network.js'));?>
</body>
</html>