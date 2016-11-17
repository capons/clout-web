<table class="microform white-box-table" style="width:100%; margin-top:5px;">
<?php 
if(!empty($isOnVip) && $isOnVip == 'Y'){
	echo "<tr><td>".format_notice($this, "You're on the VIP list!")."</td></tr>";
}
else
{
	if(!empty($showConfirmation)){
		echo "<tr><td>".format_notice($this, $msg)."</td></tr>";
	}

	else if(!empty($showAddToVIP)){?>
<?php if(!empty($msg)) echo "<tr><td>".format_notice($this, $msg)."</td></tr>";?>
<tr><td style="text-align:left;"><span class="h3">Lets make you a VIP!</span>
<br />If this business sent you personalized offers, how much would you spend here?</td></tr>
<tr><td class="row-divs">
<div><table><tr><td>Per Visit</td><td style="padding-left:0px;"><input type='text' id='pervisitspend' name='pervisitspend' value='' placeholder='$ amount' class="numbersonly" style="min-width: 100px;max-width: 100px;" /></td></tr></table></div>

<div><table><tr><td>Per Month</td><td style="padding-left:0px;"><input type='text' id='permonthspend' name='permonthspend' value='' placeholder='$ amount' class="numbersonly" style="min-width: 100px;max-width: 100px;" /></td></tr></table></div>
</td></tr> 

<tr><td><button type="button" id="submitrequest" name="submitrequest" class="btn green submitmicrobtn" style="width:100%;">Add me to the VIP List</button>
 
<input type='hidden' id='action' name='action' value='<?php echo base_url().'search/send_request/a/add_vip';?>' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Sending your request..' />
<input type='hidden' id='errormessage' name='errormessage' value='ERROR: Enter the amounts to continue.' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='offer_list' />
</td></tr>
<?php } 



else {?>
<?php if(!empty($msg)) echo "<tr><td>".format_notice($this, $msg)."</td></tr>";?>
<tr><td style="text-align:left;"><span class="h3">Tell us what you want!</span>
<br />..and we'll put your name on the list to get it first.</td></tr>
<tr><td class="row-divs">
<div><table><tr><td><input id='request_cashback' name='requests[]' type='checkbox' value='cashback' class='bigcheckbox'><label for='request_cashback'></label></td><td onClick="clickItem('request_cashback')" style="padding-left:0px; cursor:pointer;">Cash Back</td></tr></table></div>

<div><table><tr><td><input id='request_perks' name='requests[]' type='checkbox' value='perks' class='bigcheckbox'><label for='request_perks'></label></td><td onClick="clickItem('request_perks')" style="padding-left:0px; cursor:pointer;">Free Stuff / Perks</td></tr></table></div>

<div><table><tr><td><input id='request_vip' name='requests[]' type='checkbox' value='vip' class='bigcheckbox'><label for='request_vip'></label></td><td onClick="clickItem('request_vip')" style="padding-left:0px; cursor:pointer;">VIP Treatment</td></tr></table></div>
</td></tr> 

<tr><td><button type="button" id="submitrequest" name="submitrequest" class="btn green <?php if(!empty($this->native_session->get('__user_id'))) {?>submitmicrobtn<?php }?>" style="width:100%;">Submit</button>
 
<input type='hidden' id='action' name='action' value='<?php echo base_url().'search/send_request';?>' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Sending your request..' />
<input type='hidden' id='errormessage' name='errormessage' value='ERROR: A selection is required to continue.' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='offer_list' />
</td></tr>
<?php }
}?>


</table>