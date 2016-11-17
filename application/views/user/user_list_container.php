<?php
if(!empty($userList))
{
?>
<table>
<thead>
<tr>
<th><input id='selectallcheck' name='selectall' type='checkbox' value='selectall' class='bigcheckbox'><label for='selectallcheck'></label></th>

<?php if($viewToLoad == 'profile'){?>
<th>Name</th>
<th>Email</th>
<th>V</th>
<th>Mobile</th>
<th>V</th>
<th>Gender</th>
<th>DOB</th>
<th>Address</th>
<th>V</th>
<th>City</th>
<th>State</th>
<th>Zip</th>
<th>Country</th>
<th>Photo</th>
<th>DL Up</th>
<th>V</th>
<th>SSN#</th>
<th>Fb</th>
<th>Li</th>
<th>Tw</th>
<th>Em</th>
<th>User Permission</th>
<?php 




} else if($viewToLoad == 'network'){?>

<th>Last Import</th>
<th>Last Join</th>
<th>LastCommission</th>
<th>Imported</th>
<th>Invited 1st</th>
<th>Invited 2nd</th>
<th>Invited 3rd</th>
<th>Invited 4th</th>
<th>Joined 1st</th>
<th>Joined 2nd</th>
<th>Joined 3rd</th>
<th>Joined 4th</th>
<th>TotNwk</th>
<th>Com 1st</th>
<th>Com 2nd</th>
<th>Com 3rd</th>
<th>Com 4th</th>
<th>TotCom</th>
<th>StoreOJoins</th>
<th>StoreOCom</th>
<?php 




} else if($viewToLoad == 'activity'){?>

<th>Joined</th>
<th>Last Login</th>
<th>LastPromoUsed</th>
<th>LastTicket</th>
<th>Logins</th>
<th>LinkAccts</th>
<th>LinkIns</th>
<th>RawTrans</th>
<th>Checkins</th>
<th>PerksUsed</th>
<th>CBUsed</th>
<th>Msgs</th>
<th>Reviews</th>
<th>Fav</th>
<th>PgViews</th>
<th>Clicks</th>
<th>Searches</th>
<th>Locations</th>
<th>IPs</th>
<th>Devices</th>
<th>OpenTick</th>
<th>ClosedTick</th>
<th>Status</th>
<?php 




} else if($viewToLoad == 'money'){?>

<th>LastTransaction</th>
<th>LastTransferOutReq</th>
<th>Available</th>
<th>Pending</th>
<th>Withdrawn</th>
<th>Funds Exp30d</th>
<th>Funds Expired</th>
<th>WithdrFees</th>
<th>CashBFees</th>
<th>PerkRev</th>
<th>Unmatched $</th>
<th>Unmatched #</th>
<th>Matched $</th>
<th>Matched #</th>
<th>PendTransfersOut</th>
<th>PendTransfersIn</th>
<th>Financial Alerts</th>
<?php 




} else if($viewToLoad == 'clout_score'){?>

<th>Clout Score</th>
<th>Account Set Up</th>
<th>Activity</th>
<th>Referrals</th>
<th>Spending of Referrals</th>
<th>Spending</th>
<th>AD Spending</th>
<th>Linked Accounts</th>
<th>$ Spending 180d</th>
<th>$ Spending 360d</th>
<th>$ Spending Life</th>
<th>AD Spending 180d</th>
<th>AD Spending 360d</th>
<th>AD Spending Life</th>

<?php }?>




</tr>
</thead>

<tbody>
<?php $this->load->view('user/user_list', array('userList'=>$userList, 'viewToLoad'=>$viewToLoad)); ?>

</tbody>
</table>
<?php 
} else {
	echo format_notice($this, "WARNING: There are no more users in this list.");
}
?>