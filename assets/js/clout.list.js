// JavaScript Document


// Handle clicking on list buttons
$(function(){
	$(document).on('click', '.accordion-list > table > tbody > tr', function(event){
		//Open accordion style an unopened row in the list
		if(!$(this).hasClass('active') && !$( event.target ).hasClass('cancel-list-btn')){
			var selectedRow = $(this).has('.detail-row').length? $(this).prev('tr'): $(this);
			// Remove the active class from all others
			$(this).parent('tbody').children('tr').each(function(){
				$(this).removeClass('active');
				$(this).find('.bigcheckbox').first().attr('checked', false);
			});
			
			//Now make this row (and the detail row) the one with the active class
			selectedRow.addClass('active');
			selectedRow.next('tr').addClass('active');
			if(!selectedRow.find('.bigcheckbox').first().is(':checked')) {
				selectedRow.find('.bigcheckbox').first().click();
			}
		}
		
		
		
		//Otherwise, deal with individual column openings
		else if($(this).hasClass('active') 
			&& ($( event.target ).hasClass('inner-select') || $( event.target ).parents('td').first().hasClass('inner-select'))
		) {
			var selectedCell = $( event.target ).hasClass('inner-select')? $( event.target ): $( event.target ).parents('td').first();
			var selectedCellValue = selectedCell.hasClass('ignore-content')? 'NONE': selectedCell.html();
			
			//Highlight the clicked cell
			$(this).find('.inner-select').each(function(i, element){ $(this).removeClass('selected'); });
			selectedCell.addClass('selected');
			
			updateFieldLayer(getBaseURL()+selectedCell.data('category')+'/'+selectedCell.data('type')+'/i/'+$(this).attr('id')+'/v/'+replaceBadChars(selectedCellValue),'','','row_'+$(this).attr('id')+'_details','');
			
		}
		
	});
	
	
	
	
	
	
	
	
	
	// Handle clicking a parent-child checkbox group in a list
	$(document).on('click', '.parent-child-checkboxes > input[type=checkbox]', function(event){
		var parentCheckbox = $(this);
		var checkboxId = $(this).attr('id')
		
		// Check all the children
		if($(this).is(':checked')){
			$('#div_'+checkboxId).children('input[type=checkbox]').each(function(){
				$(this).prop('checked', true);
			});
			// Show the div with all the selected categories
			if(!$('#div_'+checkboxId).is(':visible')) $('#div_'+checkboxId).slideDown('fast');
		}
		// Un-check on the children
		else {
			$('#div_'+checkboxId).children('input[type=checkbox]').each(function(){
				$(this).prop('checked', false);
			});
			if($('#div_'+checkboxId).is(':visible')) $('#div_'+checkboxId).slideUp('fast');
		}
	});
	
	// Clicking on a child checkbox
	$(document).on('click', '.parent-child-checkboxes div > input[type=checkbox]', function(event){
		//Get the parent div and thus parent checkbox 
		var parentDivId = $(this).parent('div').attr('id');
		// Uncheck the parent checkbox if the checkbox has been unchecked
		if(!$(this).is(':checked')){
			$('#'+parentDivId.split('div_')[1]).attr('checked', false);
		}
	});
	
	
	
	
	
	
	
	
	// Clicking a cancel button in a details page
	$(document).on('click', '.cancel-list-btn', function(event){
		// Find the parent details row and remove the active class
		var detailRow = $(this).parents('.detail-row').first().parent('tr');
		detailRow.removeClass('active');
		detailRow.prev('tr').removeClass('active');
		detailRow.prev('tr').find('.bigcheckbox').first().attr('checked', false);
	});
	
	
	$(document).on('click', '.minimizer-tip, .add-more-link', function(event){
		// Remove all current similar divs which are visible
		$('.add-chain-div').each(function(){ $(this).remove();});
		$('.edit-store-div').each(function(){ $(this).remove();});
		
		var subLayer = $(this).data('target');
		toggleLayersOnCondition(subLayer, subLayer);
		
	});
	
	
	
	
	
	
	// Adding a new category
	$(document).on('click', '.add-sub-category', function(event){
		var formDiv = $(this).parents('div').first();
		var categoryField = formDiv.find('input[type=text]').first();
		
		if(categoryField.val().trim() != ''){
			var parameters = {
        		type: "POST",
       			url: getBaseURL()+'transaction/add_sub_category/c/'+categoryField.data('category'),
				// How to handle getting the "form" data
      			data: {'subCategory': categoryField.val().trim(), 'descriptorId': categoryField.data('descriptor')},
				// What to do as the data is being processed
      			beforeSend: function() {},
				error: function( xhr, textStatus, errorThrown) {
    				//console.log('LOG: '+xhr.responseText);
					showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
				},
      	 		success: function(data) {
					if(data.match(/error/i)) {
						showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
					} 
					//Submission was successful
					else {
						showServerSideFadingMessage('The sub-category has been submitted for addition.');
						formDiv.parents('td').first().find('.add-more-link').first().before(data);
					}
				}
			}
		
			//Run the ajax parameters
			$.ajax(parameters);
		}
		// No category is entered
		else {
			showServerSideFadingMessage('ERROR: Enter a new category name.');
		}
		
		
	});
	
	
	
	
	
	
	// Show a list of flags for a given item
	$(document).on('click', '.view-flags, .add-flag', function(event){
		var flagCaller = $(this);
		//First hide all flag details div around
		$('.flag-details-div').each(function(){ $(this).hide('fast'); });
		
		//Create a new div next to the calling element
		var callerDiv = flagCaller.attr('id')+'__div';
		//Remove if already present
		if($("#"+callerDiv).length > 0) $("#"+callerDiv).remove();
		
		flagCaller.after("<div id='"+callerDiv+"' class='flag-details-div'></div>");
		
		//Reposition our new div
		$('#'+callerDiv).offset({
			left: flagCaller.offset().left, 
			top: (flagCaller.offset().top + flagCaller.outerHeight())
		});
		
		//Now populate the flag div
		if(flagCaller.data('category')) {
			if(flagCaller.hasClass('view-flags')) {
				updateFieldLayer(getBaseURL()+flagCaller.data('category')+'/flag_list/i/'+flagCaller.attr('id'),'','',callerDiv,'');
			} else {
				updateFieldLayer(getBaseURL()+flagCaller.data('category')+'/add_flag/i/'+flagCaller.attr('id').replace('addflagbtn_',''),'','',callerDiv,'');
			}
		}
	});
	
	
	
	
	
	
	
	// Show the list of details in a tip div
	$(document).on('click', '.view-links', function(event){
		var viewCaller = $(this);
		//First hide all view links div around
		$('.view-links-div').each(function(){ $(this).hide('fast'); });
		
		//Create a new div next to the calling element
		var callerDiv = viewCaller.data('id')+'__div';
		//Remove if already present
		if($("#"+callerDiv).length > 0) $("#"+callerDiv).remove();
		
		viewCaller.after("<div id='"+callerDiv+"' class='view-links-div'></div>");
		
		//Reposition our new div
		$('#'+callerDiv).offset({
			left: viewCaller.offset().left, 
			top: (viewCaller.offset().top + viewCaller.outerHeight())
		});
		
		//Now populate the flag div
		updateFieldLayer(getBaseURL()+viewCaller.data('url')+'/id/'+viewCaller.data('id'),'','',callerDiv,'');
	});
	
	
	
	
	
	
	
	
	
	
	// Close any flag details div if not clicked on
	$(document).on('click', '.list-details-row', function(event){
		// Close flag-details-div if someone clicks away
		if(!($( event.target ).hasClass('flag-details-div') || $( event.target ).hasClass('view-flags') || $( event.target ).hasClass('add-flag') || $( event.target ).parents('.flag-details-div').length > 0 )){
			
			$('.flag-details-div').each(function(){ $(this).hide('fast'); });
		}
	});
	
	$(document).on('click', '.location-details-row', function(event){
		// Close view-links-div if someone clicks away
		if(!($( event.target ).hasClass('view-links-div') || $( event.target ).hasClass('view-links') || $( event.target ).parents('.view-links-div').length > 0 )){
			
			$('.view-links-div').each(function(){ $(this).hide('fast'); });
		}
	});	
	
	
	
	
	// Handle silent posts from the list items
	$(document).on('click', '.list-delete-icon, .list-item-post', function(event){
		var confirmed = false;
		// First confirm, if required
		if($(this).hasClass('confirm')){
			var msg = $(this).parents('table').first().data('msg')? $(this).parents('table').first().data('msg'): $(this).parents('.search-list-div').first().data('msg');
			if(window.confirm(msg)) confirmed = true; 
		} 
		else  confirmed = true;
		
		
		
		
		// Then go to the desired link
		if(confirmed && $(this).data('category') && $(this).data('type')){
			var action = getBaseURL()+$(this).data('category')+'/'+$(this).data('type');
			var itemObj = $(this);
			var itemId = itemObj.attr('id');
			var data = {};
			
			if(itemObj.hasClass('list-item-post')){
				itemId = itemId.replace('addflagbtn_','');
				var formFieldId = itemObj.parents('.flag-details-div').first().find('input[type=text]').first().attr('id');
				data = {'item_id': itemId, 'hidden_value': $('#'+formFieldId+'__hidden').val(), 'displayed_value': $('#'+formFieldId).val() };
			} else if(itemObj.hasClass('list-delete-icon')){
				data = {'item_id': itemId};
			}
			
			
			var parameters = {
        		type: "POST",
       			url: action,
				// How to handle getting the "form" data
      			data: data,
				
				// What to do as the data is being processed
      			beforeSend: function() {
           			//Do nothing
				},
				error: function( xhr, textStatus, errorThrown) {
    				//console.log('LOG: '+xhr.responseText);
					showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
				},
      	 		success: function(data) {
					var itemType = itemObj.data('type');
					var itemName = itemType.substr(itemType.indexOf("_") + 1).replace('_',' '); //Use name after first underscore
					//console.log('LOG: '+data);
					// What to do if the action succeeds
					if(data.match(/SUCCESS/i)) {
						// Was deleting an item
						if(itemObj.hasClass('list-delete-icon')){
							
							if(itemObj.parents('.flag-details-div').first().length > 0){
								// Get the parent row and find the view-flags link
								var viewFlagsLink = itemObj.parents('.flag-details-div').first().parents('tr').first().find('.view-flags').first();
							
								if(typeof viewFlagsLink != "undefined") {
									var linkText = viewFlagsLink.text();
									var number = parseInt(linkText.split(' ')[0]) - 1;
									if(number > 0) viewFlagsLink.text(number+' '+linkText.split(' ')[1]);
									else viewFlagsLink.hide('fast');
								}
							}
							
							//Now remove the deleted row
							itemObj.parents('tr').first().remove();
							showServerSideFadingMessage('The '+itemName+' has been '+itemObj.data('action')+' for deletion.');
							
						} 
						// Was posting the item(s)
						else if(itemObj.hasClass('list-item-post')){
							showServerSideFadingMessage('The '+itemName+' has been '+itemObj.data('action')+' for addition.');
							
							//There are flags already
							if($("a[data-name='view-flags-"+ itemId +"']").length > 0) {
								var linkText = $("a[data-name='view-flags-"+ itemId +"']").text();
								var number = parseInt(linkText.split(' ')[0]) + 1;
								$("a[data-name='view-flags-"+ itemId +"']").text(number+' '+linkText.split(' ')[1]);
							}
							// this is the first flag
							else if($("a[data-name='add-flags-"+ itemId +"']").length > 0){
								$("a[data-name='add-flags-"+ itemId +"']").before('+');
								$("a[data-name='add-flags-"+ itemId +"']").parent('td').prev('td').append(" <a href='javascript:;' class='view-flags' id='"+ itemId +"' data-category='"+itemObj.data('category')+"' data-name='view-flags-"+ itemId +"'>1 Flags</a>");
							}
						}
						
						//Now hide the details div
						if(itemObj.parents('.flag-details-div').first().length > 0) itemObj.parents('.flag-details-div').first().hide('fast');
					}
					
					
					// There was a server side problem
					else {
						// Was deleting an item
						if(itemObj.hasClass('list-delete-icon')){
							showServerSideFadingMessage('ERROR: The '+itemName+' could NOT be deleted.');
						} 
						// Was posting the item(s)
						else if(itemObj.hasClass('list-item-post')){
							showServerSideFadingMessage('ERROR: The '+itemName+' could NOT be added.');
						}
					}
					
					
					
				}
   			};
			//Run the ajax parameters
			$.ajax(parameters);
		}
		
	});	
	
	
	
	
	
	
	
	
	
	
	// Add details from a clicked item to this table before the row
	$(document).on('click', '.add-to-this-table', function(event){
		var value = $(this).data('value');
		var type = $(this).data('type');
		//Does it have a specific HTML data source or are we taking all of it
		var text = $(this).find('.data-cell').length > 0? $(this).find('.data-cell').first().html(): $(this).html();
		//Does the element have the category ID or do you have to look for it?
		var categoryId = $(this).data('categoryid')? $(this).data('categoryid'): $(this).parents('.drop-down-div').first().parents('td').find('.searchable').first().data('categoryid');
		
		var itemHtml = "<tr><td width='1%'><input type='checkbox' id='location_"+categoryId+"_"+value+"' name='location_"+categoryId+"[]' value='"+categoryId+"__"+value+"__new' checked /><label class='text-label' for='location_"+categoryId+"_"+value+"'>"+text+"</label> &nbsp; <a href='javascript:;' class='add-chain' data-id='"+value+"' data-type='store' data-categoryid='"+categoryId+"'>add chain</a</td> | <a href='javascript:;' class='edit-store' data-id='"+value+"' data-type='store' data-categoryid='"+categoryId+"'>edit</a> </tr>";
			
		//Hide the row if it is not a drop down list (hidden automatically)
		if($(this).find('.data-cell').length > 0) $(this).hide('fast');
		
		
		//Add the row before the more row
		$(this).parents('.add-more-row').first().before(itemHtml);
	});
	
	
	
	
	
	
	
	// Add store links
	$(document).on('click', '.add-chain-link', function(event){
		var descriptorId = $(this).data('categoryid');
		var linkId = $(this).data('value');
		var checkbox = $(this).find('input[type=checkbox]').first();
		
		if(checkbox.is(':checked')){
			var linkObj = $(this).find('a').first();
			var linkContainer = $('#chainlinks_'+descriptorId);
			
			linkContainer.append("<div class='delete-icon'>"+linkObj[0].outerHTML+"<input type='hidden' id='links_"+descriptorId+"_"+linkId+"' name='links_"+descriptorId+"[]' value='"+linkObj.attr('href')+'||'+linkObj.text()+"' </div>");
			
			$(this).hide('fast');
		}	
	});
	
	
	
	
	
	
	
	// What to do if the delete icon is clicked
	$(document).on('click', '.delete-icon', function(e){
		//Only delete element if the icon is clicked
		var fieldOffset = $(this).offset().left;
		if(e.pageX < (fieldOffset + 40)){
			$(this).remove();
		}
	});
	
	
	
	
	
	
	
	
	
	
	// Add details from a clicked item to this table before the row
	$(document).on('click', '.save-new-rule', function(event){
		var clickedBtn = $(this);
		var descriptorId = $(this).data('value');
		var formObj = $(this).parents('.microform').first();
		var formObjDiv = formObj.parents('div').first();
		var inputs = formObj.find('input, select');
		var activate = true;
		
		inputs.each(function(){
			if(!$(this).hasClass('optional') && $(this).attr('type') != 'hidden' && $(this).val().length < 1){
				activate = false;
				return false;
			}
			
			if($(this).hasClass('optional') && $(this).data('id') && $(this).data('id') == 'matchsearchfield' && 
			$('#action_'+descriptorId+'__ruleaction').length > 0 && $('#action_'+descriptorId+'__ruleaction').val() == 'match' && $(this).val() == ''){ 
				activate = false;
				return false;
			}
		});
		
		
		if(inputs.length > 0 && activate)
		{
			var parameters = {
        		type: "POST",
       			url: getBaseURL()+'transaction/add_match_rule/d/'+descriptorId,
				// How to handle getting the "form" data
      			data: inputs.serializeArray(),
				// What to do as the data is being processed
      			beforeSend: function() {},
				error: function( xhr, textStatus, errorThrown) {
    				//console.log('LOG: '+xhr.responseText);
					showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
				},
      	 		success: function(data) {
					if(data.match(/error/i)) {
						//console.log('END LOG: '+data);
						showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
					} 
					//Submission was successful
					else {
						showServerSideFadingMessage('The rule has been saved.');
						var linkObj = formObjDiv.parents('.add-more-row').first().before(data);
						// Now remove all the entered data from the form
						removeUserDataFromRuleForm(formObjDiv, descriptorId);
					}
				}
			}
		
			//Run the ajax parameters
			$.ajax(parameters);
		}
		// A non-optional field has not been entered
		else {
			showServerSideFadingMessage('ERROR: All non-optional fields are required to continue.');
		}
	});
	
	
	
	
	
	
	
	
	
	
	// Add matching rules
	$(document).on('click', '.save-new-location', function(event){
		
		var clickedBtn = $(this);
		var descriptorId = $(this).data('value');
		var formObj = $(this).parents('.microform').first();
		var formObjDiv = formObj.parents('div').first();
		var inputs = formObj.find('input, textarea, select');
		var extraInfo = ($(this).data('chainid')? '/c/'+$(this).data('chainid'): '');
		extraInfo += ($(this).data('chaintype')? '/t/'+$(this).data('chaintype'): '');
		var activate = true;
		
		inputs.each(function(){
			if(!$(this).hasClass('optional') && $(this).attr('type') != 'hidden' && $(this).val().length < 1){
				//console.log('FIELD ID: '+$(this).attr('id'));
				activate = false;
				return false;
			}
		});
		
		
		if(inputs.length > 0 && activate)
		{
			var parameters = {
        		type: "POST",
       			url: getBaseURL()+(clickedBtn.data('targeturl')? clickedBtn.data('targeturl'): 'transaction/add_chain_suggestion')+'/d/'+descriptorId+extraInfo,
                // How to handle getting the "form" data
      			data: inputs.serializeArray(),
				// What to do as the data is being processed
      			beforeSend: function() {},
				error: function( xhr, textStatus, errorThrown) {
    				//console.log('LOG: '+xhr.responseText);
					showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
				},
      	 		success: function(data) {
      	 			if(data.match(/error/i) && !data.match(/error:/i)) {
      	 				showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
      	 			}
      	 			else if(data.match(/error:/i)) {
      	 				showServerSideFadingMessage(data);
					} 
					//Submission was successful
					else {
						showServerSideFadingMessage('The chain data has been saved.');
						
						// Just editing
						if(clickedBtn.data('chainid')){
							if(data != '' && clickedBtn.data('displayarea')) {
								formObjDiv.parents('.accordion-row').first().find('label[for="'+clickedBtn.data('displayarea')+'"]').first().html(data);
							}
							else if(clickedBtn.data('chaintype') && clickedBtn.data('chaintype') == 'store'){
								formObjDiv.parents('td').first().find('.edit-chain').last().before(data);
							}
							
							formObjDiv.remove();
						} else {
							var linkObj = formObjDiv.parents('.add-more-row').first().before(data);
							// Now remove all the entered data from the form
							removeUserDataFromLocationForm(formObjDiv, descriptorId);
						}
					}
				}
			}
		
			//Run the ajax parameters
			$.ajax(parameters);
		}
		// A non-optional field has not been entered
		else {
			showServerSideFadingMessage('ERROR: All non-optional fields are required to continue.');
		}
	});
	
	
	
	
	
	
	
	/*// Add a new chain to a store
	$(document).on('click', '.add-chain', function(event){
		var descriptorId = $(this).data('categoryid');
		var chainDivId = 'addchain_'+descriptorId;
		
		// Remove all current similar divs which are visible
		$('.add-chain-div').each(function(){ $(this).remove();});
		$('.edit-chain-div').each(function(){ $(this).remove();});
		$('#more_location__'+descriptorId).hide('fast');
		
		// Then show the desired chain div
		if($('#'+chainDivId).length > 0) $('#'+chainDivId).html();
		else $(this).parents('td').first().append("<div id='"+chainDivId+"' class='add-chain-div'></div>");
		
		// Load the chain form into the div
		updateFieldLayer(getBaseURL()+'transaction/add_chain/t/'+chainType+'/d/'+descriptorId,'','',chainDivId,'');
	});*/
	
	// What happens after clicking this button
	$(document).on('click', '.add-chain-div #savechain', function(event){
		$(this).parents('.add-chain-div').first().remove();
	});
	
	
	
	
	
	
	// Edit the chain
	$(document).on('click', '.edit-chain', function(event){
		var editLinkObj = $(this);
		var chainId = $(this).data('id');
		var chainType = $(this).data('type');
		var descriptorId = $(this).data('categoryid');
		var displayArea = $(this).data('fortarget');
		var editChainDiv = 'editchain_div__'+descriptorId+'_'+chainId;
		
		// First remove all similar divs
		$('.add-chain-div').each(function(){ $(this).remove();});
		$('.edit-chain-div').each(function(){ $(this).remove();});
		$('#addchain_div__'+descriptorId).hide('fast');
		
		// Then create a div for this edit
		editLinkObj.after("<div class='edit-chain-div' id='"+editChainDiv+"'></div>");
		
		// Then show the div with the refreshed form with the right details
		updateFieldLayer(getBaseURL()+'transaction/add_chain_suggestion/t/'+chainType+'/c/'+chainId+'/d/'+descriptorId+(editLinkObj.data('fortarget')? '/a/'+editLinkObj.data('fortarget'):'')+(editLinkObj.data('storeid')? '/s/'+editLinkObj.data('storeid'):''),'','',editChainDiv,'');
	});
	
	
	
	
	
	
	
	
	
	
	
	
	// Show list actions
	$(document).on('click', '.list-actions', function(event){
		var btnActionId = $(this).attr('id');
		$(this).addClass('selected');
		//is a width specified
		var width = $(this).data('width')? "width:"+$(this).data('width')+"px;": '';
		var height = $(this).data('height')? "height:"+$(this).data('height')+"px;": '';
		
		//Remove the details div and recreate it
		if($('#'+btnActionId+'__div').length > 0) $('#'+btnActionId+'__div').remove();
		$(this).before("<div id='"+btnActionId+"__div' class='list-actions-div' style='"+width+"'></div>");
		
		updateFieldLayer(getBaseURL()+$(this).data('url'),'','',btnActionId+'__div','');
		repositionDropDownDiv(btnActionId);
		
		//Add the action link near the div
		$(this).before("<a href='javascript:;' class='shadowbox' id='"+btnActionId+"__link' style='display:none;'></a>");
	});
	
	// Close the drop down divs if the user resizes the window
	$(window).resize(function() { 
		$('.list-actions-div').fadeOut('fast');
	});
	
	
	// What happens if you click on a list action div
	$(document).on('click', '.list-actions-div div', function(event){
		var clickedDiv = $(this);
		var url = getBaseURL()+clickedDiv.data('url');
		
		// Get where the target div where the selected items are to be collected from
		var parentDiv = $(this).parents('.list-actions-div').first().attr('id');
		var triggerDiv = parentDiv.replace(/__div/g, '');
		var targetDiv = $('#'+triggerDiv).data('targetdiv');
		
		if(typeof targetDiv !== 'undefined'){
			var selectedIds = [];
			$('#'+targetDiv).find('.bigcheckbox').each(function(){
				if($(this).is(':checked')) selectedIds.push($(this).val());
			});
			
			// Now add the selected ids to the url to send to the backend
			if(selectedIds.length > 0) {
				url += '/list/'+selectedIds.join('--');
				
				//Update the action link and click it
				$('#'+triggerDiv+'__link').attr('href',url);
				//Does the action require confirmation to proceed?
				if(clickedDiv.hasClass('confirm-action')){
					if(window.confirm('Are you sure you want to proceed with this action?')){
						$('#'+triggerDiv+'__link').click();
					}
				} 
				// use shadowpage instead of shadowbox?
				else if(clickedDiv.hasClass('use-shadowpage')){
					$('#'+triggerDiv+'__link').removeClass('shadowbox').addClass('shadowpage');
					$('#'+triggerDiv+'__link').click();
				} else {
					$('#'+triggerDiv+'__link').click();
				}
			}
			else showServerSideFadingMessage('You have to check an item for this action.');
		}
		// If the item is independent of the checked items
		else {
			//Update the action link and click it
			$('#'+triggerDiv+'__link').attr('href',url);
			//Does the action require confirmation to proceed?
			if(clickedDiv.hasClass('confirm-action')){
				if(window.confirm('Are you sure you want to proceed with this action?')){
					if(clickedDiv.hasClass('ignore-pop')) document.location.href = url;
					else $('#'+triggerDiv+'__link').click();
				}
			} else {
				//should we use a shadowbox or go straight to the link
				if(clickedDiv.hasClass('ignore-pop')) document.location.href = url;
				else $('#'+triggerDiv+'__link').click();
			}
		}
		clickedDiv.parents('.list-actions-div').first().remove();
	});
	
	
	// if the user clicked away, then close the div
	$(document).mouseup(function (e)
	{
    	var container = $('.list-actions-div');

    	if (!container.is(e.target) // if the target of the click isn't the container...
        	&& container.has(e.target).length == 0) // ... nor a descendant of the container
    	{
        	container.hide();
			$(document).find('.list-actions').each(function(){
				$(this).removeClass('selected');
			});
    	}
	});
	
	
	
	
	
	
	
	
	
	
	// Side-ways drop down function
	$(document).on('click', '.sideways-drop-down div', function(event){
		var parentId = $(this).parent('.sideways-drop-down').attr('id');
		var action = ($(this).hasClass('next')? 'next':($(this).hasClass('previous')? 'previous': 'list'));
		var extraFields = $('#'+parentId).data('fields')? $('#'+parentId).data('fields'): '';
		
		//Extract the extra fields
		var fields = extraFields.split('|');
		var extraUrl = '';
		for(var i=0; i<fields.length; i++){
			var fieldAttr = fields[i].split('=');
			var fieldValue = $('#'+fieldAttr[0]).val();
			if(fieldValue != ''){
				extraUrl += '/'+fieldAttr[1]+'/'+replaceBadChars($('#'+fieldAttr[0]).val());
			}
		}
		
		
		
		//Only show list if the action is list, otherwise, simply update the final destination div
		if(action == 'list')
		{
			if($('#'+parentId+'__div').length > 0) $('#'+parentId+'__div').remove();
			$('#'+parentId).before("<div id='"+parentId+"__div' class='sideways-drop-down-div' style='display:none;'></div>");
			$('#'+parentId+'__div').width($('#'+parentId).outerWidth());
			
			repositionDropDownDiv(parentId);
			var url = getBaseURL()+$('#'+parentId).data('url')+'/t/'+$('#'+parentId).data('type')+'/d/'+$('#'+parentId).data('target');
			updateFieldLayer(url+extraUrl,'','',parentId+'__div','');
		}
		//Update destination div
		else {
			var listString = $('#'+parentId+'__list').val();
			var listArray = listString.split('|');
			var currentItemDisplayDiv = $('#'+parentId).find('.list').first();
			var currentText = currentItemDisplayDiv.html();
			var currentPosition = listArray.indexOf(currentText);
			var listLength = listArray.length;
			
			//Update the scrolling list display div
			if(currentPosition != -1){
				//Next
				if(action == 'next'){
					var newPostion = (currentPosition + 1 == listLength)? 0: (currentPosition + 1);
				} 
				//Previous
				else {
					var newPostion = (currentPosition - 1 < 0)? (listLength - 1): (currentPosition - 1);
				}
				var displayText = listArray[newPostion];
				currentItemDisplayDiv.html(displayText);
				
				//Update the hidden tracking areas with the current view
				var selectedView = displayText.toLowerCase().replace(/ /g, '_');
				$('#'+parentId).data('type', selectedView);
				$('#'+parentId+'__selected').val(selectedView);
			}
			
			var url = getBaseURL()+$('#'+parentId).data('url')+'/t/'+$('#'+parentId).data('type')+'/a/'+action;
			
			//Then update the list itself
			updateFieldLayer(url+extraUrl,'','',$('#'+parentId).data('target'),'');
		}
		
	});
	
	
	
	// If user clicks on the drop down menu option instead
	$(document).on('click', '.sideways-drop-down-div div', function(event){
		var parentId = $(this).parents('.sideways-drop-down-div').first().attr('id').replace(/__div/g, '');
		var extraFields = $('#'+parentId).data('fields')? $('#'+parentId).data('fields'): '';
		
		//Extract the extra fields
		var fields = extraFields.split('|');
		var extraUrl = '';
		for(var i=0; i<fields.length; i++){
			var fieldAttr = fields[i].split('=');
			var fieldValue = $('#'+fieldAttr[0]).val();
			if(fieldValue != ''){
				extraUrl += '/'+fieldAttr[1]+'/'+replaceBadChars($('#'+fieldAttr[0]).val());
			}
		}
		
		var listString = $('#'+parentId+'__list').val();
		var listArray = listString.split('|');
		var currentItemDisplayDiv = $(this);
		var currentText = currentItemDisplayDiv.html();
		var currentPosition = listArray.indexOf(currentText);
		var listLength = listArray.length;
			
		//Update the scrolling list display div
		if(currentPosition != -1){
			var displayText = listArray[currentPosition];
			$('#'+parentId).find('.list').first().html(displayText);
				
			//Update the hidden tracking areas with the current view
			var selectedView = displayText.toLowerCase().replace(/ /g, '_');
			$('#'+parentId).data('type', selectedView);
			$('#'+parentId+'__selected').val(selectedView);
		}
			
		//Then update the list itself
		var url = getBaseURL()+$('#'+parentId).data('url')+'/t/'+$('#'+parentId).data('type'); 
		updateFieldLayer(url+extraUrl,'','',$('#'+parentId).data('target'),'');
		
		$('#'+parentId+'__div').remove();
	});
	
	
	
	
	// if the user clicked away, then close the list
	$(document).mouseup(function (e)
	{
    	var container = $('.sideways-drop-down-div');

    	if (!container.is(e.target) // if the target of the click isn't the container...
        	&& container.has(e.target).length == 0) // ... nor a descendant of the container
    	{
        	container.remove();
    	}
	});
	
	
	
	
	
	
	
	
	
	
	// How to handle select all checkbox
	$(document).on('click', '#selectallcheck', function(event){
		var parentTable = $(this).parents('table').first();
		
		if($(this).is(':checked')){
			parentTable.find('.bigcheckbox').each(function(){ $(this).prop('checked', true);});
		} else {
			parentTable.find('.bigcheckbox').each(function(){ $(this).prop('checked', false);});
		}
	
	
	});
	
	
	
	
	
	
	// Handle changing of value on a goto drop down
	$(document).on('change', '.go-to-selected', function(event){
		if($(this).data('baseurl')){
			document.location.href = getBaseURL()+$(this).data('baseurl')+'/'+replaceBadChars($(this).val());
		}
	});
	
	
	
	
	
	
	
	
	// Clicking on an accordion row
	$(document).on('click', '.accordion-row', function(event){
		var clickedRow = $(this);
		// Is already selected
		if(!clickedRow.hasClass('selected') && !$(event.target).is(':radio')) {
			//First remove all selected classes from the other accordion rows
			clickedRow.parents('table').first().find('.accordion-row').each(function(){
				$(this).removeClass('selected');
			});
			clickedRow.addClass('selected');
		}
	});
	
	// Clicking on an accordion row
	$(document).on('click', '.accordion-row input[type=radio]', function(event){
		var checkboxes = $(this).parents('.accordion-row').first().find('div:eq(1)').first().find('.bigcheckbox');
		
		if($(this).val() == 'none'){
			checkboxes.each(function(){
				$(this).prop('checked', false);
			});
		}
		
		if($(this).val() == 'all'){
			checkboxes.each(function(){
				$(this).prop('checked', true);
			});
		}
		
		if($(this).val() == 'custom'){
			var myAccordionRow = $(this).parents('.accordion-row').first();
			myAccordionRow.parents('table').first().find('.accordion-row').each(function(){
				$(this).removeClass('selected');
			});
			myAccordionRow.addClass('selected');
		}
	});
	
	
	// If a checkbox is clicked in the accordion row, change the checked radio to custom
	$(document).on('click', '.accordion-row .bigcheckbox', function(event){
		$(this).parents('.accordion-row').first().find('div:eq(0)').first().find('input[type=radio]').each(function(){
			if($(this).val() == 'custom'){
				$(this).prop('checked', true);
			}
		});
	});
	
	
	// highlight a checked box's row if the user has clicked it and it is checked
	$(document).on('click', '.highlight-checked', function(event){
		if($(this).data('url')) var postUrl = getBaseURL()+$(this).data('url');
		
		if($(this).is(':checked')) {
			if($(this).data('url')) postUrl += '/action/add';
			$(this).parents('tr').first().addClass('row-highlight');
		} else {
			if($(this).data('url')) postUrl += '/action/remove';
			$(this).parents('tr').first().removeClass('row-highlight');
		}
		
		// post to the user url if there are is a post url specified
		if($(this).data('url')){
			$.ajax({
        		type: "POST", url: postUrl, data: {}, beforeSend: function() {},
				error: function( xhr, textStatus, errorThrown) {},
      	 		success: function(data) { /*console.log('END LOG: '+data);*/}
			});
		}
	});
	
	
	
	
	
	
	
	
	
	
	// Handle additional toggle radio functionality
	// For basic behaviour, see the sitewide .js file (clout.js)
	$(document).on('click', '.toggle-radio', function(){ 
		//Only proceed if there is an action on the radio
		if($(this).data('actionurl')){
			var toggleBtn = $(this);
			var action = getBaseURL()+$(this).data('actionurl');
			var value = $(this).hasClass('on')? 'ON': 'OFF';
		
			var parameters = {
        		type: "POST",
       			url: action,
      			data: {'value': value},
				// What to do as the data is being processed
      			beforeSend: function() {},
				error: function( xhr, textStatus, errorThrown) {
    				//console.log('LOG: '+xhr.responseText);
					showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
				},
      	 		success: function(data) {
					if(data.match(/error/i)) {
						//console.log('END LOG: '+data);
						// Revert the click value
						if(value=='OFF') toggleBtn.addClass('on');
						else  toggleBtn.removeClass('on');
						
						showServerSideFadingMessage('ERROR: Something went wrong. The '+toggleBtn.data('type')+' could not be turned '+value+'.');
					} 
					//Submission was successful
					else {
						showServerSideFadingMessage('The '+toggleBtn.data('type')+' has been turned '+value+'.');
					}
				}
			}
		
			//Run the ajax parameters
			$.ajax(parameters);
		}
	});
	
	
	
	
	
	
	
	
	
	
	// Functionality to edit an item in line
	$(document).on('click', '.edit-in-line', function(event){
		var callerObj = $(this);
		var id = $(this).data('id');
		var action = $(this).data('actionurl');
	
		if($('.edit-in-line-div').length > 0) $('.edit-in-line-div').each(function(){ $(this).remove();});
		if($('.edit-in-line').length > 0) $('.edit-in-line').each(function(){ $(this).show('fast');});
		
		callerObj.hide('fast');
		callerObj.after("<div id='"+id+"__div' class='edit-in-line-div' data-actionurl='"+action+"/a/save'></div>");
		
		updateFieldLayer(getBaseURL()+action,'','',id+'__div','');
	});
	// Submit to save on focus out
	$(document).on('focusout', '.submit-focus-out', function(event){
		var fieldObj = $(this);
		var formObj = $(this).parents('.edit-in-line-div').first();
		var value = $(this).val();
		
		if($.trim(value) !='')
		{
			var parameters = {
        		type: "POST",
       			url: getBaseURL()+formObj.data('actionurl'),
				// How to handle getting the "form" data
      			data: {'value': value},
				// What to do as the data is being processed
      			beforeSend: function() {},
				error: function( xhr, textStatus, errorThrown) {
    				//console.log('LOG: '+xhr.responseText);
					showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
				},
      	 		success: function(data) {
					if(data.match(/error/i)) {
						showServerSideFadingMessage('ERROR: Something went wrong. The '+fieldObj.data('type')+' could not be saved.');
					} else {
						showServerSideFadingMessage('The '+fieldObj.data('type')+' data has been saved.');
						var originatorId = formObj.attr('id').replace(/__div/gi, '');
						$("a[data-id='"+originatorId+"']").html(value).show('fast');
						formObj.remove();
					}
				}
			}
		
			//Run the ajax parameters
			$.ajax(parameters);
		}
		// The field is required to continue
		else {
			showServerSideFadingMessage('ERROR: Enter a value to proceed.');
		}
	});
	
	
	
	
	
	
	
	
	
	
	// search through a list of data stored in the session
	$(document).on("keyup", ".in-session-search", function(){ 
		var searchField = $(this);
		var phrase = searchField.val();
		if(phrase.length > 3){
			var listName = searchField.data('sessionlist');
			var fields = replaceBadChars(searchField.data('searchfields'));
			updateFieldLayer(getBaseURL()+'transaction/search_in_session/id/'+searchField.attr('id').split('_')[1]
				+'/list_name/'+listName+'/fields/'+fields+'/phrase/'
				+replaceBadChars(phrase),'','',searchField.attr('id')+'__results','');
		}
	});
	
	
	
});
























