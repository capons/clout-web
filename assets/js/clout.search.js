//Search functionality

/*For use, the following is the basic HTML setup
-----------------------------------------------------------------------
<!-- The search field -->
<input type="text" id="[search field id]__[search type]" name="[search field id]__[search type]" placeholder="[Search instructions]" class="findfield[ other field classes here]" value=""/>

<!-- The hidden fields that are required for proper operation -->
// The area to display the search results
<input name="[search field id]__displaydiv" id="[search field id]__displaydiv" type="hidden" value="[the ID of the div to show the search results]" />

// Search ACTION (optional). If not given, the action is loaded from the search controller by [search field id].
<input name="[search field id]__action" id="[search field id]__action" type="hidden" value="[the url to perform the search]" />

// Search by fields (optional). If not given, the default field for the [search type] is used.
<input name="[search field id]__searchby" id="[search field id]__searchby" type="hidden" value="[field1|field2|field3..]" />

//IMPORTANT: echo a hidden field like that below to stop the next page list load (if the search results are less than the pagination list maximum number of rows)
<input name="paginationdiv__[pagination div ID]_stop" id="paginationdiv__[pagination div ID]_stop" type="hidden" value="[Number of pages loaded]" />
*/


var LOADING_IMG = "loading.gif";

$(function() {
	//What happens if you start typing in a find field (search field)
	$(document).on("keyup", ".findfield:not(.disabled)", function(){ 
		var fieldParts = $(this).attr('id').split('__');
		var searchFieldId = fieldParts[0];
		// The search action
		var fieldValue = $(this).val().length > 0? replaceBadChars($(this).val()): '_';
		var action = ($('#'+searchFieldId+'__action').length > 0? $('#'+searchFieldId+'__action').val(): getBaseURL()+'search/load_list')+'/type/'+$(this).data('type')+'/phrase/'+fieldValue;
			
		//Activate search if text is more than 2 characters
		if($(this).val().length > 1){
			// The fields to search by and append to the url
			var searchBy = $('#'+searchFieldId+'__searchby').length > 0? $('#'+searchFieldId+'__searchby').val().replace('|', '--'): '';
			action += searchBy !=''? '/searchby/'+searchBy: '';
			
			// Add a clear-search-field option if not available
			if(!$(this).hasClass('clearfield')){
				$(this).addClass('clearfield');
			}
			
			// Now show the search results
			var displayDiv = $('#'+searchFieldId+'__displaydiv').val();
			var displayheight = $('#'+displayDiv).parents('div, td').first().height();
			$('#'+displayDiv).css('min-height', displayheight+'px');
			
			//Update the pagination URL if available
			if($('#paginationdiv__'+searchFieldId+'_action').length > 0) $('#paginationdiv__'+searchFieldId+'_action').val(action);
			updateFieldLayer(action,'','',displayDiv,'');
			
			
			//Find if the results div is in a list and make proper adjustments
			var listId = displayDiv.substr(0, displayDiv.indexOf('__'));
			if($('#'+displayDiv).parents('#paginationdiv__'+listId+'_list').first().length > 0)
			{
				var containerDiv = $('#'+displayDiv).parents('#paginationdiv__'+listId+'_list').first();
				//Remove all divs not being used to display the list
				containerDiv.find('div').each(function(){
					if($(this).attr('id') != displayDiv){
						$(this).remove();
					}
				});
				//Remove all divs not the first page of pagination or the previous and next
				if($('#'+listId).length > 0){
					$('#'+listId).find('div').each(function(){
						if(!($(this).hasClass('previousbtn') || $(this).hasClass('nextbtn') || $(this).html() == '1')){
							$(this).remove();
						}
						if($(this).html() == '1'){
							$(this).addClass('selected');
							$(this).fadeIn('fast');
						}
					});
				}
			}
		}
		//Reload the list if the field is empty
		else if($(this).val().length == 0 && $(this).hasClass('clearfield'))
		{
			updateFieldLayer(action+'/__clear/Y','','',$('#'+searchFieldId+'__displaydiv').val(),'');
		}
	});
	
	
	
	// What happens if you click on a search field
	$(document).on("click", ".findfield:not(.disabled)", function(e){
		//Activate if has class that clears field
		if($(this).hasClass('clearfield')){
			
			//Only clear if the clicked area is where the clear icon is shown
			var fieldOffset = $(this).offset().left;
			if(e.pageX > fieldOffset &&  e.pageX < (fieldOffset + 30)){
				var fieldParts = $(this).attr('id').split('__');
				var searchFieldId = fieldParts[0];
				
				// The search action
				var fieldValue = $(this).val().length > 0? replaceBadChars($(this).val()): '_';
				var action = ($('#'+searchFieldId+'__action').length > 0? $('#'+searchFieldId+'__action').val(): getBaseURL()+'search/load_list')+'/type/'+$(this).data('type')+'/phrase/'+fieldValue;
				
				//Clear the field and remove all data
				$(this).val('');
				$(this).removeClass('clearfield');
				
				//Update the pagination URL if available
				if($('#paginationdiv__'+searchFieldId+'_action').length > 0) $('#paginationdiv__'+searchFieldId+'_action').val(action);
				
				// Then load the default list
				updateFieldLayer(action+'/__clear/Y','','',$('#'+searchFieldId+'__displaydiv').val(),'');
			}
		}
	});
	
	
	
	
	// What to do when the search button is clicked
	$(document).on('click', '#storesearchgo', function(){
		$('#filter_form_div').hide('fast');
		$('#searchresultsmapdiv').hide('fast');
		$('#searchresultsdiv').show('fast');
		$('.map-view-icon').removeClass('add-list');
		
		if($('#search__storesearch').val() == ''){
			showServerSideFadingMessage('Please enter a search phrase.');
		} else {
			url = getBaseURL()+'lists/load/t/store_suggestions_list'
			+'/phrase/'+($('#search__storesearch').val() != ''? replaceBadChars($('#search__storesearch').val()): '_')
			+'/location/'+($('#search__placesearch').val() != ''? replaceBadChars($('#search__placesearch').val()): '_')
			+'/order/'+($('#search__order').val() != ''? replaceBadChars($('#search__order').val()): '_')
			+'/suggestionId/'+($('#suggestionid').val() != ''? $('#suggestionid').val(): '_')
			+'/suggestionType/'+($('#suggestiontype').val() != ''? $('#suggestiontype').val(): '_');
			
			//Add the location from the browser if available
			var latitude = localStorage.getItem('__latitude');
			var longitude = localStorage.getItem('__longitude');
			if(typeof latitude !== 'undefined' && latitude !== null) url += '/latitude/'+latitude;
			if(typeof longitude !== 'undefined' && longitude !== null) url += '/longitude/'+longitude;
			
			// Reset some visible data
			$('#searchpagetitle').html("<a href='"+getBaseURL()+"search/home'>Search</a> / "+$('#search__storesearch').val());
			if($('#sort__searchsortoptions__hidden').length){
				$('#sort__searchsortoptions__hidden').val('');
				$('#sort__searchsortoptions').html('Recommended');
			}
			
			var parameters = {type: "GET", url: url, data: {},
				beforeSend: function() {
           			showWaitDiv('start');
				},
				error: function( xhr, textStatus, errorThrown) {
    				showWaitDiv('end');
				},
      	 		success: function(data) {
		   			$('#searchresultsdiv').html(data);
					if($('.store-item').length) {
						resizeStoreItems();
						reorderStoreItems();
					}
					showWaitDiv('end');
				}
   			};
			//Now run the AJAX query
			$.ajax(parameters);
		}
	});
	
	
	
	
	
	$(document).on('click', '.map-view-icon', function(){
		//Show search results list
			if($(this).hasClass('add-list')){
				$('#searchresultsmapdiv').slideUp('fast');
				if($('#searchresultsdiv').length) $('#searchresultsdiv').slideDown('fast');
				$(this).removeClass('add-list');
			}
			//Show map view
			else {
				if(!$('.large-banner').length) {
					var scrollTop     = $(window).scrollTop();
   					var divOffset = $('#searchresultsdiv').offset().top;
    				var distanceFromTop = (divOffset - scrollTop);
					var height = $(window).height() - distanceFromTop;
					$('#searchresultsmapdiv').height(height);
					$('#searchresultsdiv').slideUp('fast');
				}
				else {
					if($('#searchresultsdiv').length)$('#searchresultsdiv').slideUp('fast');
					$('#searchresultsmapdiv').height($(document).height() - ($('#searchpagetitle').offset().top + $('#searchpagetitle').height()));
					$('#searchresultsmapdiv').slideDown('fast');
				}
				
				$(this).addClass('add-list');
				updateFieldLayer(getBaseURL()+'search/load_map_view','','','searchresultsmapdiv','');
			}
	});
	
	
	
	
	
	// What to do when the add favorite icon is clicked
	$(document).on('click', '.add-favorite-icon', function(){
		var clickedElement = $(this);
		var storeId = clickedElement.data('id');
		var action = clickedElement.hasClass('greyicon')? 'add': 'remove';
		
		var parameters = {
        	type: "POST",
       		url: getBaseURL()+'search/add_favorite',
			data: {'storeid':storeId, 'action':action},
			// What to do as the data is being processed
      		beforeSend: function() {
           		showWaitDiv('start');
			},
			error: function( xhr, textStatus, errorThrown) {
    			showWaitDiv('end');
			},
      	 	success: function(data) {
		   		showWaitDiv('end');
				
				if(data == 'SUCCESS') {
					showServerSideFadingMessage('This store has been '+(action=='add'? 'added to': 'removed from')+' your favorites');
					
					if(clickedElement.hasClass('greyicon')) clickedElement.removeClass('greyicon');
					else clickedElement.addClass('greyicon');
				} 
				else showServerSideFadingMessage('ERROR: The store favorite could not be changed');
			}
   		};
		
		//Now run the AJAX query
		$.ajax(parameters);
	});
	
	
	
	
	
	
	
	// What to do when the add checkin icon is clicked
	$(document).on('click', '.add-checkin-icon', function(){
		var clickedElement = $(this);
		var storeId = clickedElement.data('id');
		
		var parameters = {
        	type: "POST",
       		url: getBaseURL()+'search/checkin',
			data: {'storeid':storeId},
			// What to do as the data is being processed
      		beforeSend: function() {
           		showWaitDiv('start');
			},
			error: function( xhr, textStatus, errorThrown) {
    			showWaitDiv('end');
			},
      	 	success: function(data) {
		   		showWaitDiv('end');
				
				if(data == 'SUCCESS') showServerSideFadingMessage('You have checked into this store. The store owner can now recognize you as a customer.');
				else showServerSideFadingMessage('ERROR: You could not check into this store');
			}
   		};
		
		//Now run the AJAX query
		$.ajax(parameters);
	});
	
	
	
	
	
	
	
	// Show the cashback options when ON is clicked
	$(document).on('click', '.show-with-toggle', function(){
		var displayField = $(this).data('showfield');
		
		if($(this).hasClass('on')) $('#'+displayField).css('display','block');
		else $('#'+displayField).css('display','none');
	});
	
	
	
	
	// Handling search phrase field actions
	$(document).on('keyup', '#search__storesearch', function(){
		if(!$(this).hasClass('search-delete-icon') && $(this).val().length > 0){
			$(this).addClass('search-delete-icon');
		} 
		if($(this).val().length == 0){
			$(this).removeClass('search-delete-icon');
		}
	});
	// The user is clearing the previous search phrase
	$(document).on('click', '#search__storesearch', function(e){
		var fieldOffset = $(this).offset().left;
		if($(this).hasClass('search-delete-icon') && (e.pageX > fieldOffset &&  e.pageX > (fieldOffset + $(this).width() - 25))){
			document.location.href=getBaseURL()+'search/home';
		}
	});
	
	
	
	
	
	
	
});




