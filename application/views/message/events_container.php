<table id="events-container">
	<tr>
		<td class='microform ignoreclear'>
			<div id="search-div">
				<table id="search-bar" class='list-scope'>
					<tr>
						<td>
							<input type="text" id="event-search" data-type="changes" name="searchphrase" class='optional submit-on-enter' data-targetbtn='events-filter-btn' placeholder="Search.." value=""/>
							<input type='hidden' id='resultsdiv' name='resultsdiv' value='eventlistdiv' />
							<input type='hidden' id='tempmessage' name='tempmessage' value='Loading results that meet your search criteria..' />
							<input type='hidden' id='action' name='action' value='<?php echo base_url()."message/get_event_list"; ?>' /></td>
						<td>
							<button id='events-search-btn' name='events-search-btn' class='btn green submitmicrobtn'>GO</button>
						</td>

						<td>
							<button id="events-filter-btn" name="events-filter-btn" class="btn blue hide-on-mobile">Filter</button>
						</td>

						<td>
							<div id='filter'>
								<table>
									<tr>
										<td class='row-divs'>
											<div>
												<select id='event__level1categories' name='event__level1categories' class='optional drop-down submit-on-enter' data-targetbtn='events-search-btn'><?php echo get_option_list($this, 'level1categories');?></select>
											</div>
											<input type='text' id='eventdate' name='eventdate' class='calendar showtime clickactivated optional future-date' placeholder="Select Date/Time"/>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div id="switch-div">
				<a href='javascript:;' class='drop-down-link' id='sort__switcheventslist'><?php echo $this->native_session->get('order_phrase')? $this->native_session->get('order_phrase'): 'Current';?></a>
			</div>
		</td>
	</tr>


	<tr>
		<td>
			<!-- Get the list of the events -->
			<div id="paginationdiv__eventssearch_list">
				<div id="eventlistdiv">
				<?php $this->load->view('message/events_list'); ?>
				</div>
				<div id="seemoreevents"><a>See More</a></div>
			</div>
		</td>
	</tr>
</table>