// Remove user data from the submitted store form
function removeUserDataFromLocationForm(formContainer, descriptorId)
{
	// Clear the input fields
	formContainer.find('.smalltextfield').each(function(){ $(this).val('');});
	formContainer.find('.small-drop-down').each(function(){ $(this).prop('selectedIndex', 0);});
	
	// Clear the divs
	$('#storelinks_'+descriptorId).html('');
	$('#googleresults_'+descriptorId).html('');
}


 



// remove a flag class from the element
function removeFlagClass(elementId, className, placeHolder, thisElement)
{
	$('#'+elementId).removeClass(className);
	$('#'+elementId).attr('placeholder', placeHolder);
	$('#'+thisElement).hide('fast');
	if($('#'+elementId+'__hidden').length > 0) $('#'+elementId+'__hidden').val('');
}





// Post a checkbox list with the stubs shown
function postCheckBoxList(btnId, checkboxIdStub, destination, action)
{
	var formdata = []; 
	$(document).find('input[type=checkbox]').each(function(){
		var checkboxId = $(this).attr('id');
		
		if(checkboxId.indexOf(checkboxIdStub) > -1 && $(this).is(':checked')){
			formdata.push({ "id": checkboxId, "name": $(this).attr('name'), "value":$(this).val()});
		}
	});
	
	var parameters = {
        type: "POST",
       	url: action,
		// How to handle getting the "form" data
      	data: $.param(formdata),
				
		// What to do as the data is being processed
      	beforeSend: function() {
          	showWaitDiv('start');
		},
		error: function( xhr, textStatus, errorThrown) {
    		//console.log(xhr.responseText);
			if(tempMessage == '') showWaitDiv('end');
			showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
		},
      	success: function(data) {
			showWaitDiv('end');
			console.log(data);
			if(data.match(/php error/i) || data.match(/error:/i)) {
				showServerSideFadingMessage('ERROR: Something went wrong. We can not submit your data.');
			}
			else {
				$('#'+btnId).parents(destination).first().html(data);
			}
		}
	}
	
	//Now run the AJAX query
	$.ajax(parameters);
}





