<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": Permission Group";?></title>
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
$this->load->view('addons/header_admin', array('__page'=>'system_settings', 'title'=>'Permission Group Details'));
?>
</div>





<div class="search-block">
<table class='microform ignoreclear'>
<tr><td style='padding-bottom:0px;'>
<table class='list-scope'>
<tr>
<td style="width:1%;">
<input type="text" id="permissiongroupname" name="permissiongroupname" placeholder="Enter Group Name" style="width:300px;" value="<?php echo (!empty($details['name'])? html_entity_decode($details['name'], ENT_QUOTES): '');?>"/>
</td>

<td style="width:1%;"><?php
echo "<select id='permissiongrouptype' name='permissiongrouptype' style='width:300px;'>";
		echo get_option_list($this, 'permissiongrouptypes', 'select','', array(
				'groupcategory'=>$details['group_category'],
				'selected'=>($details['group_type']? $details['group_type']: '')
			));
echo "</select>";
?>
</td>

<td style="padding-left:10px;width:1%;">
<button id='permissiongroupsubmitbtn' name='permissiongroupsubmitbtn' class='btn blue save-permission-group' style="min-width:100px;">Save</button>
<input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Saving the permission group details' />
<input type='hidden' id='action' name='action' value='<?php echo base_url()."setting/add_group/t/".$groupCategory.(!empty($id)? "/id/".$id: "");?>' />
<input type='hidden' id='redirect' name='redirect' value='<?php echo base_url()."setting/permission_groups/t/".$groupCategory;?>' />
</td>

<td style="padding-left:10px;width:1%;"><button id='permissiongroupcancelbtn' name='permissiongroupcancelbtn' class='btn grey' data-url='setting/permission_groups/t/<?php echo $groupCategory;?>' style="min-width:100px;">Cancel</button>
</td>

<td class='h3' style="width:97%; text-align:right;"><?php echo !empty($id)? 'Editing': 'Adding';
echo " Group";

if($groupCategory != 'all') echo " Under <span class='bold'>".get_option_list($this, 'groupcategories','array','',array('selected'=>$groupCategory))."</span>";
?></td>
</tr>
</table>
</td></tr>

<tr><td style="padding:10px 10px 0px 10px;"><table style="width:100%; border-left:solid 1px #CCC; border-right:solid 1px #CCC;"><tr><td class="sub-list-header">Rules</td></tr></table></td></tr>
<tr><td style='padding-left:10px;padding-right:10px;'><div id='rulelistdiv' class='location-details-row'>

<?php $this->load->view('setting/rule_container', array(
	'ruleList'=>(!empty($details['rules'])? $details['rules']: array()) 
));?> 
</div></td></tr>



<tr><td style="padding-bottom: 50px;">
<div id='permissionlistdiv' class='search-list-div'>
<?php $this->load->view('setting/permission_container', array(
	'permissionList'=>$permissionList, 
	'selectedPermissions'=>(!empty($details['permissions'])? $details['permissions']: array()) 
));?> 
</div></td></tr>

</table>
</div>

</div>




<div>
<?php $this->load->view('addons/footer_admin'); ?>
</div>





<?php echo minify_js('setting__permission_group', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js', 'clout.search.js', 'clout.pagination.js', 'clout.list.js', 'clout.scroller.vertical.js', 'clout.settings.js'));?>

</body>
</html>