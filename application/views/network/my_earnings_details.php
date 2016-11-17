<table style="width:100%;">
<tr><td class='center-all' style="padding-bottom:15px;" onmouseover="copyScoreChart('hidden_score_div', 'score_table_cell');">


<table style="width:100%; border:none; padding:10px; margin-right: auto; margin-left: auto;">
        <tr><td colspan="4" style="padding-bottom:0px;"><span class="whiteheadertitle green">Your Earnings</span><br>
The last commission you earned was <?php echo (!empty($pageStats['last_time_commission_was_earned'])?format_date_interval($pageStats['last_time_commission_was_earned'], '', FALSE, 'years'): '0 days');?> ago.</td></tr>
        <tr>
        
<td valign="bottom"><table style="margin-right: auto; margin-left: auto;"><tr><td class="whiteheadertitle"><?php echo "$".format_number($pageStats['total_direct_earnings_in_my_network'],4);?><br>
<div class="networkbar greenbg first"></div>
1st</td></tr></table></td>

<td valign="bottom"><table style="margin-right: auto; margin-left: auto;"><tr><td class="whiteheadertitle"><?php echo "$".format_number($pageStats['total_level_2_earnings_in_my_network'],4);?><br>
<div class="networkbar greenbg second"></div>
2nd</td></tr></table>
</td>

<td valign="bottom"><table style="margin-right: auto; margin-left: auto;"><tr><td class="whiteheadertitle"><?php echo "$".format_number($pageStats['total_level_3_earnings_in_my_network'],4);?><br>
<div class="networkbar greenbg third"></div> 
3rd</td></tr></table>
</td>

<td valign="bottom"><table style="margin-right: auto; margin-left: auto;"><tr><td class="whiteheadertitle"><?php echo "$".format_number($pageStats['total_level_4_earnings_in_my_network'],4);?><br>
<div class="networkbar greenbg fourth"></div> 
4th</td></tr></table>
</td>

</tr>
</table>


</td></tr>
<tr><td class="light-grey-bg" style='padding:0px;'>
<?php $this->load->view('network/clout_score_details', array('pageStats'=>$pageStats));?>
</td></tr>
</table>