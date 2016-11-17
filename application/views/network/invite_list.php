<table class='normal-table' style="width:100%;">
<?php
$stopHtml = "<input name='paginationdiv__networksearch_stop' id='paginationdiv__networksearch_stop' type='hidden' value='1' />";


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
		  <div style='display:inline-block; vertical-align:top; padding-left:10px; padding-top:10px;'><span style='font-weight:bold;'>".$row['name']."</span><br>
<span class='smalltxt'>".$row['email_address']."</span></div>
<br>
<div class='show-on-mobile' style='padding-left:10px;'><span style='font-weight:bold;'>Status</span>
<br><span>".format_status($row['invitation_status'])."</span></div>

</td>
          
          <td class='hide-on-mobile' style='width:50px;'>".format_status($row['invitation_status']);
		 
		 # Check whether you need to stop the loading of the next pages
		if($i == $listCount && ((!empty($n) && $listCount < $n) || (empty($n) && $listCount < 5))){
		 echo $stopHtml;
		}
		  echo "</td>
        </tr>";
	   }
}
else {
	echo "<tr><td>".format_notice($this, "WARNING: There are no more invitations by this user.").$stopHtml."</td></tr>";
}
?></table>