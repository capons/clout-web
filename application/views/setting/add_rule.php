<?php 
echo "<table class='normal-table microform'>
		
		<tr>
		<td style='width:1%;'><select id='rule_ruletypes' name='rule_ruletypes' class='small-drop-down' value='' style='min-width:130px; width:250px;' placeholder='Rule Type' onchange=\"updateFieldLayer('".base_url()."setting/change_rule_set','rule_ruletypes','','select_rulename_div','')\"/>".get_option_list($this, 'ruletypes')."</select></td>
		
		<td style='width:1%;'><div id='select_rulename_div' style='width:360px;'><select id='rule_rulenames' name='rule_rulenames' class='small-drop-down' value='' style='min-width:130px; width:350px;' placeholder='Rule Name'/>".get_option_list($this, 'rulenames')."</select></div></td>
		
		<td style='width:98%;'>
		<button id='addrule' name='addrule' class='blue smallbtn add-access-rule'>Add Rule</button>
		</td>
		
		</tr>
		
		</table>";

?>