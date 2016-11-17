<table class="normal-table table-highlight-border" style="width:100%; background-color:#FFFFFF;">
<tr><td class='light-grey-bg bottom-border-grey' style="padding:20px;"><table style="width:100%; border:0"><tr><td><input type='text' id='bankname__banks' name='bankname__banks' class='textfield searchable' style="min-width: 250px; width:70%;" placeholder="Don't see your bank? Search here.." value=''/></td>

<?php if($this->native_session->get('link_in_page')) echo "<td style='text-align:right; width:1%;'><a href='javascript:;' onclick='closeInPageCardDiv()'><img src='".base_url()."assets/images/grey_closer.png' border='0'></a></td>";?>

</tr></table></td></tr>

<tr><td>
<div class="logo-scroll">
<?php
if(!empty($featuredBanks)){
	foreach($featuredBanks AS $bank)
	{
		echo "<a href='".base_url()."account/show_bank_login/i/".encrypt_value($bank['bank_id'])."/n/".encrypt_value($bank['bank_name'])."/c/".encrypt_value($bank['bank_code'])."' class='shadowbox'><div class='logo-box' style='background: url(".API_S3_URL.$bank['logo_url'].") no-repeat center center;'></div></a>";
	}
}
else echo format_notice($this, 'WARNING: There are no featured banks.');
?></div>
</td></tr>

</table>