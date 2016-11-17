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
		#page2 {
			position: relative;
		}
	</style>
    
</head>

<body>


<!-- First Page -->
<div id="page1" class="fill affiliatesbg">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', 
	array('__page'=>'agents', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel,  'news'=>$menuNewsLable, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); 
	
# Header content
$this->load->view('addons/header_public', array('signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
?>
</div>


<div class="center-block">
<div class="intro-video-icon shadowbox closable black" data-url="<?php echo $introductionVideo;?>" data-type="in-sys-load">&nbsp;</div>

<div class="h1 white"><?php echo $page1Title;?></div>
<div class="h3 white" style="margin-bottom: 40px;"><?php echo $page1Content;?></div>
<button id="startbtn_page1" name="startbtn_page1" class="btn green" style="width:60%; text-align:center; min-width:230px;" data-url="account/sign_up/t/agents"><?php echo $startBtnLabel;?></button>
</div>

<div class="nextpage align-vertical-bottom next-white-shade" onClick="scrollToAnchor('page2')">&nbsp;</div>
</div>




<!-- Second Page -->
<div id="page2" class="fill menu-gap">

<div class="center center-padding-bottom"><table style="width:100%; border:0" class="body-table">
<tr><td class="h1 dark-grey center"><?php echo $page2Title;?></td></tr>
<tr><td>
<div class="col-3-table-cell"><div class="row-icon sells-itself-icon">&nbsp;</div>
	<br /><span class="h2 dark-grey"><?php echo $column1Title;?></span>
	<br /><?php echo $column1Content;?>
</div>
 
<div class="col-3-table-cell"><div class="row-icon huge-demand-icon">&nbsp;</div>
	<br /><span class="h2 dark-grey"><?php echo $column2Title;?></span>
	<br /><?php echo $column2Content;?>
</div>
    
<div class="col-3-table-cell"><div class="row-icon ongoing-commissions-icon">&nbsp;</div>
	<br /><span class="h2 dark-grey"><?php echo $column3Title;?></span>
	<br /><?php echo $column3Content;?>
</div>
</td></tr>
<tr><td class="center"><button id="startbtn_page2" name="startbtn_page2" class="btn blue" style="width:60%; text-align:center;" data-url="account/sign_up/t/agents"><?php echo $startBtnLabel;?></button></td></tr>

</table>

<?php 
$this->load->view('addons/footer_public'); 
?>
</div>

</div>





<?php echo minify_js('page__agents', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js'));?>

<script type="text/javascript">
$(function(){ 
	$('#startbtn_page2').width($('#startbtn_page1').width()); 
	$(window).resize(function() { $('#startbtn_page2').width($('#startbtn_page1').width());});
});
</script>

</body>
</html>