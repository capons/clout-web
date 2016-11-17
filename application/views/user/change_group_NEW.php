<?php 
echo "<script src='".base_url()."assets/js/jquery-2.1.1.min.js' type='text/javascript'></script>";
echo "<script type='text/javascript' src='".base_url()."assets/js/clout.js'></script>
	  <script type='text/javascript' src='".base_url()."assets/js/clout.fileform.js'></script>".get_ajax_constructor(TRUE); 
echo "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 

echo "<table style='width:100%;'><tr><td style='vertical-align:top;'><table class='microform' style='width:100%;'>
<tr><td class='h2 dark-grey'>Change User Access Rights</td></tr>

<tr><td class='h4' style='padding-top:10px;'>Change Shopper Permissions</td></tr>
<tr><td>
<select id='shopper__permissiongroups' name='shopper__permissiongroups' class='drop-down' value='' style='width:100%;'>
".get_option_list($this, 'permissiongroups', 'select','', array('category'=>'shopper'))."
</select>
</td></tr>
<tr><td><div id=''></div></td></tr>

<tr><td class='h4' style='padding-top:10px;'>Add/Change Store Owner Permissions (Optional)</td></tr>
<tr><td>
<select id='store_owner__permissiongroups' name='store_owner__permissiongroups' class='drop-down' value='' style='width:100%;'>
".get_option_list($this, 'permissiongroups', 'select','', array('category'=>'store_owner'))."
</select>
</td></tr>

<tr><td class='h4' style='padding-top:10px;'>Add/Change Administrator Permissions (Optional)</td></tr>
<tr><td>
<select id='admin__permissiongroups' name='admin__permissiongroups' class='drop-down' value='' style='width:100%;'>
".get_option_list($this, 'permissiongroups', 'select','', array('category'=>'admin'))."
</select>
</td></tr>

<tr><td style='padding-top:20px; padding-bottom:30px;'><button type='button' id='savegroupchanges' name='savegroupchanges' class='btn green submitmicrobtn' style='width:100%;'>Save</button>

<input type='hidden' name='resultsdiv' id='resultsdiv' value=''>
<input type='hidden' name='action' id='action' value='".base_url()."user/change_group'>
<input type='hidden' id='redirectaction' name='redirectaction' value='".base_url()."user/change_group/a/confirm' />
<input type='hidden' id='users' name='users' value='".str_replace('--',',',$list)."' />
</td></tr>

</table>

<input type='hidden' id='layerid' name='layerid' value='' />
</td></tr></table>";



?>