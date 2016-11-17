<?php
if(!empty($transactionList))
{
?>
<table>
<thead>
<tr>
<th>Transaction Descriptor</th>
<th>Category</th>
<th>Clout Merchant mapped to Descriptor</th>
<th>Date</th>
<th>Amount</th>
<th>Status</th>
<th>User ID</th>
<th>Location</th>
<th>Type</th>
</tr>
</thead>

<tbody>
<?php $this->load->view('transaction/transaction_list', array('transactionList'=>$transactionList));?>

</tbody>
</table>
<?php 
} else {
	echo format_notice($this, "WARNING: There are no more transactions in this list.");
}
?>