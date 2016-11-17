<?php
echo "<table class='normal-table'>";

if(!empty($msg)) echo "<tr><td colspan='2'>".format_notice($this,$msg)."</td></tr>"; 

echo "<tr><td>Just copy a link, share and watch your network grow</td></tr>";



if(!empty($userLinks)){
	foreach($userLinks AS $row) {
		$link = base_url().'r/'.$row['link_id'];
		echo "<tr><td><a href='".$link."' title='Copy the link or click to open in new window' target='_blank'>".$link."</a></td></tr>";
	}
} else {
	$link = base_url().'r/'.format_id($this->native_session->get('__user_id'));
	echo "<tr><td><a href='".$link."' title='Copy the link or click to open in new window' target='_blank'>".$link."</a></td></tr>";
}

if(empty($userLinks) || (!empty($userLinks) && count($userLinks) < 5)) echo "<tr><td><button id='addanotherlink' name='addanotherlink' class='btn green".(check_access($this,'can_create_custom_referral_url')? ' allow-custom': '')."' style='width:100%;'>Add Link (Up to 5)</button>
<div id='custom_link_details'></div>
</td></tr>";

echo "</table>";
?>