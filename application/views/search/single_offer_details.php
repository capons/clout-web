<?php
if(!empty($msg)){
	$tableHTML = "<div style='padding-top:10px;'>".format_notice($this,$msg)."</div>";
}
else 
{
	$tableHTML = "<div style='padding:0px; overflow:auto; margin-top: 10px;'>
	<table width='100%' border='0' cellpadding='0' cellspacing='0'>";
	
	
	
	#-----------------------------------------------------------------------------
	# Scheduling form
	#-----------------------------------------------------------------------------
	if(!empty($offerDetails['requires_scheduling']) && $offerDetails['requires_scheduling']=='Y')
	{
		$tableHTML .= "<tr><td class='h3' style='background-color: #F1F1F1;text-align:center;padding:10px;'>Reservation Required</td></tr>";
		
		
		$randomNo = strtotime('now');
		$tableHTML .= "<tr><td><div id='perk_scheduler_".$randomNo."'>
		<form id='scheduler_".$randomNo."' method='post' action='".base_url()."search/make_reservation/i/".encrypt_value($offerId)."' onSubmit=\"return submitLayerForm('scheduler_".$randomNo."')\">
		
		<table width='100%' border='0' cellpadding='5' cellspacing='5'>";
		
		# Extra offer conditions
		if(!empty($offerDetails['extra_conditions']))
		{
			$tableHTML .= "<tr><td valign='top'>
			<ul style='padding-left:0px;'>";
			foreach($offerDetails['extra_conditions'] AS $condition)
			{
				$tableHTML .= "<li style='list-style-type: none;'>".$condition."</li>";
			}
			$tableHTML .= "</ul></td></tr>";
		}
		
		
		
		$tableHTML .= "<tr><td class='row-divs'>
		<div class='half-width'><input name='reservationname' type='text' class='textfield' id='reservationname' placeholder='Your Name' style='width:100%;' maxlength='200' value='".$this->native_session->get('__first_name')." ".$this->native_session->get('__last_name')."'></div>
		
		<div class='half-width'><input name='reservationdate' type='text' class='calendar showtime clickactivated' id='reservationdate' placeholder='Date/Time' onclick='setDatePicker()' style='width:100%;' value=''></div>
		</td></tr>
		
		
		<tr><td class='row-divs' style='padding-top:5px;'>
		<div class='half-width'><input name='reservationphone' type='text' class='textfield' id='reservationphone' placeholder='Phone Number' style='width:100%;' onKeyUp='formatPhoneValue(this, event)' maxlength='10' value='".($this->native_session->get('__telephone')? $this->native_session->get('__telephone'): "")."'></div>
		
		<div class='half-width'><input name='reservationnumber' type='text' class='textfield' id='reservationnumber' placeholder='Number in Party' maxlength='3' style='width:100%;' value='' onKeyUp='formatPhoneValue(this, event)'></div>
		</td></tr>
		
		
		<tr><td style='padding-top:5px;'>
		<div><textarea class='textfield' name='specialrequests' id='specialrequests' style='min-width:calc(100% - 42px);' placeholder='Special Requests'></textarea></div>
		</td></tr>
		
		<tr><td style='padding-top:5px; padding-bottom:10px;'>
		<input type='submit' name='submit_perk' id='submit_perk' class='btn green' style='min-width:calc(100% - 42px);' value='Submit'>
		</td></tr>
		</table>
		
		
	<input type='hidden' name='scheduler_".$randomNo."_required' id='scheduler_".$randomNo."_required' value='reservationname<>reservationdate<>reservationphone<>reservationnumber'>
	<input type='hidden' name='scheduler_".$randomNo."_required_msg' id='scheduler_".$randomNo."_required_msg' value='Your name, contacts and a reservation date are required to continue.'>
	<input type='hidden' name='scheduler_".$randomNo."_displaylayer' id='scheduler_".$randomNo."_displaylayer' value='perk_scheduler_".$randomNo."'></form>
	</div>
	</td></tr>";
		
		
		
		
		
		
		
		
		
		
		
		
	}
	
	# If it does not require scheduling
	else
	{
		$tableHTML .= "<tr><td class='h3' style='background-color: #F1F1F1;text-align:center;padding:10px;'>".$offerDetails['offer_bar_code']."</td></tr>";
		
		if(!empty($offerDetails['offer_bar_code'])){
			$tableHTML .= "<tr><td style='text-align:center;padding:10px; padding-top:20px;'><img src='".BASE_URL."external_libraries/phpqrcode/qr_code.php?value=".str_replace('/','__',BASE_URL.'find/b/'.$offerDetails['offer_bar_code'])."' border='0' /></td></tr>";
		}
	
		# Extra offer conditions
		if(!empty($offerDetails['extra_conditions']))
		{
			$tableHTML .= "<tr><td valign='top'>
			<ul>";
			foreach($offerDetails['extra_conditions'] AS $condition)
			{
				$tableHTML .= "<li style='list-style-type: none;'>".$condition."</li>";
			}
			$tableHTML .= "</ul></td></tr>";
		}
		
		$timeStamp = strtotime('now');
		$tableHTML .= "<tr><td style='text-align:center;padding-top:10px; padding-bottom:10px;'><div id='checkin_".$offerId."_".$timeStamp."'><input type='button' name='checkin' id='checkin' class='btn green' value='Checkin' style='min-width:300px;width:100%;' onClick=\"updateFieldLayer('".base_url()."search/checkin/i/".encrypt_value($offerId)."/u/".encrypt_value($this->native_session->get('__user_id'))."','','','checkin_".$offerId."_".$timeStamp."','')\"></div>
		
		</td></tr>";
	}
	
	
	
	
	$tableHTML .= "<tr><td style='padding-top:0px;'>
	
	<table width='100%' border='0' cellpadding='0' cellspacing='0'>
	<tr><td class='greycategoryheader' width='1%' style='text-align:center;'>
	
	<a href='javascript:;'  onClick=\"toggleLayer('offer_".$offerId."_details', '".base_url()."search/offer_details/i/".encrypt_value($offerId)."', '<img src=\'".base_url()."assets/images/up_arrow_single_light_grey.png\'>', '".
	($offerType == 'perk'? 
		"<input type=\'button\' name=\'use_offer_".$offerId."\' id=\'use_offer_".$offerId."\' class=\'btn green\' style=\'min-width:60px;\' value=\'Use\'>": 
		"<img src=\'".base_url()."assets/images/next_arrow_single_light_grey.png\'>"
	)."', 'offer_".$offerId."_arrow_cell', '', '', '');toggleLayersOnCondition('offer_".$offerId."_details', '".
	implode('<>', remove_item('offer_'.$offerId, $this->native_session->get('all_divs'))).
	"');\">Close</a>
	
	</td></tr>
	</table>
	</td></tr>
	
	
	
	</table>";
	
	$tableHTML .= "</div>";
}
	
	
	echo $tableHTML;
?>