<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
	<title><?php echo SITE_TITLE.": Store Details";?></title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.scroller.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.donut-chart.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.search.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.list.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.date-picker.css" type="text/css" media="screen" />
</head>

<body onload="repositionScoreCell();">

<?php $storeDetails['isOnVip'] = false;?>

<!-- First Page -->
<div id="page1" class="fill">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', array('__page'=>'public_store', 'area'=>'shopper')); 
if(empty($this->native_session->get('__user_id'))){
	# Header content
	$this->load->view('addons/header_public', array('signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
}
else {
	# Header content
	$this->load->view('addons/header_shopper', array('__page'=>'store_details'));
}
?>
</div>

<div class="menu-gap" style="position:absolute;top:0; width:100%;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php $this->load->view('search/search_header', array('page'=>'store')); ?>



<tr><td style='padding: 15px; padding-bottom: 3px;' id='searchpagetitle'><a href="javascript:;" onclick="reloadSearchList('<?php  echo base_url().'search/home';?>','<?php 
if($this->native_session->get('search_phrase')) echo $this->native_session->get('search_phrase');?>','<?php 
if($this->native_session->get('location_phrase')) echo $this->native_session->get('location_phrase');?>','<?php 
if($this->native_session->get('order_phrase')) echo $this->native_session->get('order_phrase');?>')">Search</a> /  <?php echo $storeDetails['storeName'];?><div id='searchresultsmapdiv' style="width:100%;display:none;"></div></td></tr>


<tr><td style="width:100%;"><div id='searchresultsdiv' class="search-wrapper continous-scroll" data-page='1' data-noperpage='20' data-url='<?php echo base_url().'lists/load/t/store_suggestions_list';?>' 
data-fields='search__storesearch=phrase|search__placesearch=location|search__order=order|suggestionid=suggestionId|suggestiontype=suggestionType'>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td>
<?php 
if(!empty($storeDetails['photos'])) {
	echo "<table border='0' cellspacing='0' cellpadding='0' id='album-table' style='display:none; position:relative;'>
		<tr><td><div class='back-btn'>&nbsp;</div></td>
		<td><div class='scroller-outer'><div class='scroller-inner photos'>";

	foreach($storeDetails['photos'] AS $row) echo "<div class='shadowbox' style='background: url(".$row['photo'].") no-repeat center center rgba(255,255,255,.99); background-size:cover;' data-id='".$row['id']."'></div>"; 

	echo "</div></div></td>
		<td><div class='next-btn active'>&nbsp;</div></td></tr>
	</table>";
}
?>
<div class='large-banner' style="<?php echo (!empty($storeDetails['largeBanner'])? "background: url(".base_url()."assets/uploads/".$storeDetails['largeBanner'].") no-repeat center center": "background-color: #F1F1F1; min-height:120px;");?>">
<div class='banner-bottom-div' style="padding-bottom:50px;">
<table><tr>

<td width="99%"><span class='h2'><?php echo $storeDetails['storeName'];?></span>
<br /><span><?php echo $storeDetails['category'];?> &nbsp;  &nbsp;  &nbsp; <?php echo format_number($storeDetails['distance'],3,1).'mi';?></span></td>

<td width="1%"><div class="reward-wrapper bigger"><?php
if($storeDetails['hasPerk'] == 'Y') echo "<div class='perk'><span>Perk</span></div>";
if(!empty($storeDetails['maxCashBack'])) echo "<div class='cashback'><span>".($storeDetails['maxCashBack'] != $storeDetails['minCashBack']? $storeDetails['minCashBack'].'-'.$storeDetails['maxCashBack']: $storeDetails['maxCashBack'])."%</span></div>";
?></div></td>
<?php 
if(!empty($storeDetails['photos'])) {	
	echo "<td style='padding-left:5px;'>
	<div class='photo-album-icon' style='z-index:1000;' onclick=\"toggleLayersOnCondition('album-table', 'album-table')\">&nbsp;</div>
	</td>";
}?>
</tr></table>
</div></div>
</td></tr>

<tr><td>
<div class="header-ribbon"><table><tr>
<td><div class='add-review-icon'>Reviews</div></td>
<td><div class='add-photo-icon'>Add Photo</div></td>
<td class='score-cell'><div class='score-square ribbon-square'><span class='score'>0</span><span class='score-label'>Store Score</span></div></td>
<td><div class='checkin-icon'>Check In</div></td><td><div class='favorite-icon greyicon'>Favorite</div></td>
</tr></table></div>
</td></tr>








<tr><td class="search-wrapper">
<div class='details-box window-span menu-gap no-top'><!-- div style="text-align:center; font-color: black;font-size:25pt;">Signup to see your spending</div -->
<!-- 
<table style="border-left:0px;border-right:0px;">
<tr><td>&nbsp;</td></tr>
<tr><td class='horizontal-note-divs' style="padding:15px 0px 0px 15px;">
<div><table><tr><td>Lifetime Spending</td><td><?php echo rand(10,100); ?></td></tr><tr><td colspan='2' class='medium-grey'>$<?php echo format_number(rand(10,100), 2);?></td></tr></table></div>
<div><table><tr><td>Last Transaction</td><td>-<?php echo rand(10,100); ?>d</td></tr><tr><td colspan='2' class='medium-grey'>$<?php echo format_number(rand(10,100), 2);?></td></tr></table></div>
<div><table><tr><td>Available Rewards</td><td><?php echo rand(10,100); ?></td></tr><tr><td colspan='2' class='green'>$<?php echo format_number(rand(10,100), 2);?></td></tr></table></div>
<div><table><tr><td>Pending Rewards</td><td><?php echo rand(10,100); ?></td></tr><tr><td colspan='2' class='medium-grey'>$<?php echo format_number(rand(10,100), 2);?></td></tr></table></div>
</td></tr>
</table>
 -->
</div>
</td></tr>
<?php 
$hasSpendingSummary = 'Y';
?>




<tr><td class="search-wrapper<?php if(empty($hasSpendingSummary)) echo ' menu-gap';?>">


<div class='details-box'>
<table>

<!-- Why when I favorite a store without logging in, the store detail is returning isOnVip = true.  Is the store on the VIP list or the user is on the VIP list? -->
<tr><td>Offers</td></tr>
<tr><td class='bottom-border-light-grey'><div id='store_offers_div'><?php $this->load->view('search/public_store_offer_details', array('storeScoreDetails'=>$storeScoreDetails, 'offers'=>$storeDetails['offers'], 'isOnVip'=>$storeDetails['isOnVip'], 
'hasRemainingPoints'=>(!empty($storeDetails['offers']['cashback']) || !empty($storeDetails['offers']['perk'])? 'Y': 'N')
)); ?></div></td></tr>

<tr><td class="bottom-border-light-grey" style="padding:0px;margin:0px;"><?php 
$longLatValues = !empty($storeDetails['longitude'])? array('longitude'=>$storeDetails['longitude'], 'latitude'=>$storeDetails['latitude']): array();
if(!empty($longLatValues))
{
	$this->load->view('search/map_location_view', array('name'=>$storeDetails['storeName'], 'location'=>$longLatValues));
}?></td></tr>


<tr><td style="padding: 0px;">
<table class='details-table' style="width:100%;">
<tr><td class='location-icon shadowbox closable bottom-border-light-grey map_direction_launcher' style='cursor:pointer;' <?php echo !empty($storeDetails['address'])? " data-url='".base_url()."search/map_to_location/a/".encrypt_value($storeDetails['address'])."'": "";?> ><?php echo !empty($storeDetails['address'])? $storeDetails['address']: 'No address resolved';?></td></tr>


<?php if(!empty($storeDetails['hours']) || !empty($storeDetails['description'])){?>
<tr>
<td class="row-table-cells table-2-cols"><div class='hours-icon'><span class='sub-header'>Hours</span>
<?php
if(!empty($storeDetails['hours'])){
	echo "<table class='vertical-list'>";
	foreach($storeDetails['hours'] AS $hour) echo "<tr><td>".ucfirst(substr($hour['day'],0,3))."</td><td>".($hour['start'] != 'any'? $hour['start'].' - '.$hour['end']: '24 Hours')."</td></tr>";
	echo "</table>";
}
else echo "Contact store for schedule";
?>
</div>

<div class='description-icon'>
<span class='sub-header'>Description</span>
<?php echo (!empty($storeDetails['description'])? $storeDetails['description']: 'None');?>
</div>

</td>
</tr>
<?php }?>



<?php if(!empty($storeDetails['features'])) {?>
<tr><td class='features-icon'>
<span class='sub-header'>Features &amp; Amenities</span>
<?php 
$features = array();
foreach($storeDetails['features'] AS $row) array_push($features, $row['feature']);
echo implode(", ", $features);
?></td></tr>
<?php }?>




<tr><td class='row-divs'><div class='website-icon half-width'><?php $website = limit_string_length($storeDetails['website'],25);
echo "<a href='".(substr($storeDetails['website'], 0,4) !='http'? 'http://': '').$storeDetails['website']."' target='_blank'>".$website."</a>";
?></div><div class='telephone-icon half-width'><?php echo format_telephone($storeDetails['telephone']);?></div>
</td></tr>

<tr><td>


<table <?php 
echo !empty($storeDetails['reviewCount'])? " class='review-table shadowbox'  data-url='".base_url()."search/add_review/s/".format_id($this->native_session->get('__store_id')).'/r/'.(!empty($storeDetails['reviewCount'])? $storeDetails['reviewCount']: '0').'/c/'.format_number($storeDetails['averageReviewScore'],5,0)."/a/view'": " class='review-table'";
?>><tr>
<td><div class='review-container fill-<?php echo format_number($storeDetails['averageReviewScore'],5,0);?>'><div></div><div></div></div></td><td><?php 
echo (!empty($storeDetails['reviewCount'])? $storeDetails['reviewCount']: '0'); 
echo " Review";
echo (!empty($storeDetails['reviewCount']) && $storeDetails['reviewCount'] == 1? '': 's');
?></td></tr>
</table>

</td></tr>
</table>

</td></tr>

</table>
</div>




<div class='details-box'>
<table>
<tr><td>Score</td></tr>
<tr><td>
<table>
<tr>
  <td><table class='score-header-ribbon'><tr><td class='cell-header'>Level <?php echo $storeScoreDetails['storeId'] * 2;?></td>
<td rowspan="2" class="score-cell"><div id="donutchart">&nbsp;</div>
<div id="donutchartskeleton">&nbsp;</div>
<div id="donutcharttext"><div><span class='score'><?php echo $storeScoreDetails['storeId'] * 100;?></span><span class='score-label'>Store Score</span></div></div>
<div id="donutchartsmall"><span class='score'><?php echo $storeScoreDetails['storeId'] * 100;?></span><span class='score-label'>Store Score</span></div></td>
<td class='cell-header'>Raise Score</td>
</tr>
      <tr>
        <td class='cell-body'><?php 
			echo $storeScoreDetails['storeId'] * 20 . " more points to reach Level 10 rewards.";
		?></td>
        <td class='cell-body'>Click below to see how your score is calculated.</td>
      </tr>
  </table></td></tr>

<tr><td><div id='store_score_div'><?php $this->load->view('search/public_store_score_details', array());?></div></td></tr>
</table>
</td></tr>
</table>
</div>


</td></tr>

<!-- Make sure the bottom part is shown above the bottom menu -->
<tr><td style='height:80px;'></td></tr>


</table>
</div>



</table>
</div>

<style>

.slide-up-signup {
	background-color:#d3d3d3;
	position:fixed;
	left:0;
	bottom:0;
	width:100%;
	padding:0px;
	margin:0px;
	opacity:0.9;
	z-index: 100;
	display:none;
}
</style>


<!-- display:none; Height is percentage of total page, width is full page, opacity is .5 -->
<div id="slide-up-signup" class="slide-up-signup center-block">
	<div class="one-column-table" style="background-color:white;">
		<table>
		<tr><td><p style="font-weight:bold;font-size: 12pt;"><?php echo $cloutMsg1; ?></p></td></tr>
		<tr><td><p style="font-size: 10pt;"><?php echo $cloutMsg2; ?></p></td></tr>
		<tr><td class="row-cells-2" >
		<div>
		<form>
		<button type="button" id="submitsignup" data-url="account/sign_up" name="submitsignup" class="btn blue" style="width:100%;"><?php echo $signUpBtnLabel; ?></button>
		</form>
		</div>
		<div>
		<form>
		<button type="button" id="submitlogin" data-url="account/login" name="submitlogin" class="btn green" style="width:100%;"><?php echo $loginBtnLabel; ?></button>
		</form>
		</div>
		</td></tr>
		</table>
	</div>
</div>


<?php $this->load->view('addons/footer_shopper', array('__page'=>'store_details')); ?>
</div>

<div id="scrolltarget" class="load-on-scroll" style="height: 200px;">
	<div id="start"></div>
	<div id="end"></div>
</div>




<?php echo minify_js('search__public_store', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'sessionstorage.min.js', 'jquery-ui.js', 'jquery-ui-timepicker-addon.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js', 'clout.scroller.js', 'clout.scroller.vertical.js', 'clout.search.js', 'clout.scroller.horizontal.js'));?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]}); 
      google.setOnLoadCallback(drawChart);
      
	  
	  function drawChart() {
        var data1 = google.visualization.arrayToDataTable([
          ['Clout', 'Score'],
          ['', 100],
          ['', 100]
        ]);
		
		var data2 = google.visualization.arrayToDataTable([
          ['Clout', 'Score'],
          ['',  160],
          ['',  160],
		  ['',  160],
          ['',  160],
		  ['',  160]
        ]);

        var options1 = {
          pieHole: 0.7,
		  backgroundColor: 'transparent',
		  legend: 'none',
          pieSliceText: 'none',
          pieStartAngle: 180,
		  pieSliceBorderColor: '#F2F2F2',
          tooltip: { trigger: 'none' },
          slices: {
            0: { color: '#2DA0D1' },
            1: { color: '#E0E0E0' }
          },
		  chartArea: {left:0,top:0,width:"180",height:"180"}
        };
		
		var options2 = {
          pieHole: 0.7,
		  backgroundColor: 'transparent',
		  legend: 'none',
          pieSliceText: 'none',
          pieStartAngle: 180,
		  pieSliceBorderColor: '#F2F2F2',
          tooltip: { trigger: 'none' },
          slices: {
            0: { color: 'transparent' },
            1: { color: 'transparent' },
            2: { color: 'transparent' },
            3: { color: 'transparent' },
            4: { color: 'transparent' }
          },
		  chartArea: {left:0,top:0,width:"180",height:"180"}
        };

        var chart1 = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart1.draw(data1, options1);
		
		var chart2 = new google.visualization.PieChart(document.getElementById('donutchartskeleton'));
        chart2.draw(data2, options2);
		
      }
	  