// Update match search field
function updateMatchField(searchType)
{
	var fieldId = $("input[data-id='matchsearchfield']").attr('id');
	var fieldName = $("input[data-id='matchsearchfield']").attr('name');
	var fieldPlaceholder = $("input[data-id='matchsearchfield']").attr('placeholder');
	
	if(searchType == 'store') {
		$("input[data-id='matchsearchfield']").attr('id', fieldId.replace(/chain/gi, "store"));
		$("input[data-id='matchsearchfield']").attr('name', fieldName.replace(/chain/gi, "store"));
		$("input[data-id='matchsearchfield']").attr('placeholder', fieldPlaceholder.replace(/Chain/gi, "Store"));
		
	} else if(searchType == 'chain') {
		$("input[data-id='matchsearchfield']").attr('id', fieldId.replace(/store/gi, "chain"));
		$("input[data-id='matchsearchfield']").attr('name', fieldName.replace(/store/gi, "chain"));
		$("input[data-id='matchsearchfield']").attr('placeholder', fieldPlaceholder.replace(/Store/gi, "Chain"));
	}
}



// Select the category item during matching
function selectCategoryItem(elementId, elementDiv)
{
	clickItem(elementId);
	var linkText = $('#'+elementDiv+' > a:first-child').text();
	//record the session click
	updateFieldLayer(getBaseURL()+'transaction/add_to_session/item/'+elementDiv,'','',elementDiv,'');
	//Remove the clickable link
	$('#'+elementDiv).replaceWith( "<br><i>"+linkText+"</i>");
}



