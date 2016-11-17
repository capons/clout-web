<?php
echo "<table class='normal-table'>";
echo "<tr><td colspan='2' style='padding-left:0px;padding-right:0px;'><table class='default-table' style='width:100%;'>
<tr>
<td style='width:1%;font-weight:bold; white-space:nowrap;'>".base_url()."r/</td>
<td style='width:99%;'><input type='text' id='newreferralcode' name='newreferralcode' class='textfield auto-validate'  data-checkurl='network/custom_link' data-confirm='isvalidcode' data-minlength='4' placeholder='Enter Code' value='' style='width:100%;' />
<input type='hidden' id='isvalidcode' name='isvalidcode' value='N'/>
</td>
</tr>
</table></td></tr>
<tr>
<td style='padding-left:0px;'><button id='cancelcustomlink' name='cancelcustomlink' class='btn grey' style='width:100%;'>Cancel</button></td>
<td style='padding-right:0px;'><button id='addcustomlink' name='addcustomlink' class='btn blue' style='width:100%;'>Add</button></td>
</tr>";

echo "</table>";
?>