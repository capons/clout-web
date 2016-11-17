<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITE_TITLE.": Users";?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowpage.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.list.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.pagination.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">
    <style>
		#page1 {
			position: relative;
		}

		.search-block {
			vertical-align: top;
		}
		.continous-scroll {
			overflow-y: auto; 
			overflow-x: auto; 
			-ms-overflow: auto; 
		}
	</style>
</head>

<body>

<!-- First Page -->
<div id="page1" class="menu-gap">

<div class="navbar navbar-fixed-top">
<?php 
$page = $this->native_session->get('__user_category').'_users';
$title = ucwords(str_replace('_', ' ', $this->native_session->get('__user_category'))).' Users';

# Vertical menu content
$this->load->view('addons/vertical_menu', array('__page'=>$page, 'area'=>'administrator')); 
# Header content
$this->load->view('addons/header_admin', array('__page'=>$page, 'title'=>$title));
?>
</div>





<div class="search-block">
<table>
<tr><td>
<table class='list-scope microform ignoreclear'>
<tr><td style="width:1%;"><div id='user_list_views' class='sideways-drop-down' data-url='user/list_views' data-type='profile' data-target='usersearchdiv' data-fields='user_list_views__selected=view|usersearch=phrase|userlistids=listids'><div class='previous'></div><div class='list'>Profile</div><div class='next'></div></div>
<input type='hidden' id='user_list_views__list' name='user_list_views__list' value='Profile|Network|Activity|Money|Clout Score' />
<input type='hidden' id='user_list_views__selected' name='user_list_views__selected' value='profile' /></td>
<td style="width:96%;"><input type="text" id="usersearch" data-type="changes" name="usersearch" class='optional submit-on-enter' data-targetbtn='usersearchbtn' placeholder="Search.." style="width:100%;" value=""/>
<input type='hidden' id='resultsdiv' name='resultsdiv' value='usersearchdiv' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Loading results that meet your search criteria..' />
<input type='hidden' id='action' name='action' value='<?php echo base_url()."lists/load/t/user_list/n/20/f/search";?>' /></td>
<td style="width:1%;"><button id='usersearchbtn' name='usersearchbtn' class='btn green submitmicrobtn' style="min-width:50px;">GO</button></td>
<td style="padding-left:20px;width:1%;"><div id='user_tags' class='tag-list-btn list-actions' data-url='user/list_tags' data-width='300' data-targetdiv='usersearchdiv'><div>&nbsp;</div><div>&nbsp;</div></div></td>
<td style="width:1%;"><div id='user_actions' class='actions-list-btn list-actions' data-url='user/list_actions' data-width='300' data-targetdiv='usersearchdiv'><div>&nbsp;</div><div>&nbsp;</div></div></td>
</tr>
</table>
</td></tr>


<tr><td><div id='usersearchdiv' class='search-list-div continous-scroll' data-type='user_list' data-page='1' data-noperpage='20' data-url='<?php echo base_url().'lists/load/t/user_list';?>' data-fields='user_list_views__selected=view|usersearch=phrase|userlistids=listids'>

<?php $this->load->view('user/user_list_container', array('userList'=>$userList, 'viewToLoad'=>'profile'));?>
</div></td></tr>

</table>
</div>

</div>




<div>
<?php $this->load->view('addons/footer_admin'); ?>
</div>





<?php echo minify_js('user__user_dashboard', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js', 'clout.shadowpage.js', 'clout.search.js', 'clout.pagination.js', 'clout.list.js', 'clout.scroller.vertical.js', 'trumbowyg.js'));?>

<script>
$(function() {
	resizeScrollDiv();
	$(window).resize(function(e) { resizeScrollDiv(); });
});

function resizeScrollDiv(){
	$('.continous-scroll').width($(window).width());
	$('.continous-scroll').height($(window).height() - 120);
}
</script>
</body>
</html>