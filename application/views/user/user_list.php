<?php
$viewColumnCount = array('profile'=>23, 'network'=>21, 'activity'=>24, 'money'=>18, 'clout_score'=>15);
$selected = $this->native_session->get('selected_users')? $this->native_session->get('selected_users'): array();
$userIds = "";

if(!empty($userList))
{
	$rowCount = count($userList);
	$i = 0;
	foreach($userList AS $row)
	{
		$i++;

	echo "<tr id='".$row['user_id']."' ".(in_array($row['user_id'],$selected)? " class='row-highlight' ": '').">
<td>".(!in_array($row['user_id'], array('1','2'))? "<input id='select_".$row['user_id']."' name='selectall[]' type='checkbox' value='".$row['user_id']."' class='bigcheckbox highlight-checked' data-url='lists/add_to_session/name/selected_users/d/".$row['user_id']."' ".(in_array($row['user_id'],$selected)? " checked": '').">
<label for='select_".$row['user_id']."'></label>": "&nbsp;")
."</td>";

# User Profile View
if($viewToLoad == 'profile'){
	echo "<td><a href='".base_url()."user/details/d/".$row['user_id']."' class='shadowpage'>".$row['first_name']." ".$row['last_name']."</a></td>
<td>".$row['email_address']."</td>
<td>".$row['email_verified']."</td>
<td>".$row['mobile']."</td>
<td>".$row['mobile_verified']."</td>
<td>".$row['gender']."</td>
<td>".format_epoch_date($row['birthday'], 'm/d/Y')."</td>
<td>".$row['address']."</td>
<td>".$row['address_verified']."</td>
<td>".$row['city']."</td>
<td>".$row['state']."</td>
<td>".$row['zipcode']."</td>
<td>".$row['country']."</td>
<td>".$row['photo']."</td>
<td>".$row['driver_license']."</td>
<td>".$row['driver_license_verified']."</td>
<td>".$row['ssn']."</td>";
echo 'Y' == $row['facebook_connected'] ? "<td><a href='".base_url().'user/social_media/d/'.$row['user_id']."/t/facebook' class='shadowpage'>".$row['facebook_connected']."</a></td>" : 
"<td>".$row['facebook_connected']."</td>";
echo "<td>".$row['linkedin_connected']."</td>
<td>".$row['twitter_connected']."</td>
<td>".$row['email_connected']."</td>
<td>".$row['permission_group'];
}

# User Network View
else if($viewToLoad == 'network'){
	echo "<td>".format_epoch_date($row['last_import'], 'm/d/Y H:i')."</td>
<td>".format_epoch_date($row['last_join'], 'm/d/Y H:i')."</td>
<td>".format_epoch_date($row['last_commission'], 'm/d/Y H:i')."</td>
<td>".format_number($row['total_imported_contacts'],100,0)."</td>
<td>".format_number($row['total_invited_level_1'],100,0)."</td>
<td>".format_number($row['total_invited_level_2'],100,0)."</td>
<td>".format_number($row['total_invited_level_3'],100,0)."</td>
<td>".format_number($row['total_invited_level_4'],100,0)."</td>
<td>".format_number($row['total_joined_level_1'],100,0)."</td>
<td>".format_number($row['total_joined_level_2'],100,0)."</td>
<td>".format_number($row['total_joined_level_3'],100,0)."</td>
<td>".format_number($row['total_joined_level_4'],100,0)."</td>
<td>".format_number($row['total_network'],100,0)."</td>
<td>$".format_number($row['commissions_level_1'],100,2)."</td>
<td>$".format_number($row['commissions_level_2'],100,2)."</td>
<td>$".format_number($row['commissions_level_3'],100,2)."</td>
<td>$".format_number($row['commissions_level_4'],100,2)."</td>
<td>$".format_number($row['total_commissions'],100,2)."</td>
<td>".format_number($row['total_store_favorites'],100,0)."</td>
<td>$".format_number($row['commissions_store'],100,2);
}

# User Activity View
else if($viewToLoad == 'activity'){
	echo "<td>".format_epoch_date($row['date_joined'], 'm/d/Y H:i')."</td>
<td>".format_epoch_date($row['last_login'], 'm/d/Y H:i')."</td>
<td>".format_epoch_date($row['last_promo_used_on'], 'm/d/Y H:i')."</td>
<td>".format_epoch_date($row['last_ticket_on'], 'm/d/Y H:i')."</td>
<td>".format_number($row['total_logins'],100,0)."</td>
<td>".format_number($row['total_linked_accounts'],100,0)."</td>
<td>".format_number($row['total_linked_institutions'],100,0)."</td>
<td>".format_number($row['total_raw_transactions'],100,0)."</td>
<td>".format_number($row['total_checkins'],100,0)."</td>
<td>".format_number($row['total_perks_used'],100,0)."</td>
<td>".format_number($row['total_cashback_used'],100,0)."</td>
<td>".format_number($row['total_msgs_received'],100,0)."</td>
<td>".format_number($row['total_reviews'],100,0)."</td>
<td>".format_number($row['total_store_favorites'],100,0)."</td>
<td>".format_number($row['total_store_views'],100,0)."</td>
<td>".format_number($row['total_clicks'],100,0)."</td>
<td>".format_number($row['total_searches'],100,0)."</td>
<td>".format_number($row['total_locations'],100,0)."</td>
<td>".format_number($row['total_ips'],100,0)."</td>
<td>".format_number($row['total_devices'],100,0)."</td>
<td>".format_number($row['total_open_tickets'],100,0)."</td>
<td>".format_number($row['total_closed_tickets'],100,0)."</td>
<td>".$row['user_status'];
}

# User Money View
else if($viewToLoad == 'money'){
	echo "<td>".format_epoch_date($row['last_transaction_date'], 'm/d/Y H:i')."</td>
<td>".format_epoch_date($row['last_transfer_out_request'], 'm/d/Y H:i')."</td>
<td>$".format_number($row['available_balance'],100,2)."</td>
<td>$".format_number($row['pending_balance'],100,2)."</td>
<td>$".format_number($row['total_withdrawn'],100,2)."</td>
<td>$".format_number($row['funds_expiring_in_30_days'],100,2)."</td>
<td>$".format_number($row['funds_expired'],100,2)."</td>
<td>$".format_number($row['total_withdraw_fees'],100,2)."</td>
<td>$".format_number($row['total_cashback_fees'],100,2)."</td>
<td>".format_number($row['total_perks_used'],100,0)."</td>
<td>".format_number($row['total_unmatched_amount'],100,2)."</td>
<td>".format_number($row['total_unmatched'],100,0)."</td>
<td>".format_number($row['total_matched_amount'],100,2)."</td>
<td>".format_number($row['total_matched'],100,0)."</td>
<td>".format_number($row['pending_transfers_out'],100,0)."</td>
<td>".format_number($row['pending_transfers_in'],100,0)."</td>
<td>".format_number($row['total_financial_alerts'],100,0);
}

# User Clout Score View
else if($viewToLoad == 'clout_score'){
	echo "<td>".format_number($row['clout_score'],100,0)."</td>
<td>".format_number($row['account_setup_score'],100,0)."</td>
<td>".format_number($row['activity_score'],100,0)."</td>
<td>".format_number($row['referrals_score'],100,0)."</td>
<td>".format_number($row['spending_of_referrals_score'],100,0)."</td>
<td>".format_number($row['spending_score'],100,0)."</td>
<td>".format_number($row['ad_spending_score'],100,0)."</td>
<td>".format_number($row['linked_accounts_score'],100,0)."</td>
<td>$".format_number($row['spending_last180days'],100,2)."</td>
<td>$".format_number($row['spending_last360days'],100,2)."</td>
<td>$".format_number($row['spending_total'],100,2)."</td>
<td>$".format_number($row['ad_spending_last180days'],100,2)."</td>
<td>$".format_number($row['ad_spending_last360days'],100,2)."</td>
<td>$".format_number($row['ad_spending_total'],100,2);
}

echo "</td>
</tr>";

	# Continuous scroll target
	if($i == $rowCount && ((!empty($n) && $rowCount == $n) || (empty($n) && $rowCount == 20))) {
		echo "<tr><td colspan='".(!empty($viewColumnCount[$viewToLoad])? $viewColumnCount[$viewToLoad]: '1')."' class='load-next-row'><button id='scrolltarget' class='btn blue load-on-click' style='width:100%'>Load Next List</button></td></tr>";
	}
	
	# keep track of the shown users
	$userIds .= ','.$row['user_id'];
}
	
	
}
# No descriptors left to show
else {
	echo "<tr><td colspan='".(!empty($viewColumnCount[$viewToLoad])? $viewColumnCount[$viewToLoad]: '1')."'>".format_notice($this, 'WARNING: There are no more users in this list.')."</td></tr>";
}

echo "<input type='hidden' id='userlistids' name='userlistids' value='".trim($userIds,',')."' />";
?>