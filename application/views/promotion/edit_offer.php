<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="padding: 10px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="5">
				<tr>
					<td width="3%">
						<table border="0" cellspacing="0" cellpadding="2"
							class="rewardcardbig greenbg">
							<tr>
								<td class="toprow"></td>
							</tr>
							<tr>
								<td class="editbottomrow" nowrap>5%</td>
							</tr>
						</table>
					</td>
					<td align="left" class="pagesubtitle"
						style="padding-top: 5px; text-align: left;">Cash Back<br>
						<span class="opensansmedium">200+ points</span>
                        </td>
                        
                        <!-- MIDDLE-->
						<td align="left" class="opensansmedium" width="29%"><input
                        type="text" name="newcashback" id="newcashback"
                        value="" class="textfield" placeholder="0"
                        style="width: 120px; height: 30px; font-size: 10px; font-family: Verdana, Helvetica, sans-serif;"
                        onKeyUp="makeButtonActive('newcashback', 'savecashbackbtn', 'greybtn', 'greenbtn')">%</td>

                    
                    
					
					<td width="1%" style="min-width: 100px;"><input type="button" name="savebtn" id="savebtn" value="Save" class="forrestgreenbtn" style="width: 100px;" onClick="updateFieldLayer('<?php echo base_url()."promotion/update_promotion_by_score/t/".encrypt_value('200');?>','','','containerdiv','')"></td>
					<td width="1%" style="min-width: 100px;"><input type="button" name="deletebtn" id="deletebtn" value="Cancel" class="greybtn" style="width: 100px; margin-left: 5px;" onClick="updateFieldLayer('<?php echo base_url()."promotion/update_promotion_by_score/t/".encrypt_value('200');?>','','','containerdiv','')"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding-top: 10px; padding-left: 0px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="tabgroup" style="padding-left: 10px; text-align: left;">
						<div id="locations_tab" class="currenttabcell" onClick="updateTabColors('locations_tab','currenttabcell','tabcell');updateFieldLayer('<?php echo base_url()."promotion/show_edit_fields/t/".encrypt_value('locations');?>','','','tab_content_div','');">Locations</div>
						<div id="runtime_tab" class="tabcell" onClick="updateTabColors('runtime_tab','currenttabcell','tabcell');updateFieldLayer('<?php echo base_url()."promotion/show_edit_fields/t/".encrypt_value('runtime');?>','','','tab_content_div','')">Run time</div>
						<div id="daystimes_tab" class="tabcell" onClick="updateTabColors('daystimes_tab','currenttabcell','tabcell');updateFieldLayer('<?php echo base_url()."promotion/show_edit_fields/t/".encrypt_value('blackouts');?>','','','tab_content_div','')">Blackouts</div>
					    <div id="qrcode_tab" class="righttab tabcell" onClick="updateTabColors('qrcode_tab','currenttabcell','tabcell');updateFieldLayer('<?php echo base_url()."promotion/show_edit_fields/t/".encrypt_value('qrcode');?>','','','tab_content_div','')">QR Code</div>
					</td>
				</tr>
				<tr>
                    
                    
                    
                    
                    
					<td class="tabcontent" style="border-top: solid 1px #CCC; color: #333;">
						<div id="tab_content_div">
                            <!-- START TABBED CONTENT -->
                            <div class="tabContent">
                                <!-- START LEFT TABBED CONTENT -->
                                <div class="tabLeft">        
                                    <input type="radio" id="alllocations_yes" name="alllocations[]" value="no" style="vertical-align:sub;" onClick="hideLayerSet('locations_specific')" checked><span>All my stores</span> 
                                    <input type="radio" id="alllocations_no" name="alllocations[]" value="yes" style="vertical-align:sub; margin-left:15px;" onClick="showLayerSet('locations_specific')"><span>Select specific stores</span>
                                </div>

                                <!-- START HIDDEN CONTENT -->    
                                <div id="locations_specific" style="display: none;">
                                    <!-- START DOWN TABBED CONTENT -->
                                    <div class="tabDown" style="padding:10px 0 10px 10px;">  
                                        <span class="formHeader">View locations by:</span> 
                                        <input type="text" name="locationsearch" id="locationsearch" value="" placeholder="Search in locations" class="searchfield" style="width: 200px; margin-right:15px;">

                                        <span class="formHeader">or select from:</span>
                                        <input type="radio" id="locationsview_all" name="locationsview[]" value="all" style="vertical-align:sub; margin-left:15px;" >All
                                        <input type="radio" id="locationsview_country" name="locationsview[]" value="country" style="vertical-align:sub; margin-left:15px;" >Country
                                        <input name="locationsview[]" type="radio" id="locationsview_state" value="state" style="vertical-align:sub; margin-left:15px;" checked>State
                                        <input type="radio" id="locationsview_city" name="locationsview[]" value="city" style="vertical-align:sub; margin-left:15px;" >City
                                    </div>

                                    <!-- START DOWN TABBED CONTENT -->
                                    <div class="tabDown" style="padding:10px 0 8px 0;">

                                        <span class="tabDown" style="display:block; border:none; padding-bottom:0px;">
                                            <input type="checkbox" id="selectallcheck" name="selectallcheck" value="all" style="vertical-align:sub;" onClick="selectAll(this,'statelist')">Select all       
                                            <input name="statelist" id="statelist" type="hidden" value="al|ak|il|in|az|ar|ca|co|ct|de|fl|ga|hi|id|ks">
                                        </span>

                                        <span class="tabDown" style="border:none;">
                                            <input type="checkbox" id="al" name="states[]" value="AL" style="vertical-align:sub;">Alabama (2)</BR>
                                            <input type="checkbox" id="ak" name="states[]" value="AK" style="vertical-align:sub;">Alaska (1)</BR>
                                            <input type="checkbox" id="il" name="states[]" value="IL" style="vertical-align:sub;">Illinois (16)</BR>
                                            <input type="checkbox" id="in" name="states[]" value="IN" style="vertical-align:sub;">Indiana (3)
                                        </span>

                                        <span class="tabDown" style="border:none;">
                                            <input type="checkbox" id="az" name="states[]" value="AZ" style="vertical-align:sub;">Arizona</BR>
                                            <input type="checkbox" id="ar" name="states[]" value="AR" style="vertical-align:sub;">Arkansas (5)</BR>
                                            <input name="states[]" type="checkbox" id="ca" value="CA" style="vertical-align:sub;" checked> California (3)</BR>
                                            <input type="checkbox" id="co" name="states[]" value="CO" style="vertical-align:sub;">Colorado (6)
                                        </span>

                                        <span class="tabDown" style="border:none;">
                                            <input type="checkbox" id="ct" name="states[]" value="CT" style="vertical-align:sub;">Connecticut (11)</BR>
                                            <input type="checkbox" id="de" name="states[]" value="DE" style="vertical-align:sub;">Delaware (2)</BR>
                                            <input type="checkbox" id="fl" name="states[]" value="FL" style="vertical-align:sub;">Florida (17)</BR>
                                            <input type="checkbox" id="ga" name="states[]" value="GA" style="vertical-align:sub;">Georgia (9)
                                        </span>

                                        <span class="tabDown" style="border:none;">
                                            <input type="checkbox" id="hi" name="states[]" value="HI" style="vertical-align:sub;">Hawaii (7)</BR>
                                            <input type="checkbox" id="id" name="states[]" value="ID" style="vertical-align:sub;">Idaho (3)</BR>
                                            <input type="checkbox" id="ks" name="states[]" value="KS" style="vertical-align:sub;">Kansas (2)    
                                        </span> 

                                    </div> 

                                    <!-- START DOWN TABBED CONTENT -->
                                    <div class="tabDown" style="padding:10px 0 8px 0;"> 

                                        <span class="tabDown" style="display:block; border:none; padding-bottom:0px;">
                                            <input type="checkbox" id="selectallcheck" name="selectallcheck" value="all" style="vertical-align:sub;" onClick="selectAll(this,'addresslist')">Select all
                                            <input name="addresslist" id="addresslist" type="hidden" value="address_001|address_002|address_003">
                                        </span>	

                                        <span class="tabDown" style="border:none;">
                                            <input type="checkbox" id="address_001" name="address[]" value="001" style="vertical-align:sub;">125 St. Francis Drive, Los Angeles CA 90035</BR>
                                            <input type="checkbox" id="address_002" name="address[]" value="002" style="vertical-align:sub;">75 Rodeo Blvd, Beverly Hills CA 90210</BR>										
                                            <input type="checkbox" id="address_003" name="address[]" value="003" style="vertical-align:sub;">575 San Vicente Blvd, Los Angeles CA 90036
                                        </span>

                                    </div>



                                </div>
                                <!-- END HIDDEN CONTENT -->  
                            </div>
                            <!-- END TABBED CONTENT -->  
						</div>
					</td>
                    
                    
                    
                    
                    
				</tr>
			</table>
		</td>
	</tr>
</table>