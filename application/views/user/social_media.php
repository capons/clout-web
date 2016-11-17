<?php
/*
 * Facebook detail page for the selected user
 * 
 * @author khim.ung
 */

$this->load->view('addons/shadow_page_popup_header', array(
		'icon_url'=>(!empty($user['photo_url'])? $user['photo_url']: ''),
		'title'=>$title, 
		'sub_title'=>'',
		'owner_user_id'=>$user['owner_user_id']
	 ));
	 
	 
	 
# if no errors display facebook detail
if(empty($msg)){
	
	# data-units
	echo "<div class='data-units'>";
	
	# Loop through each facebook detail
	foreach($user AS $key => $value) {
	
		
		# Display the facebook detail
		if('photo_list' != $key && 'photo_url' != $key) {
		
			/*
			 * Display header name
			 * begin unit
			 */
			echo "<div class='unit'><div>".ucwords(str_replace('_', ' ', $key))."</div>";
					
			$value = trim($value);
	
			if('profile_link' == $key) {
				echo "<div>".(!empty($value)? "<a target='_blank' href='".$value."'>".$value."</a>": '&nbsp;')."</div>";
			}
			
			else if('owner_user_id' == $key) {
				echo "<div>".(!empty($value)? format_id($value)	: '&nbsp;')."</div>";	
			} 
			
			else if('birth_day' == $key || 'date_entered' == $key || 'last_update_date' == $key) {
				echo "<div>".(!empty($value)? format_epoch_date($value, 'm/d/Y')	: '&nbsp;')."</div>";	
				
			} 
			
			else echo "<div>".(!empty($value)? $value: '&nbsp;')."</div>";
	
		
			# end unit
			echo "</div>";
		} # end if not photo_list
		
	
	} # end foreach
	
	echo "<div style='clear:both;'></div>";
	
	# end data-units
	echo "</div>";
	
}
else {
	echo format_notice($this, $msg);
}	
	
$this->load->view('addons/shadow_page_footer');
?>