<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": Rules";?></title>
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
		.search-block {
			vertical-align: top;
		}
	</style>
</head>

<body>

<!-- First Page -->
<div id="page1" class="menu-gap">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', array('__page'=>'system_settings', 'area'=>'administrator')); 
# Header content
$this->load->view('addons/header_admin', array('__page'=>'system_settings', 'title'=>'System Settings'));
?>
</div>





<div class="search-block">
<table>
<tr><td style='padding-bottom:0px;'>
<table class='list-scope microform ignoreclear'>
<tr><td style="width:1%;">
<select id='setting_settingpages' name='setting_settingpages' class='drop-down go-to-selected' data-baseurl='setting' style='min-width: 200px;'><?php echo get_option_list($this, 'settingpages', 'select', '', array('selected'=>'rule_settings'));?></select>
</td>

<td style="padding-left:10px;width:1%;"><input type="text" id="rulesettingssearch" data-type="rules" name="rulesettingssearch" class='optional submit-on-enter' data-targetbtn='rulesettingssearchbtn' placeholder="Search.." style="width:300px;" value=""/>
<input type='hidden' id='resultsdiv' name='resultsdiv' value='rulesettingssearchdiv' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Loading results that meet your search criteria..' />
<input type='hidden' id='action' name='action' value='<?php echo base_url()."lists/load/t/rule_settings_list/n/20/f/search";?>' /></td>
<td style="padding-left:10px;width:1%;"><button id='rulesettingssearchbtn' name='rulesettingssearchbtn' class='btn green submitmicrobtn' style="min-width:50px;">GO</button></td>

<td style="padding-left:10px;width:97%; text-align:right;">&nbsp;</td>
</tr>

</table>
</td></tr>



<tr><td style='padding-left:10px;padding-right:10px;'><div id='rulesettingssearchdiv' class='continous-scroll' data-type='rule_settings_list' data-page='1' data-noperpage='20' data-url='<?php echo base_url().'lists/load/t/rule_settings_list';?>' data-fields='rulesearch=phrase'><?php $this->load->view('setting/rule_settings_list_container', array('ruleSettingsList'=>$ruleSettingsList));?> 
</div></td></tr>

</table>
</div>

</div>




<div>
<?php $this->load->view('addons/footer_admin'); ?>
</div>





<?php echo minify_js('setting__rule_settings_dashboard', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js', 'clout.search.js', 'clout.pagination.js', 'clout.list.js', 'clout.scroller.vertical.js'));?>

</body>
</html>