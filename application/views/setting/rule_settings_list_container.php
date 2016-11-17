<?php
if(!empty($ruleSettingsList))
{
?>
<table class="normal-list-table">
<thead class='light-grey-bg'>
<tr>

<th style='width:1%;'>#</th>
<th>Rule Type</th>
<th>User Type</th>
<th>Rule Name</th>
<th>Rule</th>
<th>Users With Rule</th>
<th style='width:1%;'>Status</th>

</tr>
</thead>

<tbody>
<?php $this->load->view('setting/rule_settings_list', array('ruleSettingsList'=>$ruleSettingsList)); ?>
</tbody>
</table>
<?php 
} else {
	echo format_notice($this, "WARNING: There are no more rule settings in this list.");
}
?>