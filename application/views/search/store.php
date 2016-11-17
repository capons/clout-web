<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": Store Details";?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.scroller.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.donut-chart.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.search.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.list.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.date-picker.css" type="text/css" media="screen">
    <style type="text/css">
		#page1 {
			position: relative;
		}
	</style>
</head>

<body onload="repositionScoreCell()">

<!-- First Page -->
<div id="page1" class="fill">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', array('__page'=>'search_home', 'area'=>'shopper')); 
# Header content
$this->load->view('addons/header_shopper', array('__page'=>'store_details'));
?>
</div>

<div class="menu-gap" style="position:absolute;top:0; width:100%;">
<table style="width:100%; border:0">
<?php $this->load->view('search/search_header', array('page'=>'store')); ?>



<tr><td style='padding: 15px; padding-bottom: 3px;' id='searchpagetitle'><a href="javascript:;" onclick="reloadSearchList('<?php  echo base_url().'search/home';?>','<?php 
if($this->native_session->get('search_phrase')) echo $this->native_session->get('search_phrase');?>','<?php 
if($this->native_session->get('location_phrase')) echo $this->native_session->get('location_phrase');?>','<?php 
if($this->native_session->get('order_phrase')) echo $this->native_session->get('order_phrase');?>')">Search</a> /  <?php echo strtoupper($storeDetails['storeName']);?><div id='searchresultsmapdiv' style="width:100%;display:none;"></div></td></tr>


<tr><td style="width:100%;">
<div id='searchresultsmapdiv' style="min-height:500px;width:100%; display:none;"></div>
<div id='searchresultsdiv' class="search-wrapper continous-scroll" data-page='1' data-noperpage='20' data-url='<?php echo base_url().'lists/load/t/store_suggestions_list';?>' 
data-fields='search__storesearch=phrase|search__placesearch=location|search__order=order|suggestionid=suggestionId|suggestiontype=suggestionType'>
<table style="width:100%; border:0">
<tr><td>
<?php 
if(!empty($storeDetails['photos'])) {
	echo "<table border='0' cellspacing='0' cellpadding='0' id='album-table' style='display:none; position:relative;'>
		<tr><td><div class='back-btn'>&nbsp;</div></td>
		<td><div class='scroller-outer'><div class='scroller-inner photos'>";

	foreach($storeDetails['photos'] AS $row) echo "<div class='shadowbox' style='background: url(".$row['photo'].") no-repeat center center rgba(255,255,255,.99); background-size:cover;' data-id='".$row['id']."' data-url='".base_url().'page/view_photo/p/'.encrypt_value($row['photo'])."'></div>"; 

	echo "</div></div></td>
		<td><div class='next-btn active'>&nbsp;</div></td></tr>
	</table>";
}
?>
<div class='large-banner' style="<?php echo (!empty($storeDetails['largeBanner'])? "background: url(".base_url()."assets/uploads/".$storeDetails['largeBanner'].") no-repeat center center": "background-color: #F1F1F1; min-height:120px;");?>">
<div class='banner-bottom-div' style="padding-bottom:50px;">
<table><tr>

<td width="99%"><span class='h2'><?php echo strtoupper($storeDetails['storeName']);?></span>
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
<td><div class='add-review-icon shadowbox' data-url='<?php echo base_url()."search/add_review/s/".format_id($this->native_session->get('__store_id')).'/r/'.(!empty($storeDetails['reviewCount'])? $storeDetails['reviewCount']: '0').'/c/'.format_number($storeDetails['averageReviewScore'],5,0);?>'>Reviews</div></td>
<td><div class='add-photo-icon shadowbox' data-url='<?php echo base_url()."search/add_photo/s/".format_id($this->native_session->get('__store_id'));?>'>Add Photo</div></td>
<td class='score-cell'><div class='score-square ribbon-square'><span class='score'><?php echo format_number($storeScoreDetails['store_score'],4,0);?></span><span class='score-label'>Store Score</span></div></td>

<td><div class='add-checkin-icon' data-id='<?php echo $this->native_session->get('__store_id');?>'>Check In</div></td><td><div data-id='<?php echo $this->native_session->get('__store_id');?>' class='add-favorite-icon <?php echo ($storeDetails['isFavorite'] != 'Y'? ' greyicon': '');?>'>Favorite</div></td>
</tr></table></div>
</td></tr>









