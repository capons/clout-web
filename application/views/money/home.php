<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
	<title><?php echo SITE_TITLE.": Money";?></title>
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
<div id="page1" class="menu-gap" style="background: url(<?php echo base_url();?>assets/images/money_home.png) no-repeat center 50px; min-height: 1000px; min-width: 1024px; width: 100%; top: 0; left: 0;">

<div class="navbar navbar-fixed-top">
<?php 


# Vertical menu content
$this->load->view('addons/vertical_menu', array('__page'=>'money_home', 
	'area'=>($this->native_session->get('__user_type')? $this->native_session->get('__user_type'): 'random_shopper')
)); 
# Header content
$this->load->view('addons/header_admin', array('__page'=>'money_home', 'title'=>'Money'));

?>
</div>











<?php $this->load->view('addons/footer_admin'); ?>
</div>





<?php echo minify_js('search_home', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js'));?>

</body>
</html>