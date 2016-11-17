<table class='normal-table h4' style="width:100%;">
<tr>
	<td width='99%'>
	<?php 
	if(!empty($invites)){
		foreach($invites AS $i=>$row) echo ($i > 0? ', ': '').$row['email_address'];
	} else {
		echo format_notice($this, "ERROR: User invitations can not be resolved.");
	}?>
	</td>
	
	<td width='1%' style='vertical-align:top;'>
		<a href='javascript:;' onclick="hideLayerSet('invited_email_list')">
			<img src='<?php echo IMAGE_URL.'remove_icon.png';?>' border='0' />
		</a>
	</td>
</tr>
</table>