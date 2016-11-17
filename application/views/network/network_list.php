<table class='normal-table' style="width:100%;">
<?php
$stopHtml = "<input name='paginationdiv__network_stop' id='paginationdiv__network_stop' type='hidden' value='1' />";


if(!empty($networkList))
{
	   $listCount = count($networkList);
	   $i = 0;
	   foreach($networkList AS $row)
	   {
           $i++;
		   echo "<tr ".($i%2 == 1? " style='background-color:#FFF;'": "").">
          <td>
		  <div class='circular' style='background: url(".(base_url()."assets/uploads/".(!empty($row['photo_url'])? $row['photo_url']: 'public_user_icon.png')).") no-repeat; display:inline-block;'></div>
		  <div style='display:inline-block; vertical-align:top; padding-left:10px; padding-top:10px;'><span style='font-weight:bold;'>".$row['name']."</span>".($row['has_linked_card'] == 'Y'? "<span class='correct-box'>Linked</span>": "<span class='wrong-box'>Not Linked</span>")."<br>
<span class='smalltxt'>".$row['email_address'].(!empty($row['telephone'])? ', '.format_telephone($row['telephone']): '')."</span></div>
</td>
          <td style='width:100px;'>".(!empty($row['last_activity_date'])? format_date_interval($row['last_activity_date'], '', FALSE, 'years'): 'never')."</td>
          <td style='width:60px;'>".format_number($row['total_network'],6)."</td>
          <td style='width:50px;'>".format_number($row['total_invites'],6);
		 
		 # Check whether you need to stop the loading of the next pages
		if($i == $listCount && ((!empty($n) && $listCount < $n) || (empty($n) && $listCount < 5))){
		 echo $stopHtml;
		}
		  echo "</td>
        </tr>";
	   }
}
else {
	echo "<tr><td>".format_notice($this, "WARNING: There are no more referred members for this user.").$stopHtml."</td></tr>";
}
?></table>