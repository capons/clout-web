<?php

$stopHtml = "<input name='paginationdiv__mailsearch_stop' id='paginationdiv__mailsearch_stop' type='hidden' value='1' />";

if(!empty($reservationList))
{
	log_message('debug', 'in reservation list'.json_encode($reservationList));

	echo "<table class='events-table'>";

	$thisMonth = date('F', strtotime('this month'));
	$nextMonth = date('F', strtotime('next month'));
	$thisWeekHeader = FALSE;
	$nextWeekHeader = FALSE;
	$thisMonthHeader = FALSE;
	$nextMonthHeader = FALSE;
	$monthHeader = array();

	foreach($reservationList As $row){

		if(empty($is_single_row) || !$is_single_row){
			$header = $row['date_category'];

			if($header == 'this_week' && !$thisWeekHeader){
				echo "<thead><tr><th colspan='4'>This Week</th></tr></thead>";
				$thisWeekHeader = TRUE;
			} else if ($header == 'next_week' && !$nextWeekHeader) {
				echo "<thead><tr><th colspan='4'>Next Week</th></tr></thead>";
				$nextWeekHeader = TRUE;
			} else if ($header == $thisMonth && !$thisMonthHeader) {
				echo "<thead><tr><th colspan='4'>This Month</th></tr></thead>";
				$thisMonthHeader = TRUE;
			} else if ($header == $nextMonth && !$nextMonthHeader) {
				echo "<thead><tr><th colspan='4'>Next Month</th></tr></thead>";
				$nextMonthHeader = TRUE;
			} else if ($header != 'this_week' && $header != 'next_week' && $header != $thisMonth && $header != $nextMonth){
				if(!in_array($header, $monthHeader)){
					echo "<thead><tr><th colspan='4'>".$header."</th></tr></thead>";
					array_push($monthHeader, $header);
				}
			}
		}

		$date = date('Y-m-d', strtotime($row['schedule_date']));
		$time = date('h:i A', strtotime($row['schedule_date']));

		log_message('debug','reservation_id='.$row['reservation_id']);
		echo "<tbody>
						<tr id='reservation_".$row['reservation_id']."' value='".$row['store_id']."'>
							<td>
								<p class='day'>".date('D', strtotime($date))."</p>
								<p class='date'>".$date."</p>
							</td>
							<td id='storedetail'>
								<div id='storeinfo'>
									<div id='photo' style='background-image: url(".API_S3_URL."banner_".$row['store_id'].".png);'></div>
									<div>
										<p class='title'>".$row['store_name']."</p>
										<p class='detail'>".$row['promotion_title']."</p>
										<p class='detail'>".$row['promotion_rules']."</p>
									</div>
								</div>
								<div id='confirmationdetail'>";
								if($row['requires_confirmation'] == 'Y' && $row['is_confirmed'] == 'N') {
									if(!empty($row['contact_phone'])) {
										echo "<img src='".base_url()."assets/images/telephone_icon.png'> ".format_telephone($row['contact_phone'])."<p style='color: red; font-weight: 600;'>confirmation pending</p>";
									} else {
										if(!empty($row['contact_email'])) {
											echo "<img src='".base_url()."assets/images/send_mail_icon.png'> ".$row['contact_email']."<p style='color: red; font-weight: 600;'>confirmation pending</p>";
										}
									}
								}
								echo "</div>
							</td>
							<td>
								<p class='time'>$time</p>
								<p class='friends'>".$row['number_in_party']." people</p>
								<span class='response'>
									<a id='modifyreservation' value='".$row['reservation_id']."'>Modify</a>
									<a class='cancelreservation' value='".$row['promotion_id']."'";
									if (!empty($isSingleRow) && $isSingleRow) {
										echo " data-info='".$c."'";
									}
									echo ">Cancel</a>
								</span>
							</td>
						</tr>
						<tr id='modifyreservation_".$row['reservation_id']."' class='modify-form-row'>
							 <td>
								 <p class='date' style='visibility:hidden;'>".$date."</p>
							 </td>
							 <td colspan='2' id='reservation-details'>
							 		<div>
										<div>
											 <span>Name: </span>
											 <input type='text' id='name'/>
										</div>
										<div>
											 <span>Email: </span>
											 <input type='text' id='email' class='email'/>
										</div>
									</div>
									<div>
										<div>
											 <span>Phone Type: </span>
											 <select id='phonetypes' name='phonetypes' class='drop-down' value='Mobile'/></select>
										</div>
										<div>
											 <span>Phone Provider: </span>
											 <select id='provider' name='provider' class='drop-down'></select>
										</div>
										<div>
											 <span>Phone: </span>
											 <input type='text' id='phone' class='numbersonly telephone'/>
										</div>
									</div>
									<div>
										<div>
											 <span>Date:	</span>
											 <input type='text' id='reservationdate_".$row['reservation_id']."' name='eventdate' class='calendar showtime clickactivated future-date' placeholder='Select Date/Time' />
										</div>
										<div>
											 <span>Number in Party: </span>
											 <input type='text' id='numberinparty' class='textfield numbersonly' value='1' />
										</div>
									</div>
									<div>
										 <div>
											 <span>Special Requests: </span>
											 <textarea type='text' class='optional' id='specialrequest'></textarea>
										 </div>
										 <div id='buttons'>";
											 if (!empty($isSingleRow) && $isSingleRow) {
												 echo "<input id='info' type='hidden' value='".$c."'/>";
											 }
											 echo "<input id='storeid' type='hidden' value='".$row['store_id']."'/>";
											 echo "<button id='updatereservation' class='green btn' value='".$row['reservation_id']."'>Submit</button>
 											 <a class='";
											 if (!empty($isSingleRow) && $isSingleRow) {
												 echo "redirect'";
											 } else {
												 echo "closerow'";
											 }
												 echo " value='".$row['reservation_id']."'>close</a>
 										</div>
									</div>
							</td>
						</tr>";
	}

	echo "</tbody></table>";

} else echo format_notice($this, "WARNING: There are no reservations.").$stopHtml;

?>