$(function() {
	//Resize the map direction launcher to fit the screen size
	addDataMin();
	//Resize the offer tabs to cater for underlying table resizing
	resizeOfferTab();
	
	$(window).resize(function() { 
		addDataMin();
		resizeOfferTab();
	});
});

function addDataMin(){
	var width = $(window).width() < 500? $(window).width(): 700;
	var height = $(window).height() < 400? $(window).height(): 500;
	$('.map_direction_launcher').attr('data-minwidth', width);
	$('.map_direction_launcher').attr('data-minheight', height);
}

function resizeOfferTab(){
	if($('.innertablayer').length){
		$('.innertablayer').each(function(){
			$(this).css('min-width', $(this).parent('td').width()+30);
		});
	}
}


(function($) {
	setTimeout(function() {
		$( "#slide-up-signup" ).show("slow");
	}, 2000);
	
	$('.fill').height($('.fill').height() + 300);

	$('#submitsignup').on('click', function() {
		window.location.href = $('#submitsignup').data('url');
	});

	$('#submitlogin').on('click', function() {
		window.location.href = $('#submitlogin').data('url');
	});

	$('.shadowbox').on('click', function() {
		$('.__shadowbox').hide();
	});

	$('.add-checkin-icon').unbind('click');

})(jQuery);



</script>	


<style>
#page1 {position: relative;}
</style>
</body>
</html>