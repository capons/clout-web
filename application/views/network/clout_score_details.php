<?php
$systemColors = unserialize(SYSTEM_COLORS);
?><table style='border-top: solid 1px #CCC; border-bottom: solid 4px #18C93E; width:100%;'>
   <tr><td style="padding:5px;">Your current commission is <span style="font-weight:700;color:#333;"><?php echo format_number($pageStats['my_current_commission'],2);?>%</span></td>
</table>
       
       
       
       
<table class='normal-table' style="width:calc(100% - 20px); margin:10px; border:none; margin-right: auto; margin-left: auto;">
  <tr><td class="score-cell" id='score_table_cell' style="min-width:90px;min-height:80px; width:190px; height: 180px;"><div class='show-on-mobile' id="donutchartsmall"><span class='score'><?php echo format_number($pageStats['clout_score'],5,0);?></span><span class='score-label'>Store Score</span></div>&nbsp;</td>

<td><span class='h4'>Member Level</span>
<br /><input type='text' id='level' name='level' class='smalltextfield' style="min-width:40px;width:100%;" value='<?php echo 'Level '.$pageStats['clout_score_level'];?>' readonly="readonly" />
<br />
<br />
<span class='h4'>Commission</span>
<br /><input type='text' id='commission' name='commission' class='smalltextfield' style="min-width:40px;width:100%;" value='<?php echo format_number($pageStats['my_current_commission'],2).'%';?>' readonly="readonly" /></td>

<td class="dark-green-bg h3 white" style="max-width: 130px;"><?php 
		if($pageStats['points_to_next_level'] > 0){
			echo "Just ".format_number($pageStats['points_to_next_level'],5,0)." more points to reach Level ".($pageStats['clout_score_level']+1)." rewards.";
		} else {
			echo "You currently have the maximum allowable level.";
		}
		?></td>
</tr>
</table>    
       
       
       
       
<table style="width:calc(100% - 20px);margin:10px;border:1px solid #CCC; border:none;">
            
            <tr>
              <td>
              <?php
			  #The categorized score details
			  
			  #Specify the categories as expected
			  $categories = array();
			  $categories['clout_score_profile_setup'] = array('id'=>'profile_setup', 'title'=>'Account Setup', 'image'=>'in_store_icon.png', 'color'=>'#000');
			  $categories['clout_score_network_size_growth'] = array('id'=>'network_size_growth', 'title'=>'Referrals', 'image'=>'linked_account_icon.png', 'color'=>'#0AC298');
			  $categories['clout_score_network_spending'] = array('id'=>'network_spending', 'title'=>'Spending of My Referrals', 'image'=>'preferences_icon.png', 'color'=>'#18C93E');
			  $categories['clout_score_overall_spending'] = array('id'=>'overall_spending', 'title'=>'Spending', 'image'=>'category_icon.png', 'color'=>'#6D76B5');
			  $categories['clout_score_ad_related_spending'] = array('id'=>'ad_related_spending', 'title'=>'Ad Related Spending', 'image'=>'related_category_icon.png', 'color'=>'#2DA0D1');
			  $categories['clout_score_linked_accounts'] = array('id'=>'linked_accounts', 'title'=>'Linked Accounts', 'image'=>'world_icon.png', 'color'=>'#03BFCD');
			  
			  $breakdownRow['total_score'] = !empty($breakdownRow['total_score'])? $breakdownRow['total_score']: 1;
			  
			  #Get the category ids
			  $ids = array();
			  foreach($categories AS $row)
			  {
				  array_push($ids, $row['id']);
			  }
			  #Get the biggest score in the system
			  $maxScore = 1;
			  foreach($pageStats['clout_score_breakdown'] AS $breakdownRow)
			  {
				  $maxScore = (!empty($breakdownRow['max_total_score']) && ($breakdownRow['max_total_score']+0) > $maxScore)? $breakdownRow['max_total_score']: $maxScore;
			  }
			  
			  #Now format and display the categories as desired
			  foreach($categories AS $key=>$rowDetails)
			  {
				  $breakdownRow = $pageStats['clout_score_breakdown'][$key]; 
				  $containerWidth = format_number(((100*$breakdownRow['max_total_score'])/$maxScore), 3,0);
				  $filledWidth = format_number(((100*$breakdownRow['total_score'])/(!empty($breakdownRow['max_total_score'])?$breakdownRow['max_total_score']:1)), 3,0);
				  $unfilledWidth = 100 - $filledWidth;
				    
				  echo "<div id='".$rowDetails['id']."' style='background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left; display:block;width:100%;' ><table border='0' cellspacing='5' cellpadding='0' style='cursor:pointer;width:100%;' onClick=\"toggleLayer('".$rowDetails['id']."_details', '', '<img src=\'".IMAGE_URL."down_arrow_single_light_grey.png\'>', '<img src=\'".IMAGE_URL."next_arrow_single_light_grey.png\'>', '".$rowDetails['id']."_arrow_cell', '', '', '');toggleLayersOnCondition('".$rowDetails['id']."_details', '".implode('<>', array_diff($ids, array($rowDetails['id'])))."');\">
                <tr>
                  <td rowspan='2' style='width:50px;'><img src='".IMAGE_URL.$rowDetails['image']."'></td>
                  <td class='greycategoryheader' style='width:calc(100% - 75px);'>".$rowDetails['title']."</td>
                  <td rowspan='2' style='text-align:center; vertical-align:middle; width:25px;' id='".$rowDetails['id']."_arrow_cell'><img src='".IMAGE_URL."next_arrow_single_light_grey.png'></td>
                  </tr>
                <tr>
                  <td><table width='".$containerWidth."%' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='99%'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                          <td width='".$filledWidth."%' style='background-color: ".$rowDetails['color'].";text-align:right;padding-right:5px;'><span style=\"color:#FFF;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600;\">".format_number($breakdownRow['total_score'],4,0)."</span></td>
                          <td width='".$unfilledWidth."%' style='background-color: #C1C1C1;'>&nbsp;</td>
                        </tr>
                      </table></td>
                      <td width='1%' style=\"padding-left:2px;color:#9D9D9D;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600; line-height:0px;\">".$breakdownRow['max_total_score']."</td>
                    </tr>
                  </table></td>
                  </tr>
                </table>
                
                
                <div id='".$rowDetails['id']."_details' style='display:none;'>
				".$breakdownRow['description']."
<br><br>
<span class='label'>".format_number($breakdownRow['total_score'],4,0)." points out of ".format_number($breakdownRow['max_total_score'],4,0)."</span> 

				</div>
  </div>";
			  }
			  ?>
              
              
                
  </td>
              </tr>
            </table>

