<?php $msg = get_session_msg($this);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITE_TITLE.": Permission Groups";?></title>
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

<body <?php if(!empty($msg)) echo " onload=\"showServerSideFadingMessage('".$msg."')\"";?>>

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
<select id='setting_settingpages' name='setting_settingpages' class='drop-down go-to-selected' data-baseurl='setting' style='min-width: 200px;'><?php echo get_option_list($this, 'settingpages', 'select', '', array('selected'=>'permission_group'));?></select>
</td>
<td style="padding-left:10px;width:1%;">
<select id='setting_grouptypes' name='setting_grouptypes' class='drop-down go-to-selected' data-baseurl='setting/permission_groups/t' style='min-width: 200px;'><?php echo get_option_list($this, 'groupcategories', 'select','',array('selected'=>$groupCategory));?></select>
</td>

<td style="padding-left:10px;width:1%;"><input type="text" id="permissiongroupsearch" data-type="changes" name="permissiongroupsearch" class='optional submit-on-enter' data-targetbtn='permissiongroupsearchbtn' placeholder="Search.." style="width:300px;" value=""/>
<input type='hidden' id='resultsdiv' name='resultsdiv' value='permissiongroupsearchdiv' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Loading results that meet your search criteria..' />
<input type='hidden' id='action' name='action' value='<?php echo base_url()."lists/load/t/permission_group_list/n/20/f/search/groupcategory/".$groupCategory;?>' /></td>
<td style="padding-left:10px;width:1%;"><button id='permissiongroupsearchbtn' name='permissiongroupsearchbtn' class='btn green submitmicrobtn' style="min-width:50px;">GO</button></td>

<td style="padding-left:10px;width:97%; text-align:right;"><?php if($groupCategory != 'all'){?><button id='addgroupbtn' name='addgroupbtn' class='btn blue' data-url='setting/add_group/t/<?php echo $groupCategory;?>' style="min-width:100px;">Add Group</button><?php }?></td>
</tr>

<tr><td colspan='5' style="padding:10px 10px 0px 10px;"><table style="width:100%;"><tr><td class="light-grey-bg h3" style="padding:10px;border: 1px solid #CCC; border-bottom:0px;"><?php echo ucwords(str_replace('_', ' ', $groupCategory)).' Permission Groups';?></td></tr></table></td></tr>
</table>
</td></tr>



<tr><td style='padding-left:10px;padding-right:10px;'><div id='permissiongroupsearchdiv' class='continous-scroll' data-type='permission_group_list' data-page='1' data-noperpage='20' data-url='<?php echo base_url().'lists/load/t/permission_group_list';?>' data-fields='setting_groupcategories=groupcategory'><?php $this->load->view('setting/permission_group_list_container', array('permissionGroupList'=>$permissionGroupList, 'groupCategory'=>$groupCategory));?> 
</div></td></tr>

</table>
</div>

</div>




<div>
<?php $this->load->view('addons/footer_admin'); ?>
</div>





<?php echo minify_js('setting__permission_group_dashboard', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js', 'clout.search.js', 'clout.pagination.js', 'clout.list.js', 'clout.scroller.vertical.js'));?>

</body>
</html>