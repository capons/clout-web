<?php
if(!empty($permissionGroupList))
{
?>
<table class="normal-list-table" data-msg="Are you sure you want to remove this permission group? Any users assigned to this group will lose their access rights.">
<thead class='light-grey-bg'>
<tr>

<th style='width:1%;'>#</th>
<th>Group Name</th>
<th>Permission Summary</th>
<th nowrap>Users in Group</th>
<th style='width:1%;'>Status</th>

</tr>
</thead>

<tbody>
<?php $this->load->view('setting/permission_group_list', array('permissionGroupList'=>$permissionGroupList, 'groupCategory'=>$groupCategory)); ?>
</tbody>
</table>
<?php 
} else {
	echo format_notice($this, "WARNING: There are no more permission groups in this list.");
}
?>