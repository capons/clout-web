<?php 
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html lang=\"en\">
<head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Details</title>";

$cssList = array('external-fonts.css','clout.css','clout.list.css','clout.shadowpage.css');
if(!empty($css)) $cssList = array_unique(array_merge($cssList, $css));

foreach($cssList AS $cssFile){
	echo "<link rel='stylesheet' href='".base_url()."assets/css/".$cssFile."' type='text/css' media='screen' />";
}

echo "</head>
<body>"; 

echo "<table class='default-table' style='width:100%;border-collapse: collapse;'>
<tr><td>
<table class='shadowpage-header'>
<tr>";

if(!empty($icon_url)) echo "<td class='user-icon' style='background: url(".$icon_url.") no-repeat center top;'>&nbsp;</td>";

echo "<td class='title'>".$title."</td>
<td style='text-align:center;'><img src='".IMAGE_URL."logo.png' border='0' /></td>";

if(!empty($sub_title)) echo "<td class='title'>".$sub_title."</td>";

echo "<td id='__shadowpage_closer'>&nbsp;</td>
</tr>
</table>

</td></tr>
<tr><td>
<div class='shadowpage-container'>";
?>
