<?php
# showing a sub-view of the list action
if(!empty($list)){
	foreach($list AS $row){
		echo "<div data-url='".base_url()."message/".$row['action']."'>".$row['display']."</div>";
	}
}
?>