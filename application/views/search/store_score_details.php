<table style="width:100%; border:0">
            
            <tr>
              <td>
              <?php
			  #The categorized score details
			  
			  #Specify the categories as expected
			  $categories = array();
			  $categories['store_score_same_store_spending'] = array('id'=>'same_store_spending', 'title'=>'Same Store Spending', 'image'=>'in_store_icon.png', 'color'=>'#000');
			  $categories['store_score_same_chain_spending'] = array('id'=>'same_chain_spending', 'title'=>'Same Chain Spending', 'image'=>'in_chain_icon.png', 'color'=>'#000');
			  $categories['store_score_competitor_spending'] = array('id'=>'competitor_spending', 'title'=>'Competitor Spending', 'image'=>'competitor_icon.png', 'color'=>'#8566AB');
			  $categories['store_score_category_spending'] = array('id'=>'category_spending', 'title'=>'Category Spending', 'image'=>'category_icon.png', 'color'=>'#6D76B5');
			  $categories['store_score_related_category_spending'] = array('id'=>'related_category_spending', 'title'=>'Related Category Spending', 'image'=>'related_category_icon.png', 'color'=>'#2DA0D1');
			  $categories['store_score_overall_spending'] = array('id'=>'overall_spending', 'title'=>'Overall Spending', 'image'=>'world_icon.png', 'color'=>'#03BFCD');
			  $categories['store_score_linked_accounts'] = array('id'=>'linked_accounts', 'title'=>'Linked Accounts', 'image'=>'linked_account_icon.png', 'color'=>'#0AC298');
			  $categories['store_score_activity'] = array('id'=>'activity', 'title'=>'Activity', 'image'=>'preferences_icon.png', 'color'=>'#18C93E');
			  
			  $breakdownRow['total_score'] = !empty($breakdownRow['total_score'])? $breakdownRow['total_score']: 1;
			  
			  #Get the category ids
			  $ids = array();
			  foreach($categories AS $row)
			  {
				  array_push($ids, $row['id']);
			  }
			  #Get the biggest score in the system
			  $maxScore = 1;
			  foreach($store_score_breakdown AS $breakdownRow)
			  {
				  $maxScore = (!empty($breakdownRow['max_total_score']) && ($breakdownRow['max_total_score']+0) > $maxScore)? $breakdownRow['max_total_score']: $maxScore;
			  }
			  
			  #Now format and display the categories as desired
			  foreach($categories AS $key=>$rowDetails)
			  {
				  $breakdownRow = (!empty($store_score_breakdown[$key])? $store_score_breakdown[$key]: array()); 
				  $containerWidth = (!empty($breakdownRow['max_total_score'])? format_number(((100*$breakdownRow['max_total_score'])/$maxScore), 3): 0);
				  $filledWidth = (!empty($breakdownRow['total_score'])? format_number(((100*$breakdownRow['total_score'])/(!empty($breakdownRow['max_total_score'])?$breakdownRow['max_total_score']:1)), 3): 0);
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
                          <td width='".$filledWidth."%' style='background-color: ".$rowDetails['color'].";text-align:right;padding-right:5px;'><span style=\"color:#FFF;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600;\">".(!empty($breakdownRow['total_score'])? format_number($breakdownRow['total_score'],4,0): '&nbsp;')."</span></td>
                          <td width='".$unfilledWidth."%' style='background-color: #C1C1C1;'>&nbsp;</td>
                        </tr>
                      </table></td>
                      <td width='1%' style=\"padding-left:2px;color:#9D9D9D;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600; line-height:0px;\">".(!empty($breakdownRow['max_total_score'])? $breakdownRow['max_total_score']: '&nbsp;')."</td>
                    </tr>
                  </table></td>
                  </tr>
                </table>
                
                
                <div id='".$rowDetails['id']."_details' style='display:none;'>
				".(!empty($breakdownRow['description'])? $breakdownRow['description']: '&nbsp;')."
<br><br>
<span class='label'>".(!empty($breakdownRow['total_score']) ? format_number($breakdownRow['total_score'],4,0): 0)." points out of ".(!empty($breakdownRow['max_total_score'])? format_number($breakdownRow['max_total_score'],4,0): 0)."</span> 

				</div>
  </div>";
			  }
			  ?>
              
              
                
  </td>
              </tr>
            </table>
