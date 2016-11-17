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


<?php 
# Show if it is not being veiwed in a popup
if(empty($t)){?>
<!-- First Page -->
<div id="page1" class="fill menu-gap">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', 
	array('__page'=>'terms', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel,  'news'=>$menuNewsLable, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); 
	
# Header content
$this->load->view('addons/header_public', array('__page'=>'terms', 'signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
?>
</div>


<div class="center-block" style="width:100%;">
<div class="one-column-table" style="border:0px;width: 100%; max-width: 1000px;">
<?php }?>




<table style="width: 100%;">
<tr><td class="h2 dark-grey" style="text-align:left;"><?php echo $termsBoxTitle;?></td></tr>
<tr><td style="text-align:justify;">
<?php echo $termsDetails;?>
</td></tr>
</table>





<?php 
# Show if it is not being veiwed in a popup
if(empty($t)){?>
</div>
</div>

</div>

<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>
<script type="text/javascript" src="https://www.clout.com/assets/js/clout.googleanalytics.js"></script>
<?php echo minify_js('page__terms', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js'));?>

<?php }?>



</body>
</html>
