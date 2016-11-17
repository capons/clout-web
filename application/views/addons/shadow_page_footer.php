<?php
echo "</div>
</td></tr>
</table>";

$jsList = array('jquery-2.1.1.min.js', 'clout.js', 'clout.shadowpage.js', 'clout.fileform.js', 'clout.popup.js', 'clout.shadowbox.js');
if(!empty($js)) $jsList = array_unique(array_merge($jsList, $js));

echo  minify_js(!empty($page)? $page: 'addons__shadow_page_footer', $jsList)."

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