<table>
<tr><td class="sub-list-header">Select a score section to edit its settings</td></tr>
<tbody>
<?php 
if(!empty($scoreSettingsList['list']) && !empty($scoreSettingsList['totals']))
{
	$count = 0;
	foreach($scoreSettingsList['list'] AS $category=>$settings){
		$html = "";
		if(!empty($settings)){
			$count++;
			$html .= "<tr>
		<td>
		<div class='accordion-row'><div><table width='100%'><tr><td>".$count.'. '.ucwords(str_replace('_', ' ', $category))."</td><td style='text-align:right;'>".(!empty($scoreSettingsList['totals'][$category])? $scoreSettingsList['totals'][$category]: 0)."</td></tr></table></div>
		<div>";
		
		$html .= "<table class='normal-list-table' style='border: 0px;'>
		<thead><tr><th>Title</th><th>Description</th><th>Setting Code</th><th>Criteria</th><th>Min Score</th><th>Max Score</th></tr></thead>";
		
		$subCount=0;
		foreach($settings AS $row){
			$subCount++;
			
			$html .= "<tr>
			<td>".$count.'.'.$subCount.' '.$row['name']."</td>
			<td>".$row['description']."</td>
			<td>".$row['code']."</td>
			<td>".$row['criteria']."</td>
			
			<td><a data-id='edit_min_".$row['id']."' class='edit-in-line' data-actionurl='setting/update_score_value/t/min/v/".$row['min_score']."/d/".$row['id']."' title='Click to edit'  href='javascript:;'/>".$row['min_score']."</a></td>
			
			<td><a data-id='edit_max_".$row['id']."' class='edit-in-line' data-actionurl='setting/update_score_value/t/max/v/".$row['max_score']."/d/".$row['id']."' title='Click to edit' href='javascript:;' />".$row['max_score']."</a></td>
			
			</tr>";
		}
		
		$html .= "</table></div>
		</div></td>
		</tr>";
		}
		
		echo $html;
	}
	
	
}?>

</tbody>
</table>
