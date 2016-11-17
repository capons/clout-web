<table style="width:100%; border:0; margin-top:15px;">
<tr><td nowrap>

<table style="width:100%; border:none;  margin-right: auto; margin-left: auto;" id="tabtable" class="tabtable">
<?php 
			$trFirst = $trSecond = "<tr>";
			
			foreach($storeScoreDetails['store_score_level_data'] AS $level)
			{
				# Does the user's score qualify in this range?
			  	if((!empty($level['low_end_score']) && !empty($storeScoreDetails['store_score'])
			  		&& (format_number($storeScoreDetails['store_score'],4,0) - $level['low_end_score']) >= 0)
			 	|| ($level['level'] == '0')
				){  
			  	  	$hasRemainingPoints = 'Y';
			  	} else {
				  	$hasRemainingPoints = 'N';
			  	}
				
				
				
				
				#The first table row
				$trFirst .= "<td id='level_".$level['level']."_top' style='border-top: 4px solid #".$level['color'].";'  onClick=\"hideTabsAndDisplayThis('level_".$level['level']."_tab','".$storeScoreDetails['storeId']."__".$storeScoreDetails['store_score_level']."__".$isOnVip."__".$hasRemainingPoints.
				
				($storeScoreDetails['store_score_level'] < $level['level']? "__".($level['low_end_score']-format_number($storeScoreDetails['store_score'],4,0)): "")
				
				."')\" onMouseOver=\"hideTabsAndDisplayBg('level_".$level['level']."')\"><div id='level_".$level['level']."_tab' class='innertablayer' style='background-color:#".$level['color']."; display:".($storeScoreDetails['store_score_level'] == $level['level']? 'block': 'none').";' title='level ".$level['level']." Offers'><table border='0' cellspacing='0' cellpadding='0' align='center' class='innertabtable'>
              <tr><td class='toprow'>".($storeScoreDetails['store_score_level'] == $level['level']? ($storeScoreDetails['store_score'] > 1000? '1000': format_number($storeScoreDetails['store_score'],4,0)): $level['low_end_score']).(empty($level['high_end_score'])? '+': '')."</td></tr>
			  
              <tr><td>".(!empty($level['max_cashback'])? ($level['max_cashback'] != $level['min_cashback']? $level['min_cashback'].'%-'.$level['max_cashback'].'%': $level['min_cashback']): $level['min_cashback'].'%')."</td></tr>
              </table></div>".($storeScoreDetails['store_score_level'] == $level['level']? format_number($storeScoreDetails['store_score'],4,0): $level['low_end_score']).(empty($level['high_end_score'])? '+': '')."</td>";
			  
			  
			  
			  
			  #The second table row
			  $trSecond .= "<td id='level_".$level['level']."_bottom'  onClick=\"hideTabsAndDisplayThis('level_".$level['level']."_tab','".$storeScoreDetails['storeId']."__".$storeScoreDetails['store_score_level']."__".$isOnVip."__".$hasRemainingPoints.
				
				($storeScoreDetails['store_score_level'] < $level['level']? "__".($level['low_end_score']-format_number($storeScoreDetails['store_score'],4,0)): "")
				
				."')\" onMouseOver=\"hideTabsAndDisplayBg('level_".$level['level']."')\" style='font-size:10.3px;'>".(!empty($level['max_cashback'])? ($level['max_cashback'] != $level['min_cashback']? $level['min_cashback'].'%-'.$level['max_cashback'].'%': $level['min_cashback'].'%'): $level['min_cashback'].'%');
			 
			  $trSecond .= $level['level'] == '0'? "<input name='currentlevelvalue' id='currentlevelvalue' type='hidden' value='level_".$storeScoreDetails['store_score_level']."'>": '';
			   $trSecond .= "</td>";
			  
			  
			  
			  #Get the current cashback range
			  if($storeScoreDetails['store_score_level'] == $level['level'])
			  {
			  	$storeScoreDetails['min_cashback'] = $level['min_cashback'];
			  	$storeScoreDetails['max_cashback'] = $level['max_cashback'];
			  }
			  
			  #Get the next points remaining for the next level
			  if($level['level'] == ($storeScoreDetails['store_score_level']+1))
			  {
				  $storeScoreDetails['remaining_points'] = $level['low_end_score'] - format_number($storeScoreDetails['store_score'],4,0);
			}
			}
			$trFirst .= "</tr>";
			$trSecond .= "</tr>";
			
			echo $trFirst.$trSecond;
			?>
</table>



</td></tr>
<tr><td style="padding-top:15px;">
        




<div id="offer_list"><?php 
if(empty($offers['cashback']) && empty($offers['perk'])){
	$this->load->view('search/request_offers', array('isOnVip'=>$isOnVip));
} else {
	$this->load->view('search/offer_list', array('offers'=>$offers));
}
?></div>





</td></tr>
</table>