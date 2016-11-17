<?php if(empty($msg)) $msg = get_session_msg($this);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": Welcome";?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <style type="text/css">
		#page1 {
			position: relative;
		}
	</style>
</head>

<body>

<!-- First Page -->
<div id="page1" class="fill menu-gap">




<div class="center-block" style="width:100%;">
<div class="one-column-table">
<table style="width:100%; border:0">
  <tr>
    <td><table style="width:100%; border:0" style="border-bottom: 2px #B3B3B3 solid;">
      <tr>
        <td style="text-align:left;"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo_black.png" border="0"></a></td>
        <td>&nbsp;</td>
        <td align="right"><?php 
		if($this->native_session->get('__user_id'))
		{
			echo "<a href='".base_url()."account/log_out'>Logout</a>";
		}
		else
		{
			echo "<a href='".base_url()."account/login'>Login</a>"; 
		}
		?><input name="layerid" id="layerid" type="hidden" value=""></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="padding-top:80px; padding-bottom: 30px; text-align:center;">
    <table style="width:100%; border:0">
      <tr>
        <td class="contentheading" style="padding-bottom:30px;"><?php echo "Welcome".($this->native_session->get('__first_name')? " ".html_entity_decode($this->native_session->get('__first_name'), ENT_QUOTES): '')."!";?></td>
        </tr>
      <tr>
        <td class="h3 dark-grey">Thank you for signing up. We will let <br>you know by email when Clout is available in your area.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</div>

</div>

<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>





<?php echo minify_js('account__splash', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js'));?>

</body>
</html>