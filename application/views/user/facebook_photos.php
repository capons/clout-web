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

echo "</head>"; 

?>

<body onload="onScrollableImageLoad();">
	<div class="view-scrollable-image-container">
        <div class="view-scrollable-images" data-size="inherit">
        	<div class="view-btn-left"></div>
            <?php 
			/*
			 * Dynamically display the photos
			 */
			if(!empty($photos)){
				echo '<div class="scrollable-image active" data-index="0" style="background-image: url(\''.$photos[0].'\')"></div>';
				for ($x = 1; $x < count($photos); $x++) {				
					echo '<div class="scrollable-image inactive" rel="'.$photos[$x].'" data-index="'.$x.'" style="background-image: url(\''.$photos[$x].'\')"></div>';
				}
			}
			?>            
            <div class="view-btn-right"></div>
        </div>
    </div>


<?php
echo "</div>
</td></tr>
</table>";

$jsList = array('jquery-2.1.1.min.js', 'clout.js', 'clout.shadowpage.js', 'clout.fileform.js', 'clout.popup.js');
if(!empty($js)) $jsList = array_unique(array_merge($jsList, $js));

echo  minify_js(!empty($page)? 'user__'.$page: 'addons__shadow_page_footer', $jsList)."

<script>
$(function() {
	$('.shadowpage-container').width($(window).width());
});
</script>


<input type='hidden' name='layerid' id='layerid' value=''>
</body>
</html>
";
?>