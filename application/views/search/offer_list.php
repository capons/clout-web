<?php 
if(empty($offers['cashback']) && empty($offers['perk'])){
	$this->load->view('search/request_offers');

} else {
?>
<table style="width:100%; border:0">
            <tr>
              <td class="blacksectionheader" style="font-size:16px;">Get cash back when you pay using any linked card..</td>
              </tr>
             <tr>
             <td>
       <?php
		$offerDivArray = array();
		if(!empty($offers['cashback']))
		{
			foreach($offers['cashback'] AS $row)
			{
				array_push($offerDivArray,'offer_'.$row['id']);
			}
		}
		
		if(!empty($offers['perk']))
		{
			foreach($offers['perk'] AS $row)
			{
				array_push($offerDivArray,'offer_'.$row['id']);
			}
		}
		$this->native_session->set('all_divs', $offerDivArray);
		 
		#Do if there are any cashback offers
		if(!empty($offers['cashback']))
		{
			 foreach($offers['cashback'] AS $offer)
			 {
				 echo "<div id='offer_".$offer['id']."' style='background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;'><table border='0' cellspacing='5' cellpadding='0' style='width:100%;cursor:pointer;'";
				 
				 if($hasRemainingPoints == 'Y'){
					 echo " onClick=\"toggleLayer('offer_".$offer['id']."_details', '".base_url()."search/offer_details/i/".encrypt_value($offer['id'])."/t/cashback', '<img src=\'".base_url()."assets/images/down_arrow_single_light_grey.png\'>', '<img src=\'".base_url()."assets/images/next_arrow_single_light_grey.png\'>', 'offer_".$offer['id']."_arrow_cell', '', '', '');toggleLayersOnCondition('offer_".$offer['id']."_details', '".implode('<>', remove_item('offer_'.$offer['id'], $this->native_session->get('all_divs')))."');\"";
				 }
				 
				 echo ">
    <tr>
      <td rowspan='2' style='width:80px;vertical-align:top;'><div class='reward-wrapper'><div class='cashback'><span>".$offer['amount']."%</span></div></div></td>
      <td class='h3 bold' style='width:calc(100% - 105px);'>Cash Back</td>
      <td rowspan='2' style='text-align:center; vertical-align:middle; width:25px;' id='offer_".$offer['id']."_arrow_cell'>".($hasRemainingPoints == 'Y'? "<img src='".base_url()."assets/images/next_arrow_single_light_grey.png'>": '&nbsp;')."</td>
      </tr>
    <tr>
      <td class='smallarial'>".$offer['description']."</td>
      </tr>
    </table>
    
    <div id='offer_".$offer['id']."_details' style='display:none;'></div>
  </div>";
			 }
		}
		
		
		#Do if there are any cashback offers
		if(!empty($offers['perk']))
		{
			 foreach($offers['perk'] AS $offer)
			 {
				 echo "<div id='offer_".$offer['id']."' style='background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;'><table border='0' cellspacing='5' cellpadding='0' style='cursor:pointer;width:100%;'";
				 
				 if($hasRemainingPoints == 'Y'){
					 echo " onClick=\"toggleLayer('offer_".$offer['id']."_details', '".base_url()."search/offer_details/i/".encrypt_value($offer['id'])."/t/perk', '<img src=\'".base_url()."assets/images/down_arrow_single_light_grey.png\'>', '<input type=\'button\' name=\'use_offer_".$offer['id']."\' id=\'use_offer_".$offer['id']."\' class=\'btn green\' style=\'min-width:60px;\' value=\'Use\'>', 'offer_".$offer['id']."_arrow_cell', '', '', '');toggleLayersOnCondition('offer_".$offer['id']."_details', '".implode('<>', remove_item('offer_'.$offer['id'], $this->native_session->get('all_divs')))."');\"";
				 }
				 
				 echo ">
    <tr>
      <td rowspan='2' style='width:80px;vertical-align:top;'><div class='reward-wrapper'><div class='perk' style='margin-left: 5px;'><span>Perk</span></div></div></td>
      <td class='h3 bold' style='width:calc(100% - 105px);'>".$offer['name']."</td>
      <td rowspan='2' style='width:25px;vertical-align:top;' id='offer_".$offer['id']."_arrow_cell'>".($hasRemainingPoints == 'Y'? "<input type='button' name='use_offer_".$offer['id']."' id='use_offer_".$offer['id']."' class='btn green' style='min-width:60px;' value='Use'>": '&nbsp;')."</td>
      </tr>
    <tr>
      <td class='smallarial'>".htmlentities($offer['description'], ENT_QUOTES)."</td>
      </tr>
    </table>
    
    <div id='offer_".$offer['id']."_details' style='display:none;'></div>
  </div>";
			 }
		}
		
?>

             </td>
             </tr>
        </table>
        
<?php }?>