//Reload search list
function reloadSearchList(url,phrase,location,order)
{
	$('#searchpagetitle').append("<form id='search_reload_form' method='post' action='"+url+"'><input type='hidden' name='phrase' value='"+phrase+"'/><input type='hidden' name='location' value='"+location+"'/><input type='hidden' name='order' value='"+order+"'/></form>");
	$('#search_reload_form').submit();
}








//Resize iframe on load
function resizeIframe() {
   if($('#searchresultsmapdiv').length && $('#store_map_frame').length){
   	  var newHeight = $('#searchresultsmapdiv').height();
   	  $('#store_map_frame').height(newHeight);
   }
}
$(window).resize(function() { resizeIframe()});


// Reorder store items
var defaultItems;
var storeItems;
function reorderStoreItems(orderBy){
	if($('#sort__searchsortoptions__hidden').length){
		storeItems = $('#searchresultsdiv').find('.store-item');
		if(typeof defaultItems === 'undefined') defaultItems = storeItems;
		
		var valueArray = [];
		var order = 1;
		var value;
		var sortBy;
		
		if(orderBy != 'recommended'){
			storeItems.each(function(){ 
			if(orderBy == 'best_deal'){
				valueStr = $(this).find('.cashback span').first().html(); 
				if(typeof valueStr !== 'undefined') value = parseInt((valueStr.indexOf('-') != -1? valueStr.split('-')[1]: valueStr).replace('%', '').replace(',', ''));
				else value = 0;
				
				sortBy = 'DESC';
			}
			if(orderBy == 'distance'){
				valueStr = $(this).find('.distance-box').first().html(); 
				value = (typeof valueStr !== 'undefined')? parseFloat(valueStr.replace('mi', '').replace(',', '')): 0;
				sortBy = 'ASC';
			}
			if(orderBy == 'score'){
				value = parseInt($(this).find('.score-wrapper div').first().html().replace(',', '')); 
				value = (typeof value !== 'undefined')? value: 0;
				sortBy = 'DESC';
			}
			
			if(typeof value !== 'undefined'){ 
				valueArray.push({'order':order, 'value':value}); 
				order++;
			}
			});
		
			//Sort key value array
			if(typeof valueArray !== 'undefined') {
				var sortedValues = sortKeyValueArray(valueArray, sortBy);
			}
		
			//$('.store-item').remove();
			var newStoreItems = [];
			$.each(sortedValues, function(index, obj) {
				$('#searchresultsdiv').append(storeItems.get(obj.order - 1));
				newStoreItems.push(storeItems.get(obj.order - 1));
			}); 
			storeItems = newStoreItems;
		}
		// Recommended search algorithm
		else if(typeof defaultItems !== 'undefined') {
			storeItems = defaultItems;
			$('.store-item').remove();
			$.each(storeItems, function(index, obj) {
				$('#searchresultsdiv').append(obj);
			});
		}
		
		
		// Put the scroller target back at the bottom
		if($('#scrolltarget').length){
			var targetHtml = $('#scrolltarget').get(0).outerHTML;
			$('#scrolltarget').remove();
			$('#searchresultsdiv').append(targetHtml);
		}
	}
}





