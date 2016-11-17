<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITE_TITLE.": Transaction Matching";?></title>
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
$this->load->view('addons/vertical_menu', array('__page'=>'transaction_matching', 'area'=>'administrator')); 
# Header content
$this->load->view('addons/header_admin', array('__page'=>'transaction_matching', 'title'=>'Transaction Matching'));
?>
</div>

<div class="search-block">
	<table>
		<tr>
			<td>
				<table class='list-scope microform ignoreclear'>
					<tr>
						<td style="width:1%;">
							<select id='searchtype__matchinglisttypes' name='searchtype__matchinglisttypes' class='drop-down go-to-selected' data-baseurl='transaction' style='min-width: 50px;'>
								<?php echo get_option_list($this, 'matchinglisttypes', 'select', '', array('selected'=>'match_by_each'));?>
							</select>
						</td>
						<td style="width:1%;">
							<select id='searchbank__topbanks' name='searchbank__topbanks' class="drop-down" style="min-width:50px;">
								<?php echo get_option_list($this, 'topbanks');?>
							</select>
						</td>
						<td style="width:1%;">
							<select id='searchstatus__matchstatus' name='searchstatus__matchstatus' class="drop-down" style="min-width:50px;">
								<?php echo get_option_list($this, 'matchstatus');?>
							</select>
						</td>
						<td style="width:1%;">
							<select id='searchadmins__admins' name='searchadmins__admins' class="drop-down" style="min-width:50px;">
								<?php echo get_option_list($this, 'admins');?>
							</select>
						</td>
						<td style="width:95%;">
							<input type="text" id="descriptorsearch" data-type="changes" name="descriptorsearch" class='optional submit-on-enter' data-targetbtn='matchsearch' placeholder="Search.." style="width:100%;" value=""/>
							<input type='hidden' id='resultsdiv' name='resultsdiv' value='descriptorsearchdiv' />
							<input type='hidden' id='tempmessage' name='tempmessage' value='Loading results that meet your search criteria..' />
							<input type='hidden' id='action' name='action' value='<?php echo base_url()."lists/load/t/transaction_list/n/20";?>' />
						</td>
						<td style="width:1%;">
							<button id='matchsearch' name='matchsearch' class='btn green submitmicrobtn' style="min-width:50px;">GO</button>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	
		<tr>
			<td>
				<div id='descriptorsearchdiv' class='search-list-div accordion-list continous-scroll' data-type='descriptor_list' 
				data-page='1' data-noperpage='20' data-url='<?php echo base_url().'lists/load/t/descriptor_list';?>' 
				data-fields='searchbank__topbanks=bankId|searchstatus__matchstatus=status|searchadmins__admins=adminId|descriptorsearch=phrase'>
		
					<?php $this->load->view('transaction/transaction_list_container', array('transactionList'=>$transactionList));?>
				</div>
			</td>
		</tr>
	</table>
</div>

</div>




<div>
<?php $this->load->view('addons/footer_admin'); ?>
</div>






<?php echo minify_js('transaction__match', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js', 'clout.search.js', 'clout.pagination.js', 'clout.list.js', 'clout.scroller.vertical.js'));?>
</body>
</html>