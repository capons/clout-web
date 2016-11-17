<?php
if(!empty($savedAddresses)){
?>
<div id='address_change_msg'></div>
<table class='normal-list-table' style="border:0px; border-top: 1px solid #CCC;" data-msg='Are you sure you want to delete this address? It will no longer be available for your use in the Clout system.'>
<thead><tr><th colspan='2'>Address</th><th>Type</th></tr></thead>
<tbody>
<?php
foreach($savedAddresses AS $address){
	echo "<tr>

<td style='width:1%; border-right:0px;'><div class='list-delete-icon confirm' data-category='account' data-action='submitted' data-type='settings/a/deactivate_address' id='".$address['contact_id']."'></div></td>

<td>".$address['address_line_1'].' '.$address['address_line_2']."
<br />".$address['city']." ".$address['state']." ".$address['zipcode']." ".$address['country']."</td>

<td width='30%;'>
<select id='address_".$address['contact_id']."__addresstypes' name='address_".$address['contact_id']."__addresstypes' class='small-drop-down' style='min-width:100px; width:100%;' onChange=\"updateFieldLayer('".base_url()."account/settings/a/update_address_type/i/".$address['contact_id']."','address_".$address['contact_id']."__addresstypes','','address_change_msg','')\" />".get_option_list($this, 'addresstypes', 'select', '', array('selected'=>$address['address_type']))."</select>

</td>

</tr>";
}
?>
</tbody>
</table>
<?php 
}
else echo format_notice($this, 'WARNING: There are no additional saved addresses.');
?>