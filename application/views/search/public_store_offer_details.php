<table width="100%" border="0" cellspacing="0" style="margin-top:15px;">
<tr><td nowrap>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="tabtable" class="tabtable">
<?php 
			$trFirst = $trSecond = "<tr>";
			

			foreach($storeScoreDetails['store_score_level_data'] AS $level)
			{
				# Does the user's score qualify in this range?
			  	$hasRemainingPoints = 'Y';

				#The first table row
				$trFirst .= "<td id='level_".$level['level']."_top' style='border-top: 4px solid #".$level['color'].";'  onClick=\"hideTabsAndDisplayThis('level_".$level['level']."_tab','".$storeScoreDetails['storeId']."__30__".$isOnVip."__".$hasRemainingPoints.
				
				(30 < $level['level']? "__".($level['low_end_score']-format_number(30,4,0)): "")
				
				."')\" onMouseOver=\"hideTabsAndDisplayBg('level_".$level['level']."')\"><div id='level_".$level['level']."_tab' class='innertablayer' style='background-color:#".$level['color']."; display:".(30 == $level['level']? 'block': 'none').";' title='level ".$level['level']." Offers'><table border='0' cellspacing='0' cellpadding='0' align='center' class='innertabtable'>
              <tr><td class='toprow'>".(30 == $level['level']? (30 > 1000? '1000': format_number(30,4,0)): $level['low_end_score']).(empty($level['high_end_score'])? '+': '')."</td></tr>
			  
              <tr><td>".(!empty($level['max_cashback'])? ($level['max_cashback'] != $level['min_cashback']? $level['min_cashback'].'%-'.$level['max_cashback'].'%': $level['min_cashback']): $level['min_cashback'].'%')."</td></tr>
              </table></div>".(30 == $level['level']? format_number(30,4,0): $level['low_end_score']).(empty($level['high_end_score'])? '+': '')."</td>";
			  
			  
			  
			  
			  #The second table row
			  $trSecond .= "<td id='level_".$level['level']."_bottom'  onClick=\"hideTabsAndDisplayThis('level_".$level['level']."_tab','".$storeScoreDetails['storeId']."__30__".$isOnVip."__".$hasRemainingPoints.
				
				(30 < $level['level']? "__".($level['low_end_score']-format_number(30,4,0)): "")
				
				."')\" onMouseOver=\"hideTabsAndDisplayBg('level_".$level['level']."')\" style='font-size:10.3px;'>".(!empty($level['max_cashback'])? ($level['max_cashback'] != $level['min_cashback']? $level['min_cashback'].'%-'.$level['max_cashback'].'%': $level['min_cashback'].'%'): $level['min_cashback'].'%');
			 
			  $trSecond .= $level['level'] == '0'? "<input name='currentlevelvalue' id='currentlevelvalue' type='hidden' value='level_30'>": '';
			   $trSecond .= "</td>";
			  
			  
			  
			  #Get the current cashback range
			  if(30 == $level['level'])
			  {
			  	$storeScoreDetails['min_cashback'] = $level['min_cashback'];
			  	$storeScoreDetails['max_cashback'] = $level['max_cashback'];
			  }
			  
			  #Get the next points remaining for the next level
			  if($level['level'] == (30+1))
			  {
				  $storeScoreDetails['remaining_points'] = $level['low_end_score'] - format_number(30,4,0);
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