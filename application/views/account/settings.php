<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": My Account Settings";?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.list.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.search.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">
    <style type="text/css">
		#page1 {
			position: relative;
		}
	</style>
</head>

<body>

<!-- First Page -->
<div id="page1" class="fill">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$menuArea = ($this->native_session->get('__user_type')? $this->native_session->get('__user_type'): 'random_shopper');
$this->load->view('addons/vertical_menu', array('__page'=>'my_account', 'area'=>$menuArea)); 
# Header content
$this->load->view('addons/header_shopper', array('__page'=>'my_account'));
?>
</div>

<div class="menu-gap" style="position:absolute;top:0; width:100%;">
<table style="width:100%; border:0">
<tr><td class="search-wrapper">

<div class='details-box'>
<table>
<tr><td>Profile</td></tr>
<tr><td><table class='inner-details-table'>
<tr><td rowspan="5" style="width:1%; vertical-align:top;"><div id='user_setting_photo'><div style="background: url(<?php echo (!empty($settings['photo'])? $settings['photo']: BASE_URL.'assets/uploads/public_user_icon_large.png');?>) no-repeat center top;" class="large-user-photo"></div></div></td><td colspan="2" class='h3'>
<?php echo '&nbsp;'.$settings['name'];?></td>
  </tr>
<tr>
  <td class='light-bold grey' style="width:1%;">Gender</td>
  <td><?php echo ucfirst($settings['gender']);?></td>
</tr>
<tr>
  <td class='light-bold grey'>Born</td>
  <td><?php echo format_epoch_date($settings['birthday'], 'm/d/Y');?></td>
</tr>
<tr>
  <td class='light-bold grey' nowrap>Member Since</td>
  <td><?php echo format_epoch_date($settings['dateJoined'], 'm/d/Y');?></td>
</tr>
<tr>
  <td colspan="2" class='microform'>
  	<button type="button" class='btn blue' id='updatephoto' name='updatephoto' onclick="clickItem('settingphotourl')">Update Photo</button> <span class='info-btn' onclick="toggleLayersOnCondition('image_restrictions', 'image_restrictions')">&nbsp;</span>
  <input type='hidden' id='settingphotourl' name='settingphotourl' class='filefield' value='' data-val='jpg,jpeg,gif,png,tiff' data-size='3000' />
  <input type='hidden' id='tempmessage' name='tempmessage' value='Uploading photo..' />
  <input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
  <input type='hidden' id='redirectaction' name='redirectaction' value='<?php echo base_url();?>account/settings' />
  <input type='hidden' id='action' name='action' value='<?php echo base_url();?>account/settings/a/user_photo' />
  <div id='image_restrictions' class="smalltext" style="display:none;">Allowed Formats: JPG, JPEG, GIF, PNG, TIFF <br />Max Size: 3MB<br />Dimensions: At least 300x300px</div></td>
  </tr>
</table></td></tr>


<tr><td style="padding-top:0px;">
<table class='inner-details-table microform'>
<tr><td colspan='2'><span class='light-bold grey'>Password last updated:</span> <?php echo format_epoch_date($settings['passwordLastUpdated'], 'm/d/Y');?></td></tr>
<tr><td>
<div id='password_update_result'></div>
<input type='password' id='newpassword' name='newpassword' placeholder='Enter New Password' value='' style="width:100%;"/></td>
<td width='1%'><button  id='updatepassword' name='updatepassword' class='btn blue submitmicrobtn' style="min-width: 90px;">Update</button>
<input type='hidden' id='tempmessage' name='tempmessage' value='Updating your password..' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='password_update_result' />
  <input type='hidden' id='action' name='action' value='<?php echo base_url();?>account/settings/a/new_password' /></td></tr>
</table>
</td></tr>


<tr><td style="padding-top:0px;">
<table class='inner-details-table microform'>
<tr><td colspan='2'><span class='light-bold grey'>Add Location</span></td></tr>
<tr><td colspan='2'><input type='text' id='addressline1' name='addressline1' placeholder='Address Line 1' value='<?php if(empty($settings['savedAddresses'])) echo $settings['addressLine1'];?>' style="width:100%;"/></td>
<tr><td colspan='2'><input type='text' id='addressline2' name='addressline2' placeholder='Address Line 2 (Optional)' class='optional' value='<?php if(empty($settings['savedAddresses'])) echo $settings['addressLine2'];?>' style="width:100%;"/></td>
<tr><td><input type='text' id='city' name='city' placeholder='City' value='<?php if(empty($settings['savedAddresses'])) echo $settings['city'];?>' style="width:100%;"/></td>
<td width='30%'><select id='state__states' name='state__states' class="drop-down" style="min-width:100px; width:100%;">
<?php echo get_option_list($this, 'states', 'select','',array('selected'=>(empty($settings['savedAddresses'])? $settings['state']:'') ));?>
</select></td></tr>
<tr><td><select id='country__countries' name='country__countries' class="drop-down" style="min-width:100px; width:100%;">
<?php echo get_option_list($this, 'countries', 'select','',array('selected'=>(empty($settings['savedAddresses'])? $settings['country']:'USA') ));?>
</select></td>
<td width='30%'><input type='text' id='zipcode' name='zipcode' placeholder='Zip Code' value='<?php if(empty($settings['savedAddresses'])) echo $settings['zipcode'];?>' style="min-width:100px;width:100%;"/></td></tr>
<tr><td>&nbsp;</td>
<td width='30%' style="padding-bottom:10px;"><button id='saveaddress' name='saveaddress'  class='btn blue submitmicrobtn' style="min-width:100px;width:100%;">Save</button>
<input type='hidden' id='tempmessage' name='tempmessage' value='Adding new address..' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='saved_address_list' />
  <input type='hidden' id='action' name='action' value='<?php echo base_url();?>account/settings/a/add_address' /></td></tr>

