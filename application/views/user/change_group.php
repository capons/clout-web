<?php 
echo "<script src='".base_url()."assets/js/jquery-2.1.1.min.js' type='text/javascript'></script>";
echo "<script type='text/javascript' src='".base_url()."assets/js/clout.js'></script>
	  <script type='text/javascript' src='".base_url()."assets/js/clout.fileform.js'></script>".get_ajax_constructor(TRUE); 
echo "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 

echo "<table style='width:100%;height:350px;'><tr><td style='vertical-align:top;'><table class='microform' style='width:100%;'>
<tr><td class='h2 dark-grey'>Change Permission Group</td></tr>
<tr><td>
<select id='group__permissiongroups' name='group__permissiongroups' class='drop-down' value='' style='width:100%;'>
".get_option_list($this, 'permissiongroups')."
</select>
</td></tr>

<tr><td>
<div id='user_group_access' style='overflow-y:auto;overflow-x:hidden; max-height:200px;display:none;'></div>
</td></tr>

<tr><td><button type='button' id='changegroup' name='changegroup' class='btn green submitmicrobtn' style='width:100%;'>Change Group</button>

<input type='hidden' name='resultsdiv' id='resultsdiv' value=''>
<input type='hidden' name='action' id='action' value='".base_url()."user/change_group'>
<input type='hidden' id='redirectaction' name='redirectaction' value='".base_url()."user/change_group/a/confirm' />
<input type='hidden' id='users' name='users' value='".str_replace('--',',',$list)."' />
</td></tr>

</table>

<input type='hidden' id='layerid' name='layerid' value='' />
</td></tr></table>";



?>