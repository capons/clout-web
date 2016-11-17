<table class='microform'><tr><td id="filter_form">
	<div>
		<table>

			<tr>
				<td>
					<div>Category</div>
					<div>
						<select id='search__level1categories' name='search__level1categories' class="drop-down" style='min-width:60px; width:100%;'>
							<option value='' selected>Any</option>
							<?php echo get_option_list($this,'level1categories', 'select','',array('selected'=>'all', 'isFilter'=>'Y'));?>
						</select>
					</div>
				</td>
			</tr>

			<tr>
				<td>
					<div>Distance</div>
					<div>
						<select id='search__distanceoptions' name='search__distanceoptions' class="drop-down" style='min-width:60px; width:100%;'>
							<option value='' selected>Any</option>
							<?php echo get_option_list($this,'distanceoptions', 'select','',array('selected'=>DEFAULT_SEARCH_DISTANCE));?>
						</select>
					</div>
				</td>
			</tr>
		</table>
	</div>





<div>
<table>

<tr><td><div>Rewards</div><div>
<table class='option-group'>
<tr><td>Perks - At Check In</td><td><div id='rewards__perks_checkin' class='toggle-radio'></div></td></tr>
<tr><td>Perks - w/Reservation</td><td><div id='rewards__perks_reservation' class='toggle-radio'></div></td></tr>
<tr><td><div style="display:inline-block;">Cash Back</div><div style="display:inline-block; padding-left:5px;"><select id='rewards__cashbackrange' name='rewards__cashbackrange' class='drop-down small' style='display:none;'><?php echo get_option_list($this,'cashbackrange');?></select></div></td><td><div id='rewards__cashback' class='toggle-radio show-with-toggle' data-showfield='rewards__cashbackrange'></div></td></tr>
</table>
</div></td></tr>


</table>
</div>





<div>
<table>

<tr><td><div>Hot Spots</div><div>
<table class='option-group'>
<tr><td>Favorites</td><td><div id='hotspots__favorites' class='toggle-radio'></div></td></tr>
<tr><td>Places I have been to</td><td><div id='hotspots__ihavebeen' class='toggle-radio'></div></td></tr>
<tr><td>Popular places</td><td><div id='hotspots__popular' class='toggle-radio'></div></td></tr>
</table>
</div></td></tr>
</table>
</div>


</td></tr>
<tr><td>
<div class='buttondiv'><button id="applysearchfilter" name="applysearchfilter" onclick="passFormValue('search__storesearch', 'searchphrase', '');passFormValue('search__placesearch', 'searchlocation', '');passFormValue('search__order', 'searchorder', '');hideLayerSet('searchresultsmapdiv');showLayerSet('searchresultsdiv');$('#searchpagetitle').html('Results');" class="btn green">Apply Filter</button>

<input type='hidden' id='searchphrase' name='searchphrase' value='' />
<input type='hidden' id='searchlocation' name='searchlocation' value='' />
<input type='hidden' id='searchorder' name='searchorder' value='' />

<input type='hidden' id='action' name='action' value='<?php echo base_url();?>search/apply_filter' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Searching..' />
<input type='hidden' id='errormessage' name='errormessage' value='ERROR: Select an option to continue.' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='searchresultsdiv' />
</div>

</td></tr></table>