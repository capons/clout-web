<?php
if (! empty ( $score ) && $score == '200') {
	?>


<!-- Offer 1 -->
															<div id="offer_001" class="bottombordergrey" style="padding: 10px;">
																<table width="100%" border="0" cellspacing="0" cellpadding="5">
																	<tr>
																		<td width="3%">
																			<table border="0" cellspacing="0" cellpadding="2" class="rewardcardbig darkgreybg">
																				<tr>
																					<td class="toprow"></td>
																				</tr>
																				<tr>
																					<td class="editbottomrow" nowrap>5%</td>
																				</tr>
																			</table>
																		</td>
																		<td align="left" class="pagesubtitle" style="padding-top: 5px; text-align: left;">Cash Back<a href="javascript:;" onClick="updateFieldLayer('<?php echo base_url()."promotion/edit_offer/i/".encrypt_value('001');?>','','','containerdiv','')"><img style="margin-top:-5px;" src="../assets/images/editPencil.png" width="20px" height="20px"/></a><br>
																			<span class="opensansmedium">200+ points</span>
																		</td>
																		<td width="30%" align="left" class="opensansmedium" nowrap>$14,021 gross sales during 21 days active</td>
																		<td width="1%" class="opensansmedium" style="min-width: 200px;"><span class="green">active</span></td>
																		<td width="1%" style="min-width: 100px;"><input type="button" name="pausebtn" id="pausebtn" value="Pause" class="forrestgreenbtn" style="width: 100px;"></td>
																	</tr>
																</table>
															</div>

															<!-- Offer 2 -->
															<div id="offer_002" class="bottombordergrey"
																style="padding: 10px;">
																<table width="100%" border="0" cellspacing="0" cellpadding="5">
																	<tr>
																		<td width="3%">
																			<table border="0" cellspacing="0" cellpadding="2" class="perkcardbig">
																				<tr>
																					<td class="toprow"></td>
																				</tr>
																				<tr>
																					<td class="bottomrow" nowrap>Perk</td>
																				</tr>
																			</table>
																		</td>
																		<td align="left" class="pagesubtitle"
																			style="padding-top: 5px; text-align: left;">VIP
																			Entrance<a href="javascript:;" onClick="updateFieldLayer('<?php echo base_url()."promotion/edit_offer/i/".encrypt_value('001');?>','','','containerdiv','')"><img style="margin-top:-5px;" src="../assets/images/editPencil.png" width="20px" height="20px"/></a><br> <span
																			class="opensansmedium">No cover charge and skip the
																				line. Up to 5 guests.</span>
																		</td>
																		<td align="left" class="opensansmedium" width="30%"
																			nowrap>21 customers during 3 days active</td>
																		<td width="1%" class="opensansmedium"
																			style="min-width: 200px;"><span class="grey">pending</span></td>
																		<td width="1%" style="min-width: 100px;">&nbsp;</td>
																	</tr>
																</table>
															</div>

															<!-- START Quick Edit -->
															<!-- START NEW CB -->
															<div id="offer_new_offer"
																class="bottombordergrey topborderThick"
																style="padding: 10px; cursor: pointer;"
																onClick="unhideShowLayer('offer_new_offer_edit','offer_new_offer')">
																<table width="100%" border="0" cellspacing="0"
																	cellpadding="5">
																	<tr>
																		<!-- CARD-->
																		<td width="3%">
																			<table border="0" cellspacing="0" cellpadding="2"
																				class="offercardbig">
																				<tr>
																					<td class="toprow"></td>
																				</tr>
																				<tr>
																					<td class="bottomrow"></td>
																				</tr>
																			</table>
																		</td>
																		<!-- TITLE-->
																		<td align="left" class="pagesubtitle"
																			style="padding-top: 5px; text-align: left; color: #c0c0c0;"
																			valign="top">Create a new Cash Back Offer!</td>
																	</tr>
																</table>
															</div>

															<!-- START NEW CB EDIT -->
															<div id="offer_new_offer_edit"
																class="bottombordergrey topborderThick"
																style="padding: 10px; display: none;">
																<table width="100%" border="0" cellspacing="0"
																	cellpadding="5">
																	<tr>
																		<!-- CARD-->
																		<td width="3%">
																			<table border="0" cellspacing="0" cellpadding="2"
																				class="offercardbig">
																				<tr>
																					<td class="toprow"></td>
																				</tr>
																				<tr>
																					<td class="bottomrow"></td>
																				</tr>
																			</table>
																		</td>
																		<!-- TITLE-->
																		<td align="left" valign="top" class="pagesubtitle"
																			style="padding-top: 5px; text-align: left;">Cash Back</td>
																		<!-- MIDDLE-->
																		<td align="left" class="opensansmedium" width="29%"><input
																			type="text" name="newcashback" id="newcashback"
																			value="" class="textfield" placeholder="0"
																			style="width: 120px; height: 30px; font-size: 10px; font-family: Verdana, Helvetica, sans-serif;"
																			onKeyUp="makeButtonActive('newcashback', 'savecashbackbtn', 'greybtn', 'greenbtn')">%</td>
																		<!-- BTNS-->
																		<td width="1%" style="min-width: 315px;" valign="top"><input type="button" name="optionsbtn" id="optionsbtn" value="Options" class="bluebtn" style="width: 100px; margin-right: 5px;" onClick="updateFieldLayer('<?php echo base_url()."promotion/edit_offer/i/".encrypt_value('001');?>','','','containerdiv','')"><input type="button" name="savecashbackbtn" id="savecashbackbtn" value="Save" class="greenbtn" style="width: 100px; margin-right: 5px;" onClick="unhideShowLayer('bankDeactivated','containerdiv')"><input type="button" name="cancelcashbackbtn" id="cancelcashbackbtn" value="Cancel" class="greybtn" style="width: 100px;"onClick="unhideShowLayer('offer_new_offer','offer_new_offer_edit')"></td>
																	</td>
																	</tr>
																</table>
															</div>
															<!-- END NEW CB -->

															<!-- START NEW PERK -->
															<div id="offer_new_perk" class="bottombordergrey"
																style="padding: 10px; cursor: pointer;"
																onClick="unhideShowLayer('offer_new_perk_edit','offer_new_perk')">
																<table width="100%" border="0" cellspacing="0"
																	cellpadding="5">
																	<tr>
																		<!-- CARD -->
																		<td width="3%">
																			<table border="0" cellspacing="0" cellpadding="2"
																				class="offercardbig">
																				<tr>
																					<td class="toprow"></td>
																				</tr>
																				<tr>
																					<td class="bottomrow"></td>
																				</tr>
																			</table>
																		</td>
																		<!-- TITLE -->
																		<td align="left" class="pagesubtitle"
																			style="padding-top: 5px; text-align: left; color: #c0c0c0">Create
																			a new Perk!</td>
																	</tr>
																</table>
															</div>

															<!-- START NEW PERK EDIT -->
															<div id="offer_new_perk_edit" class="bottombordergrey"
																style="padding: 10px; display: none;">
																<table width="100%" border="0" cellspacing="0"
																	cellpadding="5">
																	<tr>
																		<!-- CARD -->
																		<td width="3%" valign="top">
																			<table border="0" cellspacing="0" cellpadding="2"
																				class="offercardbig">
																				<tr>
																					<td class="toprow"></td>
																				</tr>
																				<tr>
																					<td class="bottomrow"></td>
																				</tr>
																			</table>
																		</td>
																		<!-- TITLE-->
																		<td align="left" valign="top" class="pagesubtitle"
																			style="padding-top: 5px; text-align: left;">New Perk</td>
																		<!-- MIDDLE-->
																		<td align="left" class="opensansmedium" width="29%"
																			style="font-size: 10px;"><input type="text"
																			name="perktitle" id="perktitle" value=""
																			class="textfield"
																			placeholder="Perk Title (e.g., VIP Entrance)"
																			style="width: 300px; height: 30px; font-size: 10px; font-family: Verdana, Helvetica, sans-serif;"
																			onKeyUp="makeButtonActive('perktitle<>perkdescription', 'saveperkbtn', 'greybtn', 'greenbtn')">
																			<textarea class="textfield" name="perkdescription"
																				id="perkdescription"
																				onKeyUp="makeButtonActive('perktitle<>perkdescription', 'saveperkbtn', 'greybtn', 'greenbtn')"
																				style="width: 300px; height: 80px; font-size: 10px; font-family: Verdana, Helvetica, sans-serif;"
																				placeholder="Perk Description (e.g., Free VIP entrance and complimentary first round of drinks. Advance reservations recommended.)"></textarea><br>
																			<input type="radio" name="reservationrequirements[]"
																			id="checkin_on_arrival" value="checkin_on_arrival"
																			checked> Check in on arrival<br> <input type="radio"
																			name="reservationrequirements[]"
																			id="reservation_required"
																			value="reservation_required"> Reservation required<br><input type="checkbox"
																			name="eventCheck"
																			id="eventCheck"
																			value=""> Is this an event?</td>
																		<!-- BTNS-->
																		<td width="1%" style="min-width: 315px;" valign="top"><input value="Options" class="bluebtn" style="width: 100px; margin-right: 5px;" onClick="updateFieldLayer('<?php echo base_url()."promotion/edit_offer/i/".encrypt_value('001');?>','','','containerdiv','')"><input type="button" name="saveperkbtn" id="saveperkbtn" value="Save" class="greenbtn" style="width: 100px; margin-right: 5px;" onClick="unhideShowLayer('bankActivated','containerdiv')"><input type="button" name="cancelperkbtn" id="cancelperkbtn" value="Cancel" class="greybtn" style="width: 100px;" onClick="unhideShowLayer('offer_new_perk','offer_new_perk_edit')"></td>
																	</tr>
																</table>
															</div>
															<!-- END NEW PERK -->
															<!-- END Quick Edit -->
														





<?php
}
?>


