<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": Help";?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.list.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.pagination.css" type="text/css" media="screen">
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
<div id="page1" class="fill">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', array('__page'=>'help', 
	'area'=>($this->native_session->get('__user_type')? $this->native_session->get('__user_type'): 'random_shopper')
)); 
# Header content
$this->load->view('addons/header_admin', array('__page'=>'help', 'title'=>'Help'));
 
?>
</div>



<div class="menu-gap" style="padding-left:20px;">
<span class='h1'>Welcome to the System Help Home</span>
</div>

</div>






<div>
<?php $this->load->view('addons/footer_admin'); ?>
</div>





<?php echo minify_js('help__home', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js'));?>
</body>
</html>