// Sort a key-value array
function sortKeyValueArray(array, sortBy){
	array.sort(function(a, b){ return a.value - b.value;});
	if(sortBy == 'DESC') array.reverse();
	
	return array;
}





// Get array values
function getArrayValues(keyValueArray, returnType){
	var values = [];
	var keys = [];
	$.each(keyValueArray, function( index, value ) {
		keys.push(value.order);
		values.push(value.value);
	});
	return (returnType == 'values'? values: keys);
}






//Reposition score cell
function repositionScoreCell(){
	var left = $('.score-square').first().css('margin-left') - ($('.score-cell').first().width()/2) ;
	$('.score-square').first().css('margin-left', left);
}
$(window).resize(function() { repositionScoreCell();});





// Update the search sort format
function updateSearchSort(url, sortType){
	var sortTypeValue = sortType.toLowerCase().replace(' ', '_');
	$('#search__order').val(sortTypeValue);
	$('#storesearchgo').click();
}







//Hide all other layers and display current hovered over layer
function hideTabsAndDisplayThis(thisLayerId, extraData)
{
	var tabArray = Array('level_0_tab', 'level_1_tab', 'level_2_tab', 'level_3_tab', 'level_4_tab', 'level_5_tab', 'level_6_tab', 'level_7_tab', 'level_8_tab', 'level_9_tab', 'level_10_tab');
	var otherLayers = arrayDiff(tabArray, Array(thisLayerId));
	
	showLayerSet(thisLayerId);
	hideLayerSet(otherLayers.join('<>'));
	
	updateFieldLayer(getBaseURL()+'search/offer_list/l/'+thisLayerId+'/e/'+extraData,'','','offer_list','');
}


//Hide tabs and dispay the column background
function hideTabsAndDisplayBg(thisColId)
{
	var defaultColor = "#CCCCCC";
	var currentLevel = document.getElementById('currentlevelvalue').value;
	
	var colArray = Array('level_0', 'level_1', 'level_2', 'level_3', 'level_4', 'level_5', 'level_6', 'level_7', 'level_8', 'level_9', 'level_10');
	var colorArray = Array('#CCCCCC', '#56D42B', '#18C93E', '#0AC298', '#03BFCD', '#2DA0D1', '#6D76B5', '#8566AB', '#999999', '#666666', '#333333');
	
	var otherCols = arrayDiff(colArray, Array(thisColId));
	var thisColor = colorArray[arraySearch(colArray, thisColId)];
	document.getElementById(thisColId+'_top').style.backgroundColor = thisColor;
	document.getElementById(thisColId+'_bottom').style.backgroundColor = thisColor;
	
	for(var i=0; i<otherCols.length; i++)
	{
		if(otherCols[i] != currentLevel)
		{
			document.getElementById(otherCols[i]+'_top').style.backgroundColor = defaultColor;
			document.getElementById(otherCols[i]+'_bottom').style.backgroundColor = defaultColor;
		}
	}
}



