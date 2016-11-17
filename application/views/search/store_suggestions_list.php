<?php
if(!empty($suggestionList))
{
	$rowCount = count($suggestionList);
	$i = 0;
	foreach($suggestionList AS $row)
	{
		$i++;
		echo "<div id='".$row['store_id']."' class='store-item btndiv' data-url='search/store/id/".format_id($row['store_id'])."'>
<table>
<tr><td colspan='2' style='background: url(".API_S3_URL.(url_exists(API_S3_URL.'banner_'.$row['store_id'].'.png')? 'banner_'.$row['store_id'].'.png': 'default_small_banner.png').") no-repeat center center'><div class='score-wrapper'><div>".format_number($row['store_score'],4,0)."</div><div>$".format_number($row['store_earnings'])." Earned</div></div></td></tr>
				
<tr><td>
<div style='display:table;'>
".($row['has_shopped_here'] == 'Y'? "<div style='width:1%;margin-right:5px;display:table-cell;' title='You have shopped at this store before.'><img src='".base_url()."assets/images/tick.png' border='0' /></div>": '')."

<div style='margin-right:5px;display:table-cell;'><span class='h3'>".strtoupper(limit_string_length($row['name'], 25))."</span></div>
</div>
<span class='h4'>".($row['is_featured']=='Y'? "<b>Sponsored</b>".(!empty($row['search_category'])? ', ': ''): '').limit_string_length($row['search_category'], 20)."</span></td>
<td><span class='h4 distance-box'>".format_number($row['distance'],3,1)."mi</span>
<div class='reward-wrapper'>"
.($row['has_perk'] == 'Y'? "<div class='perk'><span>Perk</span></div>": '')
.(!empty($row['max_cashback'])? "<div class='cashback'><span>".($row['max_cashback'] != $row['min_cashback']? ($row['min_cashback'].'-'.$row['max_cashback']): $row['max_cashback'])."%</span></div>": '')
."</div></td>
</tr>
</table>
</div>";

		# Continuous scroll target
		if($i == $rowCount) echo "<button id='scrolltarget' class='btn blue load-on-click' style='width:100%'>Load Next List</button>";
	}	
}



# No stores left to show
else {
	echo "<table class='msg' style='width:100%;'><tr><td>".format_notice($this, 'WARNING: There are no more stores in this list.')."</td></tr></table>";
}
?>