<tr><td colspan='2' class='light-bold light-grey-bg'>Saved Addresses</td></tr>

<tr><td colspan='2' style="padding:0px;"><div id='saved_address_list' style="width:100%;">
<?php $this->load->view('account/saved_addresses',array('savedAddresses'=>$settings['savedAddresses']));?>
</div>
</td></tr>




</table>
</td></tr>




</table>
</div>

<div class='details-box'>
<table>
<tr><td>Privacy</td></tr>

<tr><td>
<table class='inner-details-table privacy-table'>
<tr><td colspan='2'><span class='light-bold grey'>Email:</span> <?php echo $settings['emailAddress'];?></td></tr>
<tr><td colspan='2'><table><tr><td><input id='sendmeemail' name='sendmeemail' type='checkbox' value='Y' class='bigcheckbox one-field-submit' data-action='account/settings/a/update_privacy/t/email' <?php if(!empty($settings['notificationPreferences']) && in_array('email', $settings['notificationPreferences'])) echo 'checked';?>><label for='sendmeemail'></label></td><td style="padding-left:10px;">Send me notifications by email </td></tr></table></td></tr>
<tr class='microform'><td><input type='text' id='newemail' name='newemail' class="email" placeholder='Email Address' value='' style="width:100%;"/></td>
<td width='1%'><button id='addemail' name='addemail' class='btn green submitmicrobtn' style="min-width: 90px;">Add</button>
<input type='hidden' id='tempmessage' name='tempmessage' value='Adding new email address..' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='saved_email_list' />
<input type='hidden' id='action' name='action' value='<?php echo base_url();?>account/settings/a/add_email' /></td></tr>

<tr><td colspan='2' style="padding-bottom: 15px;"><div id='saved_email_list' style="width:100%;">
<?php $this->load->view('account/saved_emails',array('savedEmails'=>$settings['savedEmails']));?>
</div></td></tr>

<tr><td colspan='2' style='border-top: 1px solid #CCC; padding: 0px; height: 15px;'></td></tr>

<tr><td colspan='2'><span class='light-bold grey'>Telephone:</span> <?php echo format_telephone($settings['telephone']);?></td></tr>
<tr><td colspan='2'><table><tr>
<td><input id='sendmesms' name='sendmesms' type='checkbox' value='Y' class='bigcheckbox one-field-submit' data-action='account/settings/a/update_privacy/t/sms' <?php if(!empty($settings['notificationPreferences']) && in_array('sms', $settings['notificationPreferences'])) echo 'checked';?>><label for='sendmesms'></label></td><td style="padding-left:10px; padding-right:30px;">Send me notifications by SMS</td>
<td><input id='sendmecall' name='sendmecall' type='checkbox' value='Y' class='bigcheckbox one-field-submit' data-action='account/settings/a/update_privacy/t/call' <?php if(!empty($settings['notificationPreferences']) && in_array('call', $settings['notificationPreferences'])) echo 'checked';?>><label for='sendmecall'></label></td><td style="padding-left:10px;">Call me for voice notifications</td>
</tr></table></td></tr>
<tr class='microform'><td><table style="width:100%;"><tr><td style="width:calc(60% - 20px);"><input type='text' id='newtelephone' name='newtelephone' class="numbersonly telephone" placeholder='Telephone' value='' style="width:100%;"/></td><td style="width:40%;padding-left:10px;">
<select id='provider__provider' name='provider__provider' class="drop-down" style="width:100%;">
<?php echo get_option_list($this, 'provider');?>
</select></td></tr></table></td>
<td width='1%'><button id='addtelephone' name='addtelephone' class='btn green submitmicrobtn' style="min-width: 90px;">Add</button><input type='hidden' id='tempmessage' name='tempmessage' value='Adding new telephone..' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='saved_phone_list' />
<input type='hidden' id='action' name='action' value='<?php echo base_url();?>account/settings/a/add_telephone' /></td></tr>

<tr><td colspan='2'><div id='saved_phone_list' style="width:100%;">
<?php $this->load->view('account/saved_phones',array('savedPhones'=>$settings['savedPhones']));?>
</div></td></tr>


</table>
</td></tr>









</table>
</div>



</td></tr>
<tr><td style="padding-top:30px;">&nbsp;</td></tr>
</table>
</div>





<?php $this->load->view('addons/footer_admin', array('__page'=>'my_account')); ?>
</div>





<?php echo minify_js('account__settings', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery-ui-timepicker-addon.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js', 'clout.scroller.js', 'clout.list.js', 'clout.settings.js'));?>

</body>
</html>