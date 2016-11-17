<?php
if(!empty($cronJobList))
{
?>
<table class="normal-list-table">
<thead class='light-grey-bg'>
<tr>

<th style='width:1%;'>ID</th>
<th>Job Type</th>
<th>Activity Name</th>
<th>Job Details</th>
<th>Started</th>
<th>Finished</th>
<th>Results</th>
<th>Records Updated</th>
<th>Repeat</th>
<th style='width:1%;'>Status</th>

</tr>
</thead>

<tbody>
<?php $this->load->view('setting/cron_job_list', array('cronJobList'=>$cronJobList)); ?>
</tbody>
</table>
<?php 
} else {
	echo format_notice($this, "WARNING: There are no more cron jobs in this list.");
}
?>