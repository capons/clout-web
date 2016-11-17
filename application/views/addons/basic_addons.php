<?php 
$jquery = "<script src='".base_url()."assets/js/jquery-2.1.1.min.js' type='text/javascript'></script>";
$javascript = "<script type='text/javascript' src='".base_url()."assets/js/clout.js'></script>".get_ajax_constructor(TRUE); 
$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 


if(!empty($area) && $area == "show_redirect_url")
{
	$width = !empty($width)? $width: '560';
	$height = !empty($height)? $height: '315';
	
	if(!empty($url)){
		$tableHTML .= "<table width='100%' cellpadding='10' border='0' cellspacing='0' ><tr><td><iframe width=\"100%\" height=\"".$height."\" src=\"".$url."?rel=0&amp;autoplay=0&amp;modestbranding=1&amp;showinfo=0&amp;autohide=1&version=3\" frameborder=\"0\" allowfullscreen></iframe></td></tr></table>"; 

	}
	else {
		$tableHTML = format_notice('ERROR: The requested url can not be resolved.');
	}
}


else if(!empty($area) && $area == "dropdown_list")
{
	$tableHTML .= !empty($list)? $list: "";
}


else if(!empty($area) && $area == "photo")
{
	$tableHTML .= "<table width='100%' cellpadding='10' border='0' cellspacing='0' ><tr><td><img src='".decrypt_value($p)."' border='0' style='width:100%;'></td></tr></table>";
}

else if(!empty($area) && $area == "stores_on_the_map")
{
	$tableHTML .= "<iframe id=\"store_map_frame\" frameborder=\"0\" scrolling=\"no\" width=\"100%\" height=\"100%\" src=\"". base_url()."search/show_store_list_map\" onload='resizeIframe()'></iframe>";
}


else if(!empty($area) && $area == "refresh_list_msg")
{
	$tableHTML .= format_notice($this, $msg)."<br><br>
	<button type='button' id='refreshlistfromiframe' name='refreshlistfromiframe' class='btn blue' style='width:100%;' onclick='parent.location.reload();'>Refresh List</button>";
}


else if(!empty($area) && $area == "refresh_list_msg__from_shadowpage")
{
	$this->load->view('addons/shadow_page_header', array(
	'title'=>'Message', 
	'sub_title'=>'',
	'css'=>''
));
	echo "<table width='50%' style='min-width:150px; margin: 20px; margin-left: auto; margin-right: auto;' cellpadding='0' border='0' cellspacing='0' ><tr><td>".format_notice($this, $msg)."<br><br>
	<button type='button' id='refreshlistfromiframe' name='refreshlistfromiframe' class='btn blue' style='width:100%;' onclick='parent.location.reload();'>Refresh List</button>
	</td></tr></table>";
	
	$this->load->view('addons/shadow_page_footer', array('page'=>'addons__basic_addons'));
}


if(!empty($area) && strpos($area, '__from_shadowpage') === FALSE) echo $tableHTML;
?>