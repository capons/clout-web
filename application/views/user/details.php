<?php 
$this->load->view('addons/shadow_page_header', array(
		'icon_url'=>(!empty($user['photo'])? $user['photo']: ''),
		'title'=>$title, 
		'sub_title'=>''
	 ));






if(empty($msg)){
	echo "<div class='data-units'>";
	# the user profile
	if(!empty($profile)){
		$row = current($profile);
		$list = array(
		'Name'=>html_entity_decode($row['first_name']." ".$row['last_name'], ENT_QUOTES),
		'Email'=>$row['email_address'],
		'EV'=>$row['email_verified'],
		'Mobile'=>$row['mobile'],
		'MV'=>$row['mobile_verified'],
		'Gender'=>$row['gender'],
		'DOB'=>format_epoch_date($row['birthday'], 'm/d/Y'),
		'Address'=>$row['address'],
		'AV'=>$row['address_verified'],
		'City'=>$row['city'],
		'State'=>$row['state'],
		'Zip'=>$row['zipcode'],
		'Country'=>$row['country'],
		'Photo'=>$row['photo'],
		'DL Up'=>$row['driver_license'],
		'DV'=>$row['driver_license_verified'],
		'SSN#'=>$row['ssn'],
		'Fb'=>'Y' == $row['facebook_connected'] ? "<a href='".base_url().'user/social_media/d/'.$row['user_id']."/t/facebook' class='shadowpage'>".$row['facebook_connected']."</a>" : $row['facebook_connected'],
		'Li'=>$row['linkedin_connected'],
		'Tw'=>$row['twitter_connected'],
		'Em'=>$row['email_connected'],
		'User Permission'=>$row['permission_group']
		);
		
		foreach($list AS $key=>$value) {
			$value = trim($value);
			echo "<div class='unit'>
					<div>".$key."</div>
					<div>".(!empty($value)? $value: '&nbsp;')."</div>
				  </div>";
		}
	}
	
	echo "<div style='clear:both'></div>";
	
	
	
	

	# the user network
	if(!empty($network)){
		$row = current($network);
		
		$list = array(
		'Last Import'=>format_epoch_date($row['last_import'], 'm/d/Y H:i'), 
		'Last Join'=>format_epoch_date($row['last_join'], 'm/d/Y H:i'),  
		'LastCommission'=>format_epoch_date($row['last_commission'], 'm/d/Y H:i'),  
		'Imported'=>format_number($row['total_imported_contacts'],100,0),  
		'Invited 1st'=>format_number($row['total_invited_level_1'],100,0),  
		'Invited 2nd'=>format_number($row['total_invited_level_2'],100,0),  
		'Invited 3rd'=>format_number($row['total_invited_level_3'],100,0),  
		'Invited 4th'=>format_number($row['total_invited_level_4'],100,0),  
		'Joined 1st'=>format_number($row['total_joined_level_1'],100,0),  
		'Joined 2nd'=>format_number($row['total_joined_level_2'],100,0),  
		'Joined 3rd'=>format_number($row['total_joined_level_3'],100,0),  
		'Joined 4th'=>format_number($row['total_joined_level_4'],100,0),  
		'TotNwk'=>format_number($row['total_network'],100,0),  
		'Com 1st'=>'$'.format_number($row['commissions_level_1'],100,2),  
		'Com 2nd'=>'$'.format_number($row['commissions_level_2'],100,2),  
		'Com 3rd'=>'$'.format_number($row['commissions_level_3'],100,2),  
		'Com 4th'=>'$'.format_number($row['commissions_level_4'],100,2),  
		'TotCom'=>'$'.format_number($row['total_commissions'],100,2),  
		'StoreOJoins'=>format_number($row['total_store_favorites'],100,0),  
		'StoreOCom'=>'$'.format_number($row['commissions_store'],100,2) 
		);
		
		foreach($list AS $key=>$value) {
			$value = trim($value);
			echo "<div class='unit'>
					<div>".$key."</div>
					<div>".(!empty($value)? $value: '&nbsp;')."</div>
				  </div>";
		}
	}






echo "<div style='clear:both'></div>";

	

	# the user activity
	if(!empty($activity)){
		$row = current($activity);
		
		$list = array(
		'Joined'=>format_epoch_date($row['date_joined'], 'm/d/Y H:i'), 
		'Last Login'=>format_epoch_date($row['last_login'], 'm/d/Y H:i'),  
		'LastPromoUsed'=>format_epoch_date($row['last_promo_used_on'], 'm/d/Y H:i'),  
		'LastTicket'=>format_epoch_date($row['last_ticket_on'], 'm/d/Y H:i'),  
		'Logins'=>format_number($row['total_logins'],100,0),  
		'LinkAccts'=>format_number($row['total_linked_accounts'],100,0),  
		'LinkIns'=>format_number($row['total_linked_institutions'],100,0),  
		'RawTrans'=>format_number($row['total_raw_transactions'],100,0),  
		'Checkins'=>format_number($row['total_checkins'],100,0),  
		'PerksUsed'=>format_number($row['total_perks_used'],100,0),  
		'CBUsed'=>format_number($row['total_cashback_used'],100,0),  
		'Msgs'=>format_number($row['total_msgs_received'],100,0),  
		'Reviews'=>format_number($row['total_reviews'],100,0),  
		'Fav'=>format_number($row['total_store_favorites'],100,0),  
		'PgViews'=>format_number($row['total_store_views'],100,0),  
		'Clicks'=>format_number($row['total_clicks'],100,0),   
		'Searches'=>format_number($row['total_searches'],100,0),  
		'Locations'=>format_number($row['total_locations'],100,0),  
		'IPs'=>format_number($row['total_ips'],100,0),  
		'Devices'=>format_number($row['total_devices'],100,0),  
		'OpenTick'=>format_number($row['total_open_tickets'],100,0),  
		'ClosedTick'=>format_number($row['total_closed_tickets'],100,0),  
		'Status'=>$row['user_status']
		);
		
		foreach($list AS $key=>$value) {
			$value = trim($value);
			echo "<div class='unit'>
					<div>".$key."</div>
					<div>".(!empty($value)? $value: '&nbsp;')."</div>
				  </div>";
		}
	}


	
echo "<div style='clear:both'></div>";




	
	# the user money
	if(!empty($money)){
		$row = current($money);
		
		$list = array(
		'LastTransaction'=>format_epoch_date($row['last_transaction_date'], 'm/d/Y H:i'), 
		'LastTransferOutReq'=>format_epoch_date($row['last_transfer_out_request'], 'm/d/Y H:i'), 
		'Available'=>'$'.format_number($row['available_balance'],100,2), 
		'Pending'=>'$'.format_number($row['pending_balance'],100,2), 
		'Withdrawn'=>'$'.format_number($row['total_withdrawn'],100,2), 
		'Funds Exp30d'=>'$'.format_number($row['funds_expiring_in_30_days'],100,2), 
		'Funds Expired'=>'$'.format_number($row['funds_expired'],100,2), 
		'WithdrFees'=>'$'.format_number($row['total_withdraw_fees'],100,2), 
		'CashBFees'=>'$'.format_number($row['total_cashback_fees'],100,2), 
		'PerkRev'=>format_number($row['total_perks_used'],100,0), 
		'Unmatched $'=>format_number($row['total_unmatched_amount'],100,2), 
		'Unmatched #'=>format_number($row['total_unmatched'],100,0), 
		'Matched $'=>format_number($row['total_matched_amount'],100,2), 
		'Matched #'=>format_number($row['total_matched'],100,0), 
		'PendTransfersOut'=>format_number($row['pending_transfers_out'],100,0), 
		'PendTransfersIn'=>format_number($row['pending_transfers_in'],100,0), 
		'Financial Alerts'=>format_number($row['total_financial_alerts'],100,0)
		);
		
		foreach($list AS $key=>$value) {
			$value = trim($value);
			echo "<div class='unit'>
					<div>".$key."</div>
					<div>".(!empty($value)? $value: '&nbsp;')."</div>
				  </div>";
		}
	}


	
	echo "<div style='clear:both'></div>";
	
	
	
	
	# the user clout score
	if(!empty($clout_score)){
		$row = current($clout_score);
		
		$list = array(
		'Clout Score'=>format_number($row['clout_score'],100,0), 
		'Account Set Up'=>format_number($row['account_setup_score'],100,0),
		'Activity'=>format_number($row['activity_score'],100,0),
		'Referrals'=>format_number($row['referrals_score'],100,0),
		'Spending of Referrals'=>format_number($row['spending_of_referrals_score'],100,0),
		'Spending'=>format_number($row['spending_score'],100,0),
		'AD Spending'=>format_number($row['ad_spending_score'],100,0),
		'Linked Accounts'=>format_number($row['linked_accounts_score'],100,0),
		'$ Spending 180d'=>'$'.format_number($row['spending_last180days'],100,2),
		'$ Spending 360d'=>'$'.format_number($row['spending_last360days'],100,2),
		'$ Spending Life'=>'$'.format_number($row['spending_total'],100,2),
		'AD Spending 180d'=>'$'.format_number($row['ad_spending_last180days'],100,2),
		'AD Spending 360d'=>'$'.format_number($row['ad_spending_last360days'],100,2),
		'AD Spending Life'=>'$'.format_number($row['ad_spending_total'],100,2)
		);
		
		foreach($list AS $key=>$value) {
			$value = trim($value);
			echo "<div class='unit'>
					<div>".$key."</div>
					<div>".(!empty($value)? $value: '&nbsp;')."</div>
				  </div>";
		}
	}
	
	
	echo "</div>";
	
}
else {
	echo format_notice($this, $msg);
}





$this->load->view('addons/shadow_page_footer');
?>