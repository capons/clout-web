<?php
echo "<table class='normal-table microform'>";

if(!empty($msg)) echo "<tr><td colspan='2'>".format_notice($this,$msg)."</td></tr>"; 

echo "<tr><td><select id='file__csvformats' name='file__csvformats' class='drop-down' placeholder='File Format' style='width:100%;'>".get_option_list($this, 'csvformats')."</select></td></tr>
         <tr><td><input id='importfromfile' name='importfromfile' type='text' class='filefield' placeholder='Browse' value='' data-val='csv' data-size='3000' style='width:100%;'></td></tr>
         <tr><td><button id='startimportfromfile' name='startimportfromfile' class='btn green submitmicrobtn' style='width:100%;'>Import</button>
		 <input type='hidden' name='action' id='action' value='".base_url()."network/import_by_file'>
		 <input type='hidden' name='resultsdiv' id='resultsdiv' value='import_from_file_details'>
		 </td></tr>
</table>";
?>