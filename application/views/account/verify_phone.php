<?php 
# Only show if user has not posted anything
if(empty($hasPosted)){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": Verify Phone";?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.scroller.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.search.css" type="text/css" media="screen">
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
$this->load->view('addons/vertical_menu', 
	array('__page'=>'signup', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); 
	
# Header content
$this->load->view('addons/header_public', array('__page'=>'signup', 'signup'=>'Sign Up', 'login'=>'Login'));
?>
</div>

<div class="center-block" style="width:100%;">
<div class="one-column-table">
<table style="width:100%;">

<tr><td style="text-align:center;">
<div id='verify_form_area' style="width: 100%;">
<?php 
}

if(!empty($area) && $area == 'user_phone_details')
{?>
<table style="border:none; padding:5px;" class='microform'>
<tr><td class="h2 dark-grey" colspan="2">Verify Your Mobile Phone</td></tr>
<tr><td colspan="2" class='h4 dark-grey' style='text-align:left;'>This is required for account security. A verification code will be sent to this phone.</td></tr>
<tr><td>
<input type='text' id='telephone' name='telephone' class="numbersonly telephone" placeholder="Enter Mobile Phone" value='<?php echo $this->native_session->get('__telephone');?>' style="min-width:100px; width:100%;"/>
</td> 
<td>
<select id='provider__provider' name='provider__provider' class="drop-down" style="min-width:100px;width:100%;">
<?php echo get_option_list($this, 'provider','select','',array('selected'=>$this->native_session->get('__provider_id')) );?>
</select>
</td>
</tr>

<tr>
<td colspan="2">
<button type="submit" id="updatebtn" name="updatebtn" class="btn blue submitmicrobtn" style="min-width:90px;width:100%;">Confirm</button>
<input type='hidden' name='resultsdiv' id='resultsdiv' value='verify_form_area'>
<input type='hidden' name='action' id='action' value='<?php echo base_url().'account/update_user_phone';?>'>
</td>
</tr>


<tr><td colspan="2" style='padding-bottom:30px;'>&nbsp;</td></tr>

</table>
<?php 
}




else if(!empty($area) && $area == 'verify_code_form')
{?>
<table class='microform'>
<tr><td colspan='2' class="h2 dark-grey">Verification Code</td></tr>
<?php if(!empty($msg)) echo "<tr><td colspan='2'>".format_notice($this, $msg)."</td></tr>";?>
<tr><td colspan='2' class='h4' style="text-align:left;"><?php echo "Enter the verification code sent to  <b>".format_telephone($this->native_session->get('__telephone'))." (".$this->native_session->get('__provider').")</b>";?> <a href='javascript:;' onclick="updateFieldLayer('<?php echo base_url().'account/update_user_phone/hasPosted/Y/edit/Y';?>','','','verify_form_area','')">edit</a></td></tr>
<tr><td colspan='2'><input type='text' id='usercode' name='usercode' placeholder="Enter Verification Code" value='' /></td></tr>

<tr><td class='row-cells-2' style="padding-bottom:0px;"><button type="button" id="skipbtn" name="skipbtn" class="btn grey" data-url='account/update_user_phone' style="width:100%;">Resend</button>
</td>
<td><button type="submit" id="verifybtn" name="verifybtn" class="btn green submitmicrobtn" style="width:100%;">Verify</button>

<input type='hidden' name='resultsdiv' id='resultsdiv' value='verify_form_area'>

<?php if(!empty($this->native_session->get('__store_id'))) { ?>
	<input type='hidden' id='redirectaction' name='redirectaction' value='<?php echo base_url().'search/store/id/'.format_id($this->native_session->get('__store_id')); ?>' />
	<input type='hidden' id='tempmessage' name='tempmessage' value='Login in progress..' />
	<input type='hidden' id='errormessage' name='errormessage' value='ERROR: All fields are required except where indicated.' />
<?php } ?>

<input type='hidden' name='action' id='action' value='<?php echo base_url().'account/update_user_phone';?>'>
</td></tr>

</table>
<?php }


 


else if(!empty($area) && $area == 'verify_code_results')
{?>
<table>
<tr><td colspan='2' class="h2 dark-grey">Phone Verified!</td></tr>
<?php if(!empty($msg)) echo "<tr><td colspan='2'>".format_notice($this, $msg)."</td></tr>";?>
<tr><td colspan='2' style="padding-bottom:0px;"><button type="button" id="verifybtn" name="verifybtn" class="btn blue" data-url='network/invite' style="width:100%;">Done</button>
</td></tr>
</table>
<?php }





if(empty($hasPosted)){
?>
</div>
</td></tr></table><input type='hidden' id='layerid' name='layerid' value='' />
</div>
</div>
</div>

<?php echo minify_js('account__verify_phone', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.search.js', 'clout.shadowbox.js'));?>

</body>
</html>
<?php }?>