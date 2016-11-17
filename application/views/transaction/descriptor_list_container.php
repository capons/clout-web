<?php
if(!empty($descriptorList))
{
?>
<table>
<thead>
<tr>
<th>Transaction Descriptor</th>
<th>Descriptor Used For</th>
<th>Category</th>
<th>Clout Store Locations Mapped To Descriptor</th>
<th>Pos Matches</th>
<th>$ Trans</th>
<th># Trans</th>
<th>Status</th>
</tr>
</thead>

<tbody>
<?php $this->load->view('transaction/descriptor_list', array('descriptorList'=>$descriptorList));?>

</tbody>
</table>
<?php 
} else {
	echo format_notice($this, "WARNING: There are no more descriptors in this list.");
}
?>