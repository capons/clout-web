<table>
<?php
if(!empty($linkList)){
	foreach($linkList AS $row){
		echo "<tr>
			<td><a href='".$row['link']."' target='_blank'>".$row['link_text']."</a></td>
			</tr>";
	}
}

if(!empty($msg))
{
	echo "<tr><td>".format_notice($this,$msg)."</td></tr>";
}
?>
</table>