<?php if(!empty($storeDetails['transactionStats']['lifeTimeSpendingTransactions']) 
|| !empty($storeDetails['transactionStats']['daysSinceLastTransaction'])
|| !empty($storeDetails['transactionStats']['availableRewards'])
|| !empty($storeDetails['transactionStats']['pendingRewards'])){?>
<tr><td class="search-wrapper">
<div class='details-box window-span menu-gap no-top'><table style="border-left:0px;border-right:0px;">
<tr><td>&nbsp;</td></tr>
<tr><td class='horizontal-note-divs' style="padding:15px 0px 0px 15px;">
<?php
echo "<div><table><tr><td>Lifetime Spending</td><td>(".$storeDetails['transactionStats']['lifeTimeSpendingTransactions'].")</td></tr><tr><td colspan='2' class='medium-grey'>$".format_number($storeDetails['transactionStats']['lifeTimeSpendingAmount'],3,2)."</td></tr></table></div>

<div><table><tr><td>Last Transaction</td><td>-".$storeDetails['transactionStats']['daysSinceLastTransaction']."d</td></tr><tr><td colspan='2' class='medium-grey'>$".format_number($storeDetails['transactionStats']['lastTransactionAmount'],3,2)."</td></tr></table></div>

<div><table><tr><td>Available Rewards</td><td>(".$storeDetails['transactionStats']['availableRewards'].")</td></tr><tr><td colspan='2' class='green'>$".format_number($storeDetails['transactionStats']['availableRewardAmount'],3,2)."</td></tr></table></div>

<div><table><tr><td>Pending Rewards</td><td>(".$storeDetails['transactionStats']['pendingRewards'].")</td></tr><tr><td colspan='2' class='medium-grey'>$".format_number($storeDetails['transactionStats']['pendingRewardAmount'],3,2)."</td></tr></table></div>";
?>
</td></tr>
</table>
</div>
</td></tr>
<?php 
$hasSpendingSummary = 'Y';
}
?>




<tr><td class="search-wrapper<?php if(empty($hasSpendingSummary)) echo ' menu-gap';?>">


<div class='details-box'>
<table>
<tr><td>Offers</td></tr>
<tr><td class='bottom-border-light-grey'><div id='store_offers_div'><?php $this->load->view('search/store_offer_details', array('storeScoreDetails'=>$storeScoreDetails, 'offers'=>$storeDetails['offers'], 'isOnVip'=>$storeDetails['isOnVip'], 
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
  <td><table class='score-header-ribbon'><tr><td class='cell-header'>Level <?php echo $storeScoreDetails['store_score_level'];?></td>
<td rowspan="2" class="score-cell"><div id="donutchart">&nbsp;</div>
<div id="donutchartskeleton">&nbsp;</div>
<div id="donutcharttext"><div><span class='score'><?php echo format_number($storeScoreDetails['store_score'],5,0);?></span><span class='score-label'>Store Score</span></div></div>
<div id="donutchartsmall"><span class='score'><?php echo format_number($storeScoreDetails['store_score'],5,0);?></span><span class='score-label'>Store Score</span></div></td>
<td class='cell-header'>Raise Score</td>
</tr>
      <tr>
        <td class='cell-body'><?php 
		if($storeScoreDetails['points_to_next_level'] > 0){
			echo format_number($storeScoreDetails['points_to_next_level'],5,0)." more points to reach Level ".($storeScoreDetails['store_score_level']+1)." rewards.";
		} else {
			echo "You have the maximum allowable level at this store.";
		}
		?></td>
        <td class='cell-body'>Click below to see how your score is calculated.</td>
      </tr>
  </table></td></tr>

<tr><td><div id='store_score_div'><?php $this->load->view('search/store_score_details', $storeScoreDetails);?></div></td></tr>
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





<?php $this->load->view('addons/footer_shopper', array('__page'=>'store_details')); ?>
</div>





<?php echo minify_js('search__store', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'sessionstorage.min.js', 'jquery-ui.js', 'jquery-ui-timepicker-addon.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js', 'clout.scroller.js', 'clout.scroller.vertical.js', 'clout.search.js', 'clout.scroller.horizontal.js'));?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]}); 
      google.setOnLoadCallback(drawChart);
      
	  
	  function drawChart() {
        var data1 = google.visualization.arrayToDataTable([
          ['Clout', 'Score'],
          ['', <?php echo ($storeScoreDetails['store_score'] > 1000)? 1000: $storeScoreDetails['store_score'];?>],
          ['', <?php echo (1000 - ($storeScoreDetails['store_score'] > 1000? 1000: $storeScoreDetails['store_score']));?>]
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


</script>	

</body>
</html>