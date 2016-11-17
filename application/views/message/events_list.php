<?php

$stopHtml = "<input name='paginationdiv__mailsearch_stop' id='paginationdiv__mailsearch_stop' type='hidden' value='1' />";

if(!empty($eventList))
{
	echo "<table class='events-table'>";

	$thisMonth = date('F', strtotime('this month'));
	$nextMonth = date('F', strtotime('next month'));
	$thisWeekHeader = FALSE;
	$nextWeekHeader = FALSE;
	$thisMonthHeader = FALSE;
	$nextMonthHeader = FALSE;
	$monthHeader = array();

	foreach($eventList As $row){

		if(empty($isSingleRow) || !$isSingleRow){
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

		$eventStartDateTime = date('Y-m-d h:i A', strtotime($row['start_date']));
		$eventEndDateTime = date('Y-m-d h:i A', strtotime($row['end_date']));
		$now = date('Y-m-d h:i A', strtotime('now'));

		if ($eventStartDateTime < $now) {
			$startDate = date('Y-m-d', strtotime('now'));
			$startDateForPicker = date('m/d/Y', strtotime('now'));
		} else {
			$startDate = date('Y-m-d', strtotime($row['start_date']));
			$startDateForPicker = date('m/d/Y', strtotime($row['start_date']));
		}
		$startTime = date('h:i A', strtotime($row['start_date']));
		$endDate = date('m/d/Y', strtotime($row['end_date']));

		echo "<tbody>
						<tr id='event_".$row['promotion_id']."' value='".$row['store_id']."' ";
						if ($row['attend_status'] == 'yes' || $row['attend_status'] == 'maybe') {
								echo "style='background-color:#FFC'";
						}
							echo ">
							<td>
								<p class='day'>".date('D', strtotime($startDate))."</p>
								<p class='date' value='".$startDate." ".$startTime."'>".$startDate."</p>
							</td>
							<td id='storedetail'>
								<div id='storeinfo'>
									<div id='photo' style='background-image: url(".API_S3_URL."banner_".$row['store_id'].".png);'></div>
									<div>
										<p class='title'>".$row['store_name']."</p>
										<p class='detail'>".$row['promotion_title']."</p>
										<p class='rules'>".$row['promotion_rules']."</p>
										<p class='timerange'>".$eventStartDateTime." - ".$eventEndDateTime."</p>
									</div>
								</div>
							<td>
								<p class='time'>$startTime</p>
								<p class='friends'";
								if($row['usage_limit'] == 'unlimited'){
									if ((int)$row['usage_count'] <= 20){
										echo " style='visibility:hidden;'";
									}
									echo ">".$row['usage_count']." people going";
								} else if ( $row['usage_limit'] != 'unlimited' && $row['usage_count'] < $row['usage_limit']) {
									echo ">".((int)$row['usage_limit'] - (int)$row['usage_count'])." out of ".$row['usage_limit']." remaining";
								}
								echo "</p><span id='responsetoevent' class='response'>";

								if ($row['attend_status'] == 'yes' && $row['requires_reservation'] == 'Y'){
									echo "<button class='smallbtn blacksmallbtn cancelreservation' name='cancel' value='".$row['promotion_id']."'";
									if (!empty($isSingleRow) && $isSingleRow) {
										echo " data-info='".$c."'";
									}
									echo ">Cancel Reservation</button>";

								} else if ( $row['usage_limit'] != 'unlimited' && $row['usage_limit'] <= $row['usage_count'] ){
									echo "<p class='boldtext'>Limit Reached</p>";
								} else {
									echo "<a name='yes'";
									if($row['requires_reservation'] == 'Y'){
										//onclick and show reservation form
										echo " id='reservationform'";
									} else if($row['requires_reservation'] == 'N'){
										//show enter # of people wanna to come 1)dropdown 2)inputbox
										echo " id='enternumberofpeople'";
									}
									if ($row['attend_status'] == 'yes') {
										echo " class='boldtext greenbar'";
									}
									echo ">Yes</a>
									<a name='maybe'";
									if ($row['attend_status'] == 'maybe'){
										echo " class='boldtext bluebar'";
									}
									echo ">Maybe</a>
								 	<a name='no'";
									if ($row['attend_status'] == 'no'){
										echo " class='boldtext redbar'";
									}
									echo ">No</a>";
								}

					echo	"</span>
						</td>
						</tr>";
						if($row['requires_reservation'] == 'Y'){
							//onclick and show reservation form
							echo "<tr id='makereservation_".$row['promotion_id']."' class='make-reservation'>
								<td>
									<p class='date' style='visibility:hidden;'>".$startDate."</p>
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
										  <span>Date:	</span>";
										  if($eventStartDateTime == $eventEndDateTime)	{
											  echo "<input type='text' id='eventdate_".$row['promotion_id']."' name='eventdate' class='calendar' value='".$eventStartDateTime."'/>";
										  } else {
											  echo "<input type='text' id='eventdate_".$row['promotion_id']."' name='eventdate' class='calendar showtime clickactivated future-date timerange' placeholder='Select Date/Time' value='".(($eventStartDateTime < $now) ? $now: $eventStartDateTime)."' data-end='".$endDate."' data-start='".$startDateForPicker."'/>";
										  }
									 	echo "</div>
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
												echo "<button id='makereservation' class='green btn' value='".$row['promotion_id']."'>Submit</button>
												<a class='";
													 if (!empty($isSingleRow) && $isSingleRow) {
														 echo "redirect'";
													 } else {
														 echo "closerow'";
													 }
													echo " value='".$row['promotion_id']."'>close</a>
										  </div>
									  </div>
							  </td>
							</tr>";
						} else if($row['requires_reservation'] == 'N'){
							//show enter # of people wanna to come 1)dropdown 2)inputbox
							echo "<tr id='makereservation_".$row['promotion_id']."' class='make-reservation'>
										<td>
											<p class='date' style='visibility:hidden;'>".$startDate."</p>
										</td>
										<td colspan='2'>
											<div id='numberofpeopleform'>
												<div>
													<span>Number in Party: </span>";
											if ($row['usage_limit'] == 'unlimited') {
												echo "<input type='text' id='numberinparty' class='textfield numbersonly' value='1' maxlength='2'/>";
											} else if ($row['usage_limit'] != 'unlimited' && $row['usage_limit'] > $row['usage_count']) {
												echo "<select id='numberinparty' data-limit='".$row['usage_limit']."'></select>";
											}
										echo "</div>
												<div>";
													if (!empty($isSingleRow) && $isSingleRow) {
														echo "<input id='info' type='hidden' value='".$c."'/>";
													}
													echo "<button id='makereservation' class='green btn' value='".$row['promotion_id']."'>Submit</button>
													<a class='";
			  											 if (!empty($isSingleRow) && $isSingleRow) {
			  												 echo "redirect'";
			  											 } else {
			  												 echo "closerow'";
			  											 }
			  											echo " value='".$row['promotion_id']."'>close</a>
												</div>
											</div>
										</td>
									</tr>";
						}

	}

	echo "</tbody></table>";

} else echo format_notice($this, "WARNING: There are no events.").$stopHtml;


?>
</body>
</html>
