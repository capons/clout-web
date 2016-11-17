<?php 
if(!empty($storeList))
{?>
<table style='width:100%;'>
<tr>
<td class='instruction-row'>
<?php if(!empty($displayArea) && $displayArea == 'google_search'){?>
Select the results that match your Google search to add them to this store's reference links.
<?php } else {?>
Check off the results that match your transaction to add them to the matched store list, or search again..
<?php }?>
</td>
</tr>




<tr>
<td>
<table class='normal-table'>
<?php
foreach($storeList AS $row)
{

if(!empty($displayArea) && $displayArea == 'google_search')
{
	echo "<tr data-value='".$row['link_id']."' data-categoryid='".$descriptorId."' data-type='location' class='add-store-link'>
<td width='1%' style='vertical-align:top;'><input type='checkbox' id='store_".$descriptorId."_".$row['link_id']."' name='stores_".$descriptorId."[]' value='".$row['link_id']."' /></td>
<td>".html_entity_decode($row['link_description'], ENT_QUOTES)."<br>
<div class='data-cell'><a href='".$row['link']."' target='_blank'>".html_entity_decode($row['link_text'], ENT_QUOTES)."</a></div></td>
</tr>";
	
} else {
	echo "<tr data-value='".$row['store_id']."' data-categoryid='".$descriptorId."' data-type='location' class='add-to-this-table'>
<td width='1%'><input type='checkbox' id='store_".$descriptorId."_".$row['store_id']."' name='stores_".$descriptorId."[]' value='".$row['store_id']."' /></td>
<td class='data-cell'>".html_entity_decode($row['store_name'], ENT_QUOTES)." | ".html_entity_decode($row['address'], ENT_QUOTES)."</td>
</tr>";
}

}
?>
</table>

</td>
</tr>
</table>
 
 
 <?php 
}
 
else {
	echo "<table style='width:100%;'><tr><td>".
	format_notice($this, "WARNING: No more stores meet the search details provided.").
	"</td></tr></table>"; 
}?>