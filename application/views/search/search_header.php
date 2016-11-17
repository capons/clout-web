<?php if($this->native_session->get('search_phrase')) $phrase = $this->native_session->get('search_phrase');?>
<tr><td class="light-grey-bg bottom-border-grey">

<table style="width:100%; border:0" class="search-table"><tr>
<td><div class="search-fields-wrapper">
<div>
<input type='text' id='search__storesearch' name='search__storesearch' class='searchable do-not-clear submit-on-enter<?php echo !empty($phrase)? ' search-delete-icon': '';?>' data-targetbtn='storesearchgo' placeholder="Search" value='<?php echo !empty($phrase)? $phrase: '';?>'/>
<input type='hidden' id='suggestiontype' name='suggestiontype' value='' />
<input type='hidden' id='suggestionid' name='suggestionid' value='' />
</div>
<div style='display:table; width:100%;'>
<div style='display:table-cell;'>
<input type='text' id='search__placesearch' name='search__placesearch' class='searchable drop-down-icon do-not-clear always-refresh submit-on-enter' data-targetbtn='storesearchgo' data-val='allowdelete' placeholder='Near Me' value='<?php if($this->native_session->get('location_phrase')) echo $this->native_session->get('location_phrase');?>'/>
<input type='hidden' id='allowdelete' name='allowdelete' value='Y' />
<input type='hidden' id='search__order' name='search__order' value='<?php if($this->native_session->get('order_phrase')) echo $this->native_session->get('order_phrase');?>' />
</div>
<div style='display:table-cell; padding-left:10px;'>
<button id='storesearchgo' name='storesearchgo' class='btn green' style='min-width:50px;'>Go</button>
</div>

</div>
</div>
</td>
</tr></table>

</td></tr>
