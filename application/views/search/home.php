<?php if(empty($msg)) $msg = get_session_msg($this);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": Search";?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.scroller.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.search.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.date-picker.css" type="text/css" media="screen">
    <style type="text/css">
		#page1 {
			position: relative;
		}
	</style>
</head>

<body onload="setUserBrowserLocation();<?php if(!empty($msg)) echo "showServerSideFadingMessage('".$msg."');"; ?>">

<!-- First Page -->
<div id="page1" class="fill">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', array('__page'=>'search_home', 'area'=>'shopper')); 
# Header content
$this->load->view('addons/header_shopper', array('__page'=>'search_home'));
?>
</div>

<div class="menu-gap" style="position:absolute;top:0; width:100%;">
<table style="width:100%; border:0">
<?php $this->load->view('search/search_header', array('page'=>'home')); ?>

<tr><td style='padding: 0px 15px 0px 15px;'><div class="h3 hide-on-tablet" style="float:left;" id='searchpagetitle'><?php echo $this->native_session->get('search_phrase')? "<a href='".base_url()."search/home'>Search</a> / ".$this->native_session->get('search_phrase'): 'Recommended for you';
?></div>
<div class="h3" style="float:right;">Sorted by <a href='javascript:;' class='drop-down-link' id='sort__searchsortoptions'><?php echo $this->native_session->get('order_phrase')? $this->native_session->get('order_phrase'): 'Recommended';?></a></div></td></tr>



<tr><td style='padding: 0px 5px 30px 5px;'><div id='searchresultsdiv' class="search-wrapper continous-scroll" data-page='1' data-noperpage='20' data-url='<?php echo base_url().'lists/load/t/store_suggestions_list';?>' 
data-fields='search__storesearch=phrase|search__placesearch=location|search__order=order|suggestionid=suggestionId|suggestiontype=suggestionType'>

<?php 
if(!empty($defaultMsg)) echo "<table class='msg' style='width:100%;'><tr><td>".format_notice($this, $defaultMsg)."</td></tr></table>";

if(!empty($suggestions)){
	$this->load->view('search/store_suggestions_list', array('suggestionList'=>$suggestions));
} 
else {
	echo "<table class='msg' style='width:100%; margin-top:15px;'><tr><td>".format_notice($this, 'WARNING: There are no suggestions at this moment.')."</td></tr></table>";
}?>
</div>
<div id='searchresultsmapdiv' style="min-height:500px;width:100%; display:none;"></div></td></tr>


</table>
</div>





<?php $this->load->view('addons/footer_shopper', array('__page'=>'search_home')); ?>
</div>




<script type="text/javascript" src="https://www.clout.com/assets/js/clout.googleanalytics.js"></script>
<?php echo minify_js('search__home', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'sessionstorage.min.js', 'jquery-ui.js', 'jquery-ui-timepicker-addon.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js', 'clout.scroller.horizontal.js', 'clout.list.js', 'clout.scroller.vertical.js', 'clout.search.js'));?>

</body>
</html>