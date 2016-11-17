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
<script type='text/javascript' src='<?php echo base_url();?>assets/js/clout.fblogin.js'></script>



<!-- First Page -->
<div id="page1" class="fill menu-gap">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', 
	array('__page'=>'signup', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel, 'news'=>$menuNewsLable, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); 
	
# Header content
$this->load->view('addons/header_public', array('__page'=>'signup', 'signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
?>
</div>




<div class="center-block" style="width:100%;">
	<div class="one-column-table">
		<table class='microform ignoreclear'>
			<tr>
				<td class="h3" style="text-align:left; padding-bottom:0px;">Sign Up</td>
			</tr>

			<tr>
				<td>
					<div id='signupwithfb' onclick="fb_login()">&nbsp;</div>
					<div id="status" style="display:none;"></div>
					<div id='signupwithfb_msg' style="display:none;width:100%;">
						<?php echo format_notice($this, 'Please fill the remaining fields below and <br>click Sign Up to proceed.');?>
					</div>
					<div id='enable_tracking_msg' style="display:none;width:100%;">
						<?php echo format_notice($this, 'WARNING: Please enable your browser\'s tracking to sign up with facebook.');?>
					</div>
				</td>
			</tr>

			<tr>
				<td style="padding-top:0px; padding-bottom:0px;">
					<table style="border:none; width:100%;">
						<tr>
							<td class="horizontal-separator" style="width:49%;">&nbsp;</td>
							<td style="width:2%;">OR</td>
							<td class="horizontal-separator" style="width:49%;">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			
			<tr>
				<td class="h3" style="text-align:left; padding-top:0px; padding-bottom:0px;"><?php echo $createNewBoxTitle;?></td>
			</tr>
			
			<tr>
				<td>
					<div class="full-col">
						<input type='text' id='firstname' name='firstname' class='textfield' placeholder="<?php echo $firstNameFieldLabel;?>" value='' style="min-width:240px;"/>
					</div>
					<div class='col-separator'>
						<img src="<?php echo IMAGE_URL.'spacer.gif';?>" border="0" width="15"/>
					</div>
					<div class="full-col">
						<input type='text' id='lastname' name='lastname' class='textfield' placeholder="<?php echo $lastNameFieldLabel;?>" value='' style="min-width:240px;"/>
					</div>
					</td>
			</tr>
			
			<tr>
				<td>
					<div>
						<input type='text' id='emailaddress' name='emailaddress' autocapitalize="off" placeholder="<?php echo $emailAddressFieldLabel;?>" value='' class='email' style="min-width:240px;"/>
						<input type='hidden' id='emailverified' name='emailverified' value='N' />
					</div>
					<div class='col-separator'
						><img src="<?php echo IMAGE_URL.'spacer.gif';?>" border="0" width="15"/>
					</div>
					<div>
						<input type='password' id='newpassword' name='newpassword' placeholder="<?php echo $passwordFieldLabel;?>" value='' style="min-width:240px;"/>
					</div>
				</td>
			</tr>
			
			<tr>
				<td>
					<div class="col-span">
						<table style="border:none">
							<tr>
								<td>
									<input type='text' id='mobilephone' name='mobilephone' class="numbersonly telephone" placeholder="<?php echo $mobilePhoneFieldLabel;?>" value='' style="min-width:140px;"/>
								</td> 
								<td>
									<select id='provider__provider' name='provider__provider' class="drop-down" style="min-width:100px;">
										<?php echo get_option_list($this, 'provider');?>
									</select>
								</td>
							</tr>
						</table>
					</div>

					<div class='col-separator'>
						<img src="<?php echo IMAGE_URL.'spacer.gif';?>" border="0" width="15"/>
					</div>
					
					<div>
						<input type='text' id='zipcode' name='zipcode' placeholder="<?php echo $zipcodeFieldLabel;?>" value='' class="numbersonly zipcode" style="min-width:240px;"/>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div>
						<select id='gender__gender' name='gender__gender' class="drop-down" style="min-width:240px;">
							<option value='' disabled selected><?php echo $genderFieldLabel;?></option>
							<?php echo get_option_list($this, 'gender');?>
						</select>
					</div>

					<div class='col-separator'>
						<img src="<?php echo IMAGE_URL.'spacer.gif';?>" border="0" width="15"/>
					</div>
					
					<div class="col-span">
						<table style="border:none">
							<tr>
								<td style='padding-right:10px;'>Born</td>
								<td>
									<select id='birthmonth__monthnumber' name='birthmonth__monthnumber' class="drop-down hide-icon" style="min-width:50px;">
										<option value='' disabled selected><?php echo $birthMonthFieldLabel;?></option>
										<?php echo get_option_list($this, 'monthnumber');?>
									</select>
								</td>
								
								<td>
									<select id='birthday__monthday' name='birthday__monthday' class="drop-down hide-icon" style="min-width:50px;">
										<option value='' disabled selected><?php echo $birthDayFieldLabel;?></option>
										<?php echo get_option_list($this, 'monthday');?>
									</select>
								</td>
								
								<td>
									<select id='birthyear__pastyear' name='birthyear__pastyear' class="drop-down" style="min-width:80px;">
										<option value='' disabled selected><?php echo $birthYearFieldLabel;?></option>
										<?php echo get_option_list($this, 'pastyear');?>
									</select>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>

			<tr>
				<td>
					<button id="signupbtn" name="signupbtn" class="btn green submitmicrobtn" style="width:100%;"><?php echo $signUpBtnLabel;?></button>

					<input type='hidden' id='facebookid' name='facebookid' value='' />
					<input type='hidden' id='action' name='action' value='<?php echo base_url();?>account/sign_up' />
					<input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
					<input type='hidden' id='redirectaction' name='redirectaction' value='<?php echo base_url();?>account/verify_email' />
				</td>
			</tr>

			<tr>
				<td class='smalltext' style='padding-top:0px;'>
					<?php echo replace_content_links($signupDisclaimer, array('terms_link'=>base_url().'page/terms/t/popup', 'privacy_link'=>base_url().'page/privacy/t/popup'), array('shadowbox','closable'));?>
				</td>
			</tr>
		</table>
	</div>
</div>

</div>

<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>




<script type="text/javascript" src="https://www.clout.com/assets/js/clout.googleanalytics.js"></script>
<?php echo minify_js('account__signup', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js'));?>

</body>
</html>