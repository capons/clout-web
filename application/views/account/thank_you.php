<?php if(empty($msg)) $msg = get_session_msg($this);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITE_TITLE.": Thank You";?></title>
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
$this->load->view('addons/vertical_menu', 
	array('__page'=>'login', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); 
	
# Header content
$this->load->view('addons/header_public', array('__page'=>'invite', 'signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
?>
</div>


<div class="center-block" style="width:100%;">
	<div class="one-column-table" style="border: 0px; width:100%; max-width:50%;">
	
		<table>
			<?php if(!empty($msg)) echo "<tr><td>".format_notice($this, $msg)."</td></tr>";?>
	
			<tr>
				<td class="h3 dark-grey">Thank you for joining Clout.
					<br />
					Get ready to start receiving the most important score of your life.
				</td>
			</tr>

			<tr>
				<td style="padding-top:0px;">See why the clout score matters. <a href='https://www.youtube.com/embed/bx4ehxmWYX4' class="shadowbox closable black" data-type="in-sys-load">Watch Video</a>.
				</td>
			</tr>
			<tr>
				<td style="padding-top:40px !important;padding-bottom:0px;">
					<button type="button" id="addmorebtn" name="addmorebtn" class="btn blue" data-url='network/invite' style="width:100%;">Invite More (Build Your Network)</button>
				</td>
			</tr>

		</table>
	</div>
</div>

</div>

<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>





<?php echo minify_js('account__thank_you', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js'));?>

</body>
</html>