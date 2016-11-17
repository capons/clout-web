<table class="normal-list-table" data-msg='Are you sure you want to remove this rule?'>
<thead class='light-grey-bg' <?php if(empty($ruleList)) echo " style='display:none'";?>>
<tr>

<th style='width:1%;'>&nbsp;</th>
<th>Rule Type</th>
<th>Rule Name</th>
<th>Status</th>

</tr>
</thead>

<tbody>
<?php

if(!empty($ruleList))
{
	foreach($ruleList AS $row){
		echo "<tr>
		<td width='1%' id='".$row['id']."' class='list-delete-icon confirm' data-category='setting'  data-type='delete_rule' data-action='submitted' style='min-width:35px; padding-right: 10px;'>&nbsp;
		<input type='hidden' id='ruleid_".$row['id']."' name='ruleids[]' value='".$row['id']."' /></td>
		
		<td>".$row['category_display']."</td>
		<td>".$row['name']."</td>
		<td>".($row['status'] == 'active'? 'ON': 'OFF')."</td>
		</tr>";
	}
}?>

<tr class='add-more-row'>
	<td colspan='4'><div id='more_rule'>
<?php $this->load->view('setting/add_rule'); ?>
</div>
		</td> 
</tr>

</tbody>
</table>
