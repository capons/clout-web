<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": Customer";?></title>
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
    <?php if(!empty($this->native_session->get('__user_id'))) { ?>
    <script type="text/javascript">
      i_user_id = "<?php echo $this->native_session->get('__user_id'); ?>";
    </script>
    <?php
  }?>
</head>

<body>

<!-- First Page -->
<div id="page1" class="menu-gap" style="background: url(<?php echo base_url();?>assets/images/customer_home.png) no-repeat center 50px; min-height: 1350px; min-width: 1024px; width: 100%; top: 0; left: 0;">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', array('__page'=>'customer_home', 'area'=>'store_owner')); 
# Header content
$this->load->view('addons/header_admin', array('__page'=>'customer_home', 'title'=>'Customers'));
 
?>
</div>











<?php $this->load->view('addons/footer_admin'); ?>
</div>





<?php echo minify_js('customer__home', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js'));?>

</body>
</html>