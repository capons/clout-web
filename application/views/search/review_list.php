<?php 
if(!empty($msg)) echo format_notice($this,$msg);

#Update the review count with change of review list
if(!empty($c) || !empty($r)) {
	echo "<script>document.getElementById('review_count_div').innerHTML = \"<table class='review-table'><tr><td><div class='review-container fill-".(!empty($c)? $c: '0')."'><div></div><div></div></div></td><td>".(!empty($r)? $r: '0')." Review".(!empty($r) && $r == 1? '': 's')."</td></tr></table>\";</script>";
}


if(!empty($reviews)){
	echo "<table class='normal-list-table' style='width:99%;'>";
	foreach($reviews AS $row){
		echo "<tr>
		<td style='width:1%;'><div style='background: url(".BASE_URL."assets/uploads/".(!empty($row['user_photo'])? $row['user_photo']: 'public_user_icon.png').") no-repeat center top;' class='small-user-photo'></td>
		
		<td style='width:99%;'><div class='review-container fill-".$row['score']."'><div></div><div></div></div>
		<br>
		".(!empty($row['details'])? $row['details']: '')."
		<br><span class='smalltext'><span class='bold'>".$row['user_name']."</span>, ".$row['user_location']."</span>
		</td>
		</tr>";	
	}
	echo "</table><br>";
}
else echo format_notice($this, "WARNING: There are no reviews on this store yet.");
?>