$(document).ready(function() {
	//TODO fix jQuery object serch
	var viewScore = $('.view-score');
	var detailsWindow = $('.details-window');
	var statusBtn = $('.pause');
	var rootContainer = $('.promotion-list');
	var addCashbackWindow = $('.add-cashback');
	var locationWrap = $('.location-wrap');
	var locations = $('.location-wrap');
	var addresses = $('.adress-wrap');
	var selectedStates = [];
	var selectedCoutries = [];
	var searchField = $('.view-loc input[name="search"]');
	var quickAddCashBack = $('.cashback-part-prew');
	var quickAddPerk = $('.perk-part-prew');
	var responseStoreArray = [];
	var storeArray = [];
	var storeId;
	var date = new Date();
	var cashBackProcent = 0;
	var score;
	var changeData = false;
	var todayDate = date.getFullYear().toString()+'-'+(date.getMonth()+1).toString()+'-'+date.getDate().toString();
	var prmotionScores = {'0':[],'100':[],'200':[],'300':[],'400':[],'500':[],'600':[],'700':[],'800':[],'900':[],'1000':[]}
	var promotionId;
	var updatePromotionObj = {
		"userId": +i_user_id,
		"endScore": 2000000
	};

	//This is for sending to backeng client current date
	function currentDate() {
		var currdate = date.getFullYear().toString()+'-'+(date.getMonth()+1).toString()+'-'+date.getDate().toString() +' ' +date.getHours().toString()+':'+date.getMinutes().toString()+':'+date.getMilliseconds().toString();
		return currdate;
	}

	//Calculateing the differense between dates
	var DateDiff = {
		inDays: function(d1, d2) {
			var t2 = new Date(d2).getTime();
			var t1 = new Date(d1).getTime();
			return parseInt((t2-t1)/(24*3600*1000));
		}
	};

	function setChangeDataToTrue(element) {
		addCashbackWindow.find(element).each(function(i, item) {
			$(item).on('change', function() {
				changeData = true;
			});
		});
	}
	setChangeDataToTrue('input:radio');
	setChangeDataToTrue('input:checkbox');
	setChangeDataToTrue('input[type=number]');
	setChangeDataToTrue('select');

	function ifPerk(item, element) {
		if (item.promotion_type === 'perk') {
			element.find('.detail-img').css('background-image', 'url(/assets/images/perk-bg.png)');
			element.find('.detail-img p').text('PERK');
		}
	}

	function openFirstTabAndSettings(window) {
		addCashbackWindow.find('.settings').each(function() {
			var that = $(this);
			if(that.data('id')==window) {
				addCashbackWindow.find('.settings').hide();
				that.fadeIn(300);
			}
		});
		addCashbackWindow.find('.tab-wrap').each(function() {
			var that = $(this);
			if(that.data('id')==window) {
				addCashbackWindow.find('.tab-wrap').removeClass('active-tab');
				that.addClass('active-tab');
			}
		});
		$('.options-btn input').each(function(input) {
			input[0].checked = false;
		});
	};

	//function to set all data to all fields when you whant to update the promotion
	function settingsToUpdateProm(bgimg, promName, imgText, flexProp, showOrHide, displayProp, promType) {
		updatePromotionObj.name = promName;
		addCashbackWindow.find('.cashback-icon').css('background-image', bgimg);
		addCashbackWindow.find('.cashback-icon p').text(imgText);
		addCashbackWindow.find('.new-cashback-title span').text(promName);
		addCashbackWindow.find('.add-cashback-main').css('justify-content', flexProp).find('.cashback-procent').css('display', showOrHide);
		addCashbackWindow.find('.spend-wrap, .black-time').css('display', displayProp);
		addCashbackWindow.attr('data-type', promType);
		addCashbackWindow.find('.tab-wrap').each(function() {
			var that = $(this);
			if(that.data('id')=='1') {
				that.hide();
			}
		});
		openFirstTabAndSettings('2');
	}

	function editBtnClick() {
		var that = $(this);
		var sliceDate = -9;
		var perkBgImg = 'url(/assets/images/perk-bg.png)';
		var cashbackBgImg = 'url(/assets/images/detail-rang-lightgreen.png)';
		var promSettings = JSON.parse(that.closest('.detail-block').attr('data-item'));
		setPropToDefault();
		detailsWindow.children().hide();
		addCashbackWindow.show().attr('data-id', promSettings.id);
		promotionId = addCashbackWindow.attr('data-id');
		updatePromotionObj.startScore = +score;
		updatePromotionObj.id = +promotionId;
		updatePromotionObj.amount = promSettings.amount;
		// addCashbackWindow.find('.tabs').closest('.tab-wrap');
		addCashbackWindow.find('.custom-date').val(promSettings.start_date.slice(0, sliceDate));
		addCashbackWindow.find('.custom-end-date').val(promSettings.end_date.slice(0, sliceDate));
		if(promSettings.promotion_type === "cashback") {
			settingsToUpdateProm(cashbackBgImg, 'Cash Back', promSettings.cash_back_percentage + ' %', 'space-between', 'block', 'none', 'cashback');
			addCashbackWindow.find('.cashback-procent input').val(promSettings.cash_back_percentage);
		} else {
			settingsToUpdateProm(perkBgImg, promSettings.name, 'PERK', 'flex-end', 'none', 'block', 'perk');
		}
	}

	$(document).on('click', '.edit-button',editBtnClick);

	//Show promotions by it's score
	function showPromotionByScore(score) {
		prmotionScores[score].forEach(function(item) {
			var element = $(templatePromotions(item));
			element.attr("data-item",JSON.stringify(item));
			element.find('.edit-button').on('click',editBtnClick);
			rootContainer.append(element);
			styleStatus(item, element);
		});
	}

	function proccesData(){
		var current = null;
		var cancelBtn = addCashbackWindow.find('.cancel-btn');
		function openModal(item){
			var color = item.css('background-color');
			var link = item.find('a');
			cancelBtn.click();
			detailsWindow.css('border-color',color);
			detailsWindow.slideToggle('slow');
			item.css('background-color','transparent');
			link.css({'background-color': 'transparent', 'border-color': color, 'border-bottom-color': '#fff', 'height': '31px', 'color': '#000'});
			rootContainer.empty();
			console.log(item.parent().attr('id'));
			if(item.parent().attr('id') == 0) {
				showPromotionByScore(0)
			} else if (item.parent().attr('id') == 100) {
				showPromotionByScore(100)
			} else if (item.parent().attr('id') == 200) {
				showPromotionByScore(200)
			} else if (item.parent().attr('id') == 300) {
				showPromotionByScore(300)
			} else if (item.parent().attr('id') == 400) {
				showPromotionByScore(400)
			} else if (item.parent().attr('id') == 500) {
				showPromotionByScore(500)
			} else if (item.parent().attr('id') == 600) {
				showPromotionByScore(600)
			} else if (item.parent().attr('id') == 700) {
				showPromotionByScore(700)
			} else if (item.parent().attr('id') == 800) {
				showPromotionByScore(800)
			} else if (item.parent().attr('id') == 900) {
				showPromotionByScore(900)
			} else if (item.parent().attr('id') == 1000) {
				showPromotionByScore(1000)
			}
		}

		function hideModal(item,current,action){
			detailsWindow.slideToggle(300,function(){
				var btnFindA = current.find('a');
				current.css('background-color',btnFindA.css('border-top-color'));
				btnFindA.css({'color': '#fff', 'border-bottom-color': 'transparent', 'height': '26px'});
				if(action) {
					action(item);
				}
			});
		}

		function proccesClick(e){
			var that = $(this);
			score = that.parent().attr('id');
			if(current){
				if(that.is(current)) {
					hideModal(that,current);
				} else {
					hideModal(that,current,openModal);
				}
			} else {
				openModal(that);
			}
			current = that;
			e.preventDefault();
		}
		viewScore.click(proccesClick);
	}


	proccesData();

//All that consists in this part is about loading promotions and sending it's status to server
function templatePromotions(val) {
	if(val.promotion_type == 'cashback'){
		var procentIcon = ''+ val.cash_back_percentage +' %'
		$('.detail-block').find('.detail-img').text();
	}
	return '<div  data-promotion-type="' + val.promotion_type + '" data-is-boosted="' + val.is_boosted + '" data-type="' + val.promotion_type + '" data-score="' + val.score + '" class="detail-block">' +
	'<div class="main-group">' +
	'<div class="detail-img">' +
	'<p> '+ procentIcon +' </p>' +
	'</div>' +
	'<div class="detail-item">' +
	'<h3>' + val.name + '</h3>' +
	'<button class="edit-button"></button>'+
	'<button class="delete-button"></button>'+
	'<span>' +val.description+ '</span>'+
	'</div>' +
	'</div>' +
	'<div class="group">' +
	'<div class="descr">' +
	'<p><span class="part-of-descr">$' + val.amount + ' Gross Sales during ' + DateDiff.inDays(val.start_date, val.end_date) + ' days active.</span>\n Reedemed ' + val.number_redeemed + ' times</p>' +
	'</div>' +
	'<div class="second-group">' +
	'<div class="status">'+ val.status+'</div>' +
	'<button data-id="' + val.id + '" class="act-btn">Pause</button>' +
	'</div>' +
	'</div>' +
	'</div>'
}

//Function for styling promotions, change it's pictures and status
function styleStatus(item, element) {
	ifPerk(item, element);
	if (item.status === 'inactive') {
		element.find('.status').addClass('stage-inactive');
		element.find('.act-btn').addClass('publish').html('Publish');
	} else if (item.status === 'pending') {
		element.find('.status').addClass('stage-pending');
		element.find('.act-btn').addClass('cancel').html('Cancel');
	} else if (item.status === 'active') {
		element.find('.status').addClass('stage-active');
		element.find('.act-btn').addClass('pause').html('Pause');
	}	else if (item.status === 'deleted') {
		element.find('.status').addClass('stage-deleted').css('margin-right', '0px');
		element.find('.act-btn').remove();
	}
};

//Save all promotions by it's amount
function calcAmout(val) {
	if(val.score >= 0 && val.score < 100) {
		prmotionScores[0].push(val);
	} else if(val.score >= 100 && val.score < 200) {
		prmotionScores[100].push(val);
	} else if(val.score >= 200 && val.score < 300) {
		prmotionScores[200].push(val);
	} else if(val.score >= 300 && val.score < 400) {
		prmotionScores[300].push(val);
	} else if(val.score >= 400 && val.score < 500) {
		prmotionScores[400].push(val);
	} else if(val.score >= 500 && val.score < 600) {
		prmotionScores[500].push(val);
	} else if(val.score >= 600 && val.score < 700) {
		prmotionScores[600].push(val);
	} else if(val.score >= 700 && val.score < 800) {
		prmotionScores[700].push(val);
	} else if(val.score >= 800 && val.score < 900) {
		prmotionScores[800].push(val);
	} else if(val.score >= 900 && val.score < 1000) {
		prmotionScores[900].push(val);
	} else if(val.score >= 1000) {
		prmotionScores[1000].push(val);
	}
};

//Show amount of promotions on the page
function findScore(id, typeScore) {
	var target = $('#'+id).find(typeScore);
	target.text(parseInt(target.text())+1);
};

//Calculate the amount of promotion and show it amount on the page
function calcScoreOfPromotion(val) {
	var steps=[0,100,200,300,400,500,600,700,800,900,1000];
	for(var i = 0; i<steps.length; i++){
		if(steps[i]>val.score) {
			findScore(steps[i-1], val.promotion_type === 'perk'?'.perk-score':'.cashback-score');
			break;
		} else if(steps[i]<val.score && i == steps.length) {
			findScore(steps[11], val.promotion_type === 'perk'?'.perk-score':'.cashback-score');
			break;
		}
	}
}

//This is for loading all promotions
api.get('promotion/',{'userId':i_user_id,'storeId':4, 'minScore':0, 'curDate': currentDate()},function(result){
	if(result.success || result == null) {
		alert('loading failed');
	} else {
		result.forEach(function(val, i){
			if(val.custom_category_id==0 || val.custom_category_id==null) {
				calcAmout(val);
				calcScoreOfPromotion(val);
			}
		});
	}
}, function() {
	$('.load-sircle').css('display', 'block');
}, function() {
	$('.load-sircle').css('display', 'none');
	$('.score-content, .score-menu').css('display', 'block');
	$('.view-score:eq(0)').click();
});

//This is for changing promotion status
$(document).on('click', '.act-btn', function(){
	var that = $(this);
	var status = $('.status');
	var dataObj = {
		"userId":i_user_id,
		"promotionId": $(that).attr('data-id'), 
		"newStatusAction": $(that).text().toLowerCase()
	};
	api.post('promotion/status', JSON.stringify(dataObj), function(response){
		console.log('response true');
		if(response.success === true) {
			if($(that).hasClass('pause')) {
				$(that).removeClass('pause').addClass('publish').html('Publish');
				$(that).parent()	
				.children('.status').removeClass('stage-active').addClass('stage-inactive').html('inactive');
			} else if($(that).hasClass('publish')) {
				$(that).removeClass('publish').addClass('pause').html('Pause');
				$(that).parent()
				.children('.status').removeClass('stage-inactive').addClass('stage-active').html('active');
			} else if($(that).hasClass('cancel')) {
				$(that).parent()	
				.children('.status').removeClass('stage-pending').addClass('stage-deleted').html('deleted').css('margin-right','0px');
				$(that).remove();
			}
		}
	});
});
// End of section with promotions

//function that set radio buttons in AddCashbackWindow to false
function setRadioToFalse(inputBlock) {
	addCashbackWindow.find(inputBlock).find('input:radio').each(function(i,item){
		$(item).prop('checked')==true ? $(item).prop('checked', false) : $(item).prop('checked', false)
	});	
}

//function that resets all radio buttons and inputs to 0
function setPropToDefault() {
	var settingsForWindow = {
		custom_date: "0000-00-00",
		checked_false: false,
		precent_input_val: ""
	};
	addCashbackWindow.find('.cashback-procent input').val(settingsForWindow.precent_input_val);
	addCashbackWindow.find('.custom-date').val(settingsForWindow.custom_date);
	addCashbackWindow.find('.custom-end-date').val(settingsForWindow.custom_date);
	setRadioToFalse('.date-block');
	setRadioToFalse('.end-date-block');
}

//This function change addCashBackWindow when you want to add new promotion
//the type is perk or cashback
function changeAddCashBackWindow(text, bgimg, flexProp, iconText, dataType) {
	addCashbackWindow.find('.locations:eq(0)')
	.find('input').click();
	addCashbackWindow.find('.new-cashback-title span').text(text);
	addCashbackWindow.find('.cashback-icon').css('background', bgimg);
	addCashbackWindow.find('.add-cashback-main').css('justify-content', flexProp);
	addCashbackWindow.find('.cashback-icon p').text(iconText);
	addCashbackWindow.attr('data-type', dataType);
	addCashbackWindow.find('.type-of-stores').find('input:radio').each(function(i, item) {
		$(item).prop('checked', false);
	});
	addCashbackWindow.find('.search-location').hide();
}

$('.options-btn').click(function() {
	var that = $(this);
	detailsWindow.children().css('display', 'none');
	addCashbackWindow.css('display', 'block');
	setPropToDefault();
	addCashbackWindow.find('.tab-wrap').each(function() {
		var that = $(this);
		if(that.data('id')=='1') {
			that.show();
		}
	});
	if(that.hasClass('cashback')) {
		changeAddCashBackWindow('Cash Back', 'url(/assets/images/detail-rang-lightgreen.png)', 'space-between', '0 %', 'cashback');
		addCashbackWindow.find('.cashback-procent').show();
		addCashbackWindow.find('.spend-wrap').hide();
		addCashbackWindow.find('.black-time').hide();
	} else if (that.hasClass('perk')) {
		setRadioToFalse('.spend-wrap div');
		changeAddCashBackWindow('Perk', 'url(/assets/images/perk_bg.png)', 'flex-end', 'PERK', 'perk');
		addCashbackWindow.find('.cashback-procent').hide();
		addCashbackWindow.find('.spend-wrap').show();
		addCashbackWindow.find('.black-time').show();
	}
	openFirstTabAndSettings('1');
});


function activeTabs() {
	var tabsBtn = $('.tab-wrap');
	$(tabsBtn).click(function(e) {
		var that = $(this);
		var index = that.data('id');
		var settings = $('.settings');
		settings.hide();
		tabsBtn.removeClass('active-tab');
		that.addClass('active-tab');
		var targetSettings = settings.filter(function(item){
			return this.getAttribute('data-id') == index;
		});
		targetSettings.show();
		e.preventDefault();
	});
}
activeTabs();

//This function selects all checkboxes
function selectAll(element, checkList) {
	$(element).click(function(){
		$(checkList).prop('checked', this.checked);
	});
}
selectAll("#select-all-countries", ".location-list input:checkbox");

//Show spesific search for stores or hide if i need to take all my stores
function showAndHideSearch(button, displayProp) {
	$(document).on('click', button, function() {
		var that = $(this);
		$('.search-location').css('display', displayProp);
	});
}
showAndHideSearch('.spesific', 'block');
showAndHideSearch('.all-stores', 'none');

function showAndHideQuickAddPromotion(btn, hideBlock, showBlock) {
	$(btn).click(function(e) {
		$(hideBlock).hide();
		$(showBlock).css('display', 'flex');
		e.preventDefault();
		if(btn == '.cashback-part-prew .cancel-btn' || btn == '.perk-part-prew .cancel-btn') {
			quickAddCashBack.find('input').val('');
			quickAddPerk.find('input').val('');
			quickAddPerk.find('textarea').val('');
		} else if(btn == '.cashback-part a') {
			quickAddPerk.hide();
			quickAddPerk.find('input').val('');
			quickAddPerk.find('textarea').val('');
			$('.perk-part').show();
		} else if(btn == '.perk-part a') {
			quickAddCashBack.hide();
			quickAddCashBack.find('input').val('');
			$('.cashback-part').show();
		}
	});
}
showAndHideQuickAddPromotion('.cashback-part a', '.cashback-part', quickAddCashBack);
showAndHideQuickAddPromotion('.perk-part a', '.perk-part', quickAddPerk);
showAndHideQuickAddPromotion('.cashback-part-prew .cancel-btn', quickAddCashBack, '.cashback-part');
showAndHideQuickAddPromotion('.perk-part-prew .cancel-btn', quickAddPerk, '.perk-part');

//Search stores with the search field
searchField.on('input', function(){
	var timer;
	var _this = this;
	clearTimeout(timer);
	timer = setTimeout(function(){
		api.get('search/stores_by_name', {name: _this.value}, function(res){
			responseStoreArray = [];
			addresses.show();
			addresses.find('.adress-list').empty();
			res.forEach(function(store){
				responseStoreArray.push(store);
				addresses.find('.adress-list').append(
					"<li>"+
					"<div class='squaredCheck'>" +
					"<input type='checkbox' data-id='"+store.id+"' id='"+store.id+"' />" +
					"<label for='"+store.id+"'></label>" +
					"</div>"+ store.address_line_1 +", " + store.city + ", " +store.state + ", " + store.zipcode + "</li>"
					);
			})
		})
	}, 1000);
});


//Select how i whant to serch stores
$('.locations').on('click', function(){
	var _this = $(this);
	$('#select-all-countries').prop('checked', false);
	if(_this.find('span').text() !== 'all'){
		searchField.attr('disabled', true)
	} else {
		searchField.attr('disabled', false)
		addresses.hide()
		.find('.adress-list').empty();
		locations.hide();
		locationWrap.find('.location-list').empty();
	}
	if(_this.find('span').text() === 'state'){
		api.get('search/states_list', { countries: 'USA' }, function(res){
			locations.show();
			addresses.hide()	
			.find('.adress-list').empty();
			locationWrap.find('.location-list').empty();
			res.forEach(function(state){
				locationWrap.find('.location-list').append(
					"<li class='search-input' data-type='state' data-id='"+ state.id + "' data-code='" + state.state_code + "'>"+
					"<div class='squaredCheck'>" +
					"<input type='checkbox' id='"+state.state_code+"' />" +
					"<label for='"+state.state_code+"'></label>" +
					"</div>"+ state.state_name + "</li>"
					);
			});
		});
	} else if(_this.find('span').text() === 'city'){
		api.get('search/cities_list', { countries: 'USA' }, function(res){
			locations.show();
			addresses.hide()
			.find('.adress-list').empty();
			locationWrap.find('.location-list').empty();
			res.forEach(function(city){
				locationWrap.find('.location-list').append(
					"<li class='search-input' data-type='city' data-id='"+ city.id + "' data-district='" + city.district + "'>"+
					"<div class='squaredCheck'>" +
					"<input type='checkbox' id='"+city.id+"' />" +
					"<label for='"+city.id+"'></label>" +
					"</div>"+ city.name + "</li>"
					);
			});
		});
	} else if(_this.find('span').text() === 'country'){
		api.get('search/countries', {}, function(res){
			locations.show();
			addresses.hide()
			.find('.adress-list').empty();
			locationWrap.find('.location-list').empty();
			res.forEach(function(country){
				locationWrap.find('.location-list').append(
					"<li class='search-input' data-type='country' data-code='" + country.country_code + "'>"+
					"<div class='squaredCheck'>" +
					"<input type='checkbox' id='"+country.country_code+"' />" +
					"<label for='"+country.country_code+"'></label>" +
					"</div>"+ country.country + "</li>"
					);
			});
		});
	}
});

//Search stores by city and by country
function searchStoresByCityAndCountry() {
	$(document).on('click', '.location-wrap input', function(){
		var that = $(this);
		selectedStates = [];
		selectedCountries = [];
		if(that.prop('checked')==true) {
			var locations = locationWrap.find('.location-list').find('li');
			locations.each(function(i,li){
				var _li = $(li);
				if(_li.data('type') === 'city'){
					if(_li.find('input')[0].checked){
						selectedStates.push(_li.text())
					}
				} else if (_li.data('type') === 'country'){
					if(_li.find('input')[0].checked){
						selectedCountries.push(_li.text())
					}
				}
			});
			api.get('search/stores_by_city', {
				city: selectedStates.toString().toLowerCase(),
				country: selectedCountries.toString().toLowerCase()
			}, function(res){
				if(res.length === 0 && res == null) {
					addresses.show();
					addresses.text('There is no stores in this city');
				} else {
					addresses.show();
					addresses.find('.adress-list').empty();
					responseStoreArray = [];
					res.forEach(function(address){
						responseStoreArray.push(address);
						addresses.find('.adress-list').append(
							"<li>"+
							"<div class='squaredCheck'>" +
							"<input type='checkbox' data-id='"+address.id+"' id='"+address.id+"' />" +
							"<label for='"+address.id+"'></label>" +
							"</div>"+ address.address_line_1 +", " + address.city + ", " +address.state + ", " + address.zipcode + "</li>"
							);
					});
				}
			});
		} else {
			addresses.find('.adress-list').empty();
		} 
		
	});
}
searchStoresByCityAndCountry();

//Cash back procent
$(document).on('input', '.cashback-part-add .cashback-procent input', function() {
	cashBackProcent = $('.cashback-part-add .cashback-procent input').val();
	$('.cashback-part-add .cashback-icon p').text(cashBackProcent);
	updatePromotionObj.cashBack = +cashBackProcent;
});

addCashbackWindow.find('.all-stores').on('click', function() {
	storeArray = [];
	api.get('promotion/all_stores', {'userId':i_user_id,'storeId':4}, function(response) {
		response.forEach(function(address) {
			if(addCashbackWindow.attr('data-type') === 'cashback'){
				address.promotionType = 'cashback';
			} else if (addCashbackWindow.attr('data-type') === 'perk') {
				address.promotionType = 'perk';
			}
			address.endDate = todayDate;
			address.startDate = todayDate;
			address.amount = 0;
			address.userId = i_user_id;
			address.custom_category_id = null;
			address.storeId = 4;
			address.endScore = 2000000;
			address.startScore = +score;
			address.name = 'Cash Back';
			address.description = 'test descr';
			address.blackouts = false;
			delete address.key_words;
			delete address._entered_by;
			delete address._last_updated_by;
			delete address._country_code;
			delete address._chain_id;
			delete address._primary_contact_id;
			delete address._state_id;
			delete address.address_line_1;
			delete address.address_line_2;
			delete address.city;
			delete address.clout_id;
			delete address.date_entered;
			delete address.email_address;
			delete address.has_multiple_locations;
			delete address.is_franchise;
			delete address.large_cover_image;
			delete address.last_updated;
			delete address.latitude;
			delete address.logo_url;
			delete address.longitude;
			delete address.online_only;
			delete address.phone_number;
			delete address.price_range;
			delete address.public_store_key;
			delete address.slogan;
			delete address.small_cover_image;
			delete address.star_rating;
			delete address.state;
			delete address.status;
			delete address.website;
			delete address.zipcode;
			delete address.start_date;
			storeArray.push(address);
		});
	});
});

//Choose stores from search list
$(document).on('click', '.adress-list input', function() {
	var that = $(this);
	if(that[0].checked) {
		storeId = 0;
		storeId = that.data('id');
		responseStoreArray.forEach(function(address, i){
			if(addCashbackWindow.attr('data-type') === 'cashback'){
				address.promotionType = 'cashback';
			} else if (addCashbackWindow.attr('data-type') === 'perk') {
				address.promotionType = 'perk';
			}
			address.endDate = todayDate;
			address.startDate = todayDate;
			address.amount = 0;
			address.userId = i_user_id;
			address.storeId = 4;
			address.custom_category_id = null;
			address.endScore = 2000000;
			address.startScore = +score;
			address.name = 'Cash Back';
			address.description = 'test descr';
			address.blackouts = false;
			delete address.key_words;
			delete address._entered_by;
			delete address._last_updated_by;
			delete address._country_code;
			delete address._chain_id;
			delete address._primary_contact_id;
			delete address._state_id;
			delete address.address_line_1;
			delete address.address_line_2;
			delete address.city;
			delete address.clout_id;
			delete address.date_entered;
			delete address.email_address;
			delete address.has_multiple_locations;
			delete address.is_franchise;
			delete address.large_cover_image;
			delete address.last_updated;
			delete address.latitude;
			delete address.logo_url;
			delete address.longitude;
			delete address.online_only;
			delete address.phone_number;
			delete address.price_range;
			delete address.public_store_key;
			delete address.slogan;
			delete address.small_cover_image;
			delete address.star_rating;
			delete address.state;
			delete address.status;
			delete address.website;
			delete address.zipcode;
			delete address.start_date;
			if(storeId == address.id){
				storeArray.push(address);
			}
		});
	}
});

function askForLeavingThePage() {
	window.onbeforeunload = function (evt) {
		if(changeData) {
			if(check) {
				check = false;
			} else {
				var message = "оапроапр";
				if (typeof evt == undefined) {
					evt = window.event;
				}
				if (evt) {
					evt.returnValue = message;
				}
				return message;
			}
		}
	}
}
var check = false;
function clickOnCloseBtn() {
	function hideWindow() {
		addCashbackWindow.hide();
		quickAddCashBack.hide();
		quickAddPerk.hide();
		detailsWindow.find('.promotion-list, .add-part').css('display', 'block');
		detailsWindow.find('.cashback-part, .perk-part').css('display', 'flex');
		storeArray = [];
		addresses.find('.adress-list').empty();
	}
	function Check() {
		if(changeData) {
			if(confirm('Do you realy whant to leave this page? Your data can be lost!')){
				hideWindow();
				check = true;
			} else {
				check = false;
			}
		} else{
			hideWindow();
		}
	}
	addCashbackWindow.find('.cancel-btn').click(function() {
		Check();
	});
}


//Choose start-date
$(document).on('click', '.date-block input:radio', function() {
	var that = $(this);
	if(addCashbackWindow.attr('data-id')==="null") {
		storeArray.forEach(function(prom, i) {
			if(that.parent().parent().find("span").text() == 'When I publish it'){
				prom.startDate = todayDate;
			} else {
				prom.startDate = that.parent().parent().find('span').find('input').val();
			}
		});
	} else {
		if(that.parent().parent().find("span").text() == 'When I publish it'){
			updatePromotionObj.startDate = todayDate;
		} else {
			updatePromotionObj.startDate = that.parent().parent().find('span').find('input').val();
		}
	}
});



//Choose end-date
$(document).on('click', '.end-date-block input:radio', function() {
	var that = $(this);
	if(addCashbackWindow.attr('data-id')==="null") {
		storeArray.forEach(function(prom, i) {
			if(that.parent().parent().find('span').text() == 'When I delete it'){
				prom.endDate = todayDate;
			} else {
				prom.endDate = that.parent().parent().find('span').find('input').val();
			}
		});
	} else {
		if(that.parent().parent().find('span').text() == 'When I delete it'){
			updatePromotionObj.endDate = todayDate;
		} else {
			updatePromotionObj.endDate = that.parent().parent().find('span').find('input').val();
		}
	}
});

$('.date-wrap input[type="date"]').on('change', function(){
	var that = this;
	if(addCashbackWindow.attr('data-id')==="null") {
		storeArray.forEach(function(prom, i) {
			if(that.parentElement.parentElement.className === 'date-block'){
				prom.startDate = that.value;	
			} else if(that.parentElement.parentElement.className === 'end-date-block'){
				prom.endDate = that.value;	
			}
		});
	} else {
		if(that.parentElement.parentElement.className === 'date-block'){
			updatePromotionObj.startDate = that.value;	
		} else if(that.parentElement.parentElement.className === 'end-date-block'){
			updatePromotionObj.endDate = that.value;	
		}
	}
})


//Choose max quantity for perk
$(document).on('click', '.quantity-wrap', function() {
	var that = $(this);
	if(addCashbackWindow.attr('data-id')==="null") {
		storeArray.forEach(function(prom, i) {
			if(that.find("span").text().trim() == 'No Max') {
				prom.amount = 'No max';
			} else {
				prom.amount = that.find('span').find('select').val();
			}
		});
	} else {
		if(that.find("span").text().trim() == 'No Max') {
			updatePromotionObj.amount = 'No max';
		} else {
			updatePromotionObj.amount = that.find('span').find('select').val();
		}
	}
});

//max-quantity
addCashbackWindow.find('.select-max-quant').on('change', function() {
	var that = $(this);
	if(addCashbackWindow.attr('data-id')==="null") {
		storeArray.forEach(function(prom, i) {
			prom.amount = that.val();
		});
	} else {
		updatePromotionObj.amount = that.val();
	}
	
});

function makeInputRed(input) {
	$(input).css('border', '1px solid red');
}

//Send obj to create new promotion
function savePromFullModeAndUpdate() {
	var addPart = detailsWindow.find('.add-part');
	$(document).on('click', '.new-buttons .save-btn', function() {
		var cashBackProcent = $('.cashback-part-add .cashback-procent input');
		cashBackProcent.css('border', '1px solid grey');
		var valOfProcent = cashBackProcent.val().split("");
		function sendUpdateObj(updatePromotionObj) {
			api.post('promotion/update', JSON.stringify(updatePromotionObj), function(response) {
				if(response && response.success) {
					console.log(response);
				} else {
					var promId = addCashbackWindow.attr('data-id');
					var element = $(templatePromotions(response));
					rootContainer.find('.detail-block').each(function(i, prom) {
						if($(prom).find('.act-btn').attr('data-id') === promId){
							$(prom).remove();
						}
					});
					rootContainer.append(element);
					styleStatus(response, element);
					calcAmout(response, element);
					quickAddCashBack.hide();
					quickAddPerk.hide();
					addCashbackWindow.hide();
					addPart.find('.cashback-part').show();
					addPart.find('.perk-part').show();
					addPart.show();
					rootContainer.show();
				}
			});
		}
		function toCreatePromotion(promotion) {
			console.log(promotion);
			api.post('promotion/add', JSON.stringify(promotion), function(response) {
				if(response && response.success) {
					console.log('ERROR');
				} else {
					var element = $(templatePromotions(response));
					element.attr("data-item",JSON.stringify(response));
					calcScoreOfPromotion(response);				
					storeArray = [];
					rootContainer.append(element);
					styleStatus(response, element);
					calcAmout(response, element);
					quickAddCashBack.hide();
					quickAddPerk.hide();
					addCashbackWindow.hide();
					addPart.find('.cashback-part').show();
					addPart.find('.perk-part').show();
					addPart.show();
					rootContainer.show();
				}
			});
		}
		if(addCashbackWindow.attr('data-id')==="null") {
			storeArray.forEach(function(promotion) {
				if(addCashbackWindow.attr('data-type') === 'cashback'){
					promotion.cash_back_percentage = cashBackProcent.val();
					if(cashBackProcent.val() == 0 || cashBackProcent.val() == "") {
						makeInputRed(cashBackProcent);
					} else if (valOfProcent.length >= 3 && Number(valOfProcent.join("")) > 100) {
						makeInputRed(cashBackProcent);
					} else {
						toCreatePromotion(promotion);
					}
				} else if (addCashbackWindow.attr('data-type') === 'perk') {
					delete promotion.cash_back_percentage;
					promotion.name = 'PERK';
					toCreatePromotion(promotion);
				}
			});
		} else {
			if(addCashbackWindow.attr('data-type') === 'cashback') {
				if(cashBackProcent.val() == 0 || cashBackProcent.val() == "") {
					makeInputRed(cashBackProcent);
				} else {
					console.log(updatePromotionObj);
					sendUpdateObj(updatePromotionObj);
				}
			} else {
				console.log(updatePromotionObj);
				sendUpdateObj(updatePromotionObj);
			}
		};
	});
}


//Quick add new cash back
function quickAddPromotionCashback() {
	var saveBtnForCashback = $('.cashback-part-prew .save-btn')
	saveBtnForCashback.on('click', function() {
		var procentInput = detailsWindow.find('.cashback-part-prew').find('input');
		procentInput.css('border', '1px solid grey');
		var valOfProcent = procentInput.val().split("");
		var toSendObj = {
			'userId': i_user_id,
			'storeId': 4,
			'promotionType': 'cashback',
			'startDate': todayDate,
			'endDate': todayDate,
			'amount': 0,
			'name':'Cash back',
			'description': '',
			'endScore': 2000000,
			'startScore': +score
		};
		console.log(toSendObj);
		if(procentInput.val() == 0 || procentInput.val() == "") {
			makeInputRed(procentInput);
		} else if (valOfProcent.length >= 3 && Number(valOfProcent.join("")) > 100) {
			makeInputRed(procentInput);
		} else {
			toSendObj.cash_back_percentage = procentInput.val();
			api.post('promotion/add', JSON.stringify(toSendObj), function(response) {
				if(response && response.success) {
					console.log('ERROR');
				} else {
					calcScoreOfPromotion(response);
					var element = $(templatePromotions(response));
					element.attr("data-item",JSON.stringify(response));
					calcAmout(response, element);
					procentInput.val('');
					quickAddCashBack.hide();
					quickAddCashBack.parent().find('.cashback-part').show();
					storeArray = [];
					rootContainer.append(element);
					styleStatus(response, element);
				}
			});
		}
	});
}

//Quick add new perkф
function quickAddPromotionPerk() {
	var saveBtnForPerk = $('.perk-part-prew .save-btn');
	saveBtnForPerk.on('click', function() {
		var nameInput = $('.perk-settings input');
		var descrTextarea = $('.perk-settings textarea');
		nameInput.css('border', '1px solid grey');
		descrTextarea.css('border', '1px solid grey');
		// var regExp = /<||>||\//gi;
		// var findSpecialSymbols = nameInput.val().split("");
		var toSendObj = {
			'userId': i_user_id,
			'storeId': 4,
			'promotionType': 'perk',
			'startDate': todayDate,
			'endDate': todayDate,
			'amount': 0,
			'endScore': 2000000,
			'startScore': +score,
			'name': nameInput.val(),
			'description': descrTextarea.val()
		};
		if(nameInput.val() == '' || descrTextarea.val() == '') {
			if(nameInput.val() == '') {
				makeInputRed(nameInput);
				if(descrTextarea.val() == ''){
					makeInputRed(descrTextarea);
				}
			} else {
				makeInputRed(descrTextarea);
			}
		} else if(nameInput.val().length > 100 || descrTextarea.val().length > 500) {
			alert('Title or description is too long');
		} else if(nameInput.val().indexOf("<") != -1 || nameInput.val().indexOf(">") != -1 || nameInput.val().indexOf("/") != -1) {
			alert('There are forbidden symbols');
		} else if(descrTextarea.val().indexOf("<") != -1 || descrTextarea.val().indexOf(">") != -1 || descrTextarea.val().indexOf("/") != -1) {
			alert('There are forbidden symbols');
		} else {
			api.post('promotion/add', JSON.stringify(toSendObj), function(response) {
				if(response && response.success) {
					console.log('ERROR');
				} else {
					calcScoreOfPromotion(response);
					var element = $(templatePromotions(response));
					element.attr("data-item",JSON.stringify(response));
					calcAmout(response, element);
					$(nameInput).val('');
					$(descrTextarea).val('');
					quickAddPerk.hide();
					quickAddPerk.parent().find('.perk-part').show();
					storeArray = [];
					rootContainer.append(element);
					styleStatus(response, element);
				}
			});
		}
	});
}
askForLeavingThePage();
clickOnCloseBtn();
savePromFullModeAndUpdate();
quickAddPromotionPerk();
quickAddPromotionCashback();
});

