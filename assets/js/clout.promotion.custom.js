	$(document).ready(function() {
		var viewScore = $('.view-score');
		var detailsWindow = $('.details-window');
		var statusBtn = $('.pause');
		var rootContainer = $('.promotion-list');
		var categoryList = $('.category-list');
		var levelList = $('.level-container');
		var allCategoryList = $('.categories');
		var arrayCategories;
		var subCategoriesWrap = $('.sub-categories-wrap');
		var competitorsList = $('.competitors');
		var arrayCompetitors;
		var checkedCategory = [];
		var competitorsIds = [];
		var locationWrap = $('.location-wrap');
		var addCashbackWindow = $('.add-cashback');
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
		var changeData = false;
		var date = new Date();
		var todayDate = date.getFullYear().toString() +'-'+ (date.getMonth()+1).toString() +'-'+ date.getDate().toString();
		var cashBackProcent = 0;
		var levelIdClick;
		var promotionId;
		var updatePromotionObj = {
			"userId": i_user_id,
			"endScore": 200,
			"startScore": 100
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
		}

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
			var perkBgImg = 'url(/assets/images/perk-bg.png)';
			var cashbackBgImg = 'url(/assets/images/detail-rang-lightgreen.png)';
			var sliceDate = -9;
			var promSettings = JSON.parse(that.closest('.detail-block').attr('data-item'));
			setPropToDefault();
			detailsWindow.children().hide();
			addCashbackWindow.show().attr('data-id', promSettings.id);
			promotionId = addCashbackWindow.attr('data-id');
			updatePromotionObj.id = +promotionId;
			updatePromotionObj.amount = promSettings.amount;
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

		function proccesData(){
			var current = null;
			var cancelBtn = addCashbackWindow.find('.cancel-btn');
			function openModal(item){
				var link = item.find('a');
				cancelBtn.click();
				levelIdClick = item.data('id');
				var sendObj = {
					'userId': i_user_id,
					'storeOwnerId': 4,
					'levelId': item.data('id'),
					'curDate': currentDate()
				};
				$('.noRes').hide();
				detailsWindow.slideToggle(300);
				item.css('background-color', 'transparent');
				link.css({'background-color': 'transparent', 'border-color': '#666666', 'border-bottom-color': '#fff', 'height': '31px', 'color': '#000'});
				rootContainer.empty();
				api.get('promotion/custom', sendObj, function(response) {
					if(response != []) {
						response.forEach(function(val, i){
							if(val.custom_category_id!=null || val.custom_category_id!=0){
								var element = $(templatePromotions(val));
								element.attr("data-item",JSON.stringify(val));
								styleStatus(val, element)		
								if (val.amount === 0) {
									element.find('.part-of-descr').css('display', 'none');
								}
								rootContainer.append(element);
							}
						});
					} else {
						$('.noRes').show();
					}
				}, function() {
					$('.add-part').css('padding-top', '30px');
					$('.load-promotion-sircle').css('display', 'block');
				}, function() {
					$('.load-promotion-sircle').css('display', 'none');
					$('.add-part').css('padding-top', '0px');
				});
			}

			function hideModal(item,current,action){
				detailsWindow.slideToggle(300,function(){
					var link = current.find('a');
					current.css('background-color', '#666666');
					link.css({'background-color': '#666666', 'border-color': 'transparent', 'border-bottom-color': 'transparent', 'height': '26px', 'color': '#fff'});
					if(action) {
						action(item);
					}
				});
			}

			function proccesClick(e){
				var that = $(this);
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
			$('.level-container').on('click', '.view-score', proccesClick);
		}

//All that consists in this part is about loading promotions and sending it's status to server
function templatePromotions(val) {
	if(val.promotion_type == 'cashback'){
		var procentIcon = ''+ val.cash_back_percentage +' %'
		$('.detail-block').find('.detail-img').text();
	}
	return '<div data-owner-type="' + val.owner_type + '" data-is-boosted="' + val.is_boosted + '" data-type="' + val.promotion_type + '" data-score="' + val.score + '" class="detail-block">' +
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

function findScore(id, typeScore) {
	var target = $('#'+id).find(typeScore);
	target.text(parseInt(target.text())+1);
};

function ifPerk(item, element) {
	var perkBgImg = 'url(/assets/images/perk-bg.png)';
	if (item.promotion_type === 'perk') {
		element.find('.detail-img').css('background-image', perkBgImg);
		element.find('.detail-img p').text('PERK');
	}
}

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


$(document).on('click', '.category-name-wrap > .squaredOne label', function(){
	var thisId = $(this).parent().parent().find('span').data('id');
	if(checkedCategory.indexOf(thisId) > -1){
		checkedCategory.splice(checkedCategory.indexOf(thisId), 1)
	} else {
		checkedCategory.push(thisId);
	}
});

//Function to change status of promotions
$(document).on('click', '.act-btn', function(){
	var that = $(this);
	var status = $('.status');
	var dataObj = {
		"userId":i_user_id,
		"promotionId": $(that).attr('data-id'), 
		"newStatusAction": $(that).text().toLowerCase()
	};
	api.post('promotion/status', JSON.stringify(dataObj), function(response){
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
	}
	);
});
// End of section with promotions

//Part that consists of loading categories and levels

var categoryPopup = $('.category');
$('.add-category a').click(function() {

	if(categoryPopup.css('display') === 'none') {
		categoryPopup.css('display', 'block');
	} else {
		categoryPopup.css('display', 'none');
	}
});

function allCategories(category) {
	var subLength;
	if(category.subcategories === undefined) {
		subLength = 0;
	} else if (category.subcategories.length > 0){
		subLength = category.subcategories.length;
	}
	return '<li>'+
	'<div class="category-name-wrap">'+
	'<div class="squaredOne">'+
	'<input type="checkbox" id="'+ category.id +'" name="'+ category.name +'" />'+
	'<label for="'+ category.id +'"></label>'+
	'</div>'+
	'<span class="category-name" data-id="'+ category.id +'">'+ category.name +'</span>'+
	'</div>'+
	'<div class="sub-category-length-wrap">'+
	'<span class="sub-category-length">('+ subLength +')</span>'+
	'<button class="category-arrow"></button>'+
	'</div>'+
	'</li>'
}

function subCategories(sub_category) {
	return '<div class="sub-category-block" data-category-id="'+ sub_category._category_id +'">'+
	'<div class="squaredOne">'+
	'<input type="checkbox" id="'+ sub_category.id +01 +'" name="'+ sub_category.name +'" />'+
	'<label for="'+ sub_category.id +01 +'"></label>'+
	'</div>'+
	'<span class="sub-category-name" data-id="'+ sub_category.id +'">'+ sub_category.name +'</span>'+
	'</div>'
}

var categoryId;

$('.main-categories').on('click', '.category-arrow', function() {
	var that = $(this);
	categoryId = that.parent().parent().find($('.category-name')).attr('data-id');;
	subCategoriesWrap.empty();
	arrayCategories.forEach(function(category, i) {
		if(category.id == categoryId){
			category.subcategories.forEach(function(sub_cat, i) {
				subCategoriesWrap.append($(subCategories(sub_cat)));
				if(category.checked.indexOf(sub_cat.id) > -1){
					$($('.sub-categories-wrap .sub-category-block')[$('.sub-categories-wrap .sub-category-block').length-1]).find('label').addClass('checked');
				}
			});
		}
	});
});

//Get all categories
api.get('search/categories_all',{'userId':i_user_id, 'storeOwnerId':4},function(categories){
	arrayCategories = categories;
	categories.forEach(function(val, i){
		allCategoryList.append($(allCategories(val)));
		val.checked = [];
		val.names = [];
	});
}, function() {
	$('.load-sircle').css('display', 'block');
}, function() {
	$('.load-sircle').css('display', 'none');
	$('.score-content, .score-menu').css('display', 'block');
}
);

function competitorsTemplate(competitors) {
	return '<li>'+
	'<div class="category-name-wrap">'+
	'<div class="squaredOne">'+
	'<input type="checkbox" id="competitors" name="competitors" />'+
	'<label for="competitors"></label>'+
	'</div>'+
	'<span class="category-name">Competitors</span>'+
	'</div>'+
	'<div class="sub-category-length-wrap">'+
	'<span class="sub-category-length">('+ competitors.length +')</span>'+
	'<button class="competitor-arrow"></button>'+
	'</div>'+
	'</li>'
}

api.get('search/competitors',{'storeId':4},function(competitors){
	arrayCompetitors = competitors;
	competitorsList.append($(competitorsTemplate(competitors)));
});

function competitors(competitor) {
	return '<div class="sub-category-block">'+
	'<div class="squaredOne">'+
	'<input type="checkbox" value="None" id="'+ competitor.id+25 +'" name="'+ competitor.competitor_name +'" />'+
	'<label for="'+ competitor.id+25 +'"></label>'+
	'</div>'+
	'<span class="sub-category-name" data-id="'+ competitor.id +'" data-competitor-id="'+ competitor.competitor_id +'">'+ competitor.competitor_name +'</span>'+
	'</div>'
}

$('.main-categories').on('click', '.competitor-arrow', function() {
	subCategoriesWrap.empty();
	arrayCompetitors.forEach(function(competitor, i) {
		subCategoriesWrap.append($(competitors(competitor)));
	});
});


function categoryTemplate(val) {
	return '<div class="category-block" title="'+val.category_label+'" data-id="'+ val.id +'">'+ val.category_label +'<button class="delete-category">x</button></div>'
}

function subCategoryTemplate(val) {
	return '<div class="category-block sub-category" title="'+val.category_label+'" data-id="'+ val.id +'"><span>└</span>  '+ val.category_label +'<button class="delete-category">x</button></div>'
}

function levelTemplate(level) {
	var builder='';
	level.values.forEach(function(val, i) {
		builder += '<div class="level-block" data-id="'+ val.id +'" data-category-id="'+ val.category_id +'"><span>≥$ <input type="text" class="value" placeholder="'+ val.amount +'"></span></div>';
	});
	return '<div class="level-wrap">'+
	'<div class="level-block" title="'+level.name+'"><input class="level-title" title="rename" placeholder="'+ level.name +'"><button class="delete-level">x</button></div>'+
	'<div class="value-wrap">'+
	builder+
	'</div>'+
	'<div class="level-block view-score" data-id="'+ level.id +'"><a href="#">+/View</a></div>'+
	'<div class="clearfix"></div>'+
	'</div>'	
}

function loadAllCategoriesAndLvl() {
	api.get('promotion/get_categories',{'userId':i_user_id, 'storeOwnerId':4},function(result){
		categoryList.empty();
		levelList.empty();
		Object.keys(result.categories).forEach(function(val, i){
			var oneCategoryObj = result.categories[val];
			categoryList.append($(categoryTemplate(oneCategoryObj)));
			if(oneCategoryObj.sub_categories && oneCategoryObj.sub_categories.length > 0) {
				oneCategoryObj.sub_categories.forEach(function(sub_cat, i) {
					categoryList.append($(subCategoryTemplate(sub_cat)));
				});
			}
		});

		result.levels.forEach(function(level, i){
			levelList.append($(levelTemplate(level)));
		})
	}, function() {
		$('.main-content').css('display', 'none');
		$('.load-sircle').css('display', 'block');
	}, function() {
		$('.load-sircle').css('display', 'none');
		$('.main-content').css('display', 'block');
	});
}
loadAllCategoriesAndLvl();

//Function for adding new level
$('.add-new-level').keypress(function(event) {
	var that = $(this);
	var levelName = that.val();
	var levelObj = {
		"userId":i_user_id,
		"storeOwnerId": 4,
		"levelId":5,
		"name": levelName
	};
	if(event.key === 'Enter') {
		api.post('promotion/add_level', JSON.stringify(levelObj), function(response) {
			levelList.append($(levelTemplate(response[0])).fadeIn(300));
		}, function() {
			$('.add-new-level').val('');
			that.attr("placeholder", "Please wait...");
		}, function() {
			that.attr("placeholder", "Add custom level");
		});
	}
});

//Function for updateing value of level's values
$('.level-container').on('keypress', '.value', function(event) {
	var that = $(this);
	var valueObj = {
		"userId":i_user_id,
		"storeOwnerId": 4,
		"id": +that.parent().parent().attr('data-id'),
		"value": +that.val()
	};
	if(event.key === 'Enter') {
		api.post('promotion/change_value', JSON.stringify(valueObj), function(response) {
			that.attr('placeholder', that.val()).val("");
		});
	}
});

//Function for renameing level
$(document).on('keypress', '.level-title', function(event) {
	var that = $(this);
	if(event.key === 'Enter'){
		that.focusout();
		var valueObj = {
			"userId":i_user_id,
			"id": +that.parent().parent().find('.view-score').attr('data-id'),
			"name": that.val()
		};
		console.log(valueObj);
		api.post('promotion/change_level_name', JSON.stringify(valueObj), function(response) {
			alert('success');
		});
	}
});

//This if for deleting levels
$('.level-container').on('click', '.delete-level', function() {
	var that = $(this);
	var deleteBlock = that.parent().parent();
	var id = +deleteBlock.find('.view-score').attr('data-id');
	var deleteObj = {
		"userId":i_user_id,
		"storeOwnerId": 4,
		"id": id
	};
	api.post('promotion/delete_level', JSON.stringify(deleteObj), function(response) {
		if(response.status) {
			console.log('ERROR');
		} else {
			deleteBlock.animate({'margin-top': '-143px', 'opacity': '0'}, 300, function(){
				deleteBlock.css('display', 'none');
			});
		}
	});
});

//This for deleting category
$('.category-list').on('click', '.delete-category', function() {
	var that = $(this);
	var parentBlock = that.parent();
	var id = +parentBlock.attr('data-id');
	var deleteObj = {
		"userId":i_user_id	,
		"storeOwnerId": 4,
		"id": id
	};
	api.post('promotion/delete_category', JSON.stringify(deleteObj), function(response) {
		parentBlock.animate({'margin-left': '-190px', 'opacity': '0'}, 300, function(){
			parentBlock.css('display', 'none');
		});
		$('.level-block').each(function(i, item){	
			var that = $(item);
			if(that.attr('data-category-id') == id) {
				that.animate({'margin-right': '-120px', 'opacity': '0'}, 300, function(){
					that.css('display', 'none');
				});
			}
		});
	});
});
//End of part with loading categories and levels

proccesData();

$('.addCategory').click(function() {
	var ids = '';
	arrayCategories.forEach(function(category, index){
		if(category.checked.length > 0){
			var thisId = category.id;
			category.checked.forEach(function(id, index){
				ids += thisId + '_' + id + ',';
			})
		}
	})
	ids += checkedCategory.toString();
	var request = {
		"userId": i_user_id,
		"storeOwnerId": 4,
		"categoryIds": ids,
		"categoryType": "category"
	}
	if(ids != ''){
		api.post('promotion/add_category', JSON.stringify(request), function(response){
			// arrayCategories.forEach(function(category, index){
			// 	if(category.checked.length > 0){
			// 		var id = category.id;
			// 		var target = {
			// 			id: id,
			// 			category_label: category.name
			// 		}
			// 		categoryList.append(categoryTemplate(target));
			// 		category.checked.forEach(function(id, i){
			// 			var target = {};
			// 			category.names.forEach(function(name, i){
			// 				var _this = name.split('_');
			// 				if(_this[0] == id)
			// 					target.category_label = _this[1];
			// 				target.id = _this[0];
			// 			})

			// 			categoryList.append(subCategoryTemplate(target));
			// 		})
			// 	} 
			// });
			// checkedCategory.forEach(function(id, i){
			// 	var target = {
			// 		id: id,
			// 		category_label: arrayCategories.filter(function(category){
			// 			return category.id == id
			// 		})[0].name
			// 	};		
			// });
			if(response && response.success){
				console.log('ERROR');
			} else {
				loadAllCategoriesAndLvl();
			}

		}, function() {
			$('.main-content').css('display', 'none');
			$('.load-sircle').css('display', 'block');
		}, function() {
			$('.load-sircle').css('display', 'none');
			$('.main-content').css('display', 'block');
		});
	}
	competitors_req = {
		"userId": i_user_id,
		"storeOwnerId": 4,
		"categoryIds": competitorsIds.toString(),
		"categoryType": "competitor"
	}
	if(competitorsIds.toString() != ''){
		api.post('promotion/add_category', JSON.stringify(competitors_req), function(responce){
			// competitorsIds.forEach(function(competitor, index){
			// 	var element = {
			// 		id: competitor,
			// 		category_label: arrayCompetitors.filter(function(item){
			// 			return item.id == competitor;
			// 		})[0].competitor_name
			// 	}
			// 	categoryList.append(categoryTemplate(element));
			// });
			if(response && response.success){
				console.log('ERROR');
			} else {
				loadAllCategoriesAndLvl();
			}
		}, function() {
			$('.main-content').css('display', 'none');
			$('.load-sircle').css('display', 'block');
		}, function() {
			$('.load-sircle').css('display', 'none');
			$('.main-content').css('display', 'block');
		});
	}
});

$(document).on('click', '.squaredOne input[value="None"]', function(){
	var id = $(this).parent().next().data('id');
	if(competitorsIds.indexOf(id) > -1){
		competitorsIds.splice(competitorsIds.indexOf(id),1)
	} else {
		competitorsIds.push(id);
	}
})

$(document).on('click', '.sub-category-block .squaredOne input:not([value="None"])', function(){
	var _this = $(this).parent();
	var currentCategoryId = _this.parent().data('category-id');
	var currentCategory = arrayCategories.filter(function(item){
		return item.id == currentCategoryId
	})[0];
	var currentBoxId = _this.next().data('id');
	if(currentCategory.checked.indexOf(currentBoxId) > -1){
		currentCategory.checked.splice(currentCategory.checked.indexOf(currentBoxId),1);
		currentCategory.names.splice(currentCategory.names.indexOf(currentBoxId + '_' + _this.find('input').attr('name')),1);
	} else {
		currentCategory.checked.push(currentBoxId);
		currentCategory.names.push(currentBoxId + '_' + _this.find('input').attr('name'));
	}
	_this.find('label').toggleClass('checked');
	event.stopPropagation();
	event.preventDefault();
	return false;
});

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
		api.get('search/stores_by_name', {"name": _this.value}, function(res){
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
				if(res.length === 0) {
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
			address.storeId = 4;
			address.endScore = 2000000;
			address.startScore = 100;
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
			if(confirm('Your data can be ignored and not save')){
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
				prom.endDate = that.parent().find('span').find('input').val();
			}
		});
	} else {
		if(that.parent().parent().find('span').text() == 'When I delete it'){
			updatePromotionObj.endDate = todayDate;
		} else {
			updatePromotionObj.endDate = that.parent().find('span').find('input').val();
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
				prom.amount = 'No Max';
			} else {
				prom.amount = that.find('span').find('select').val();
			}
		});
	} else {
		if(that.find("span").text().trim() == 'No Max') {
			updatePromotionObj.amount = 'No Max';
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
			api.post('promotion/add', JSON.stringify(promotion), function(response) {
				if(response && response.success) {
					console.log('ERROR');
				} else {
					storeArray = [];
					var element = $(templatePromotions(response));
					element.attr("data-item",JSON.stringify(response));
					addCashbackWindow.hide();
					quickAddCashBack.hide();
					quickAddPerk.hide();
					addPart.show();
					rootContainer.show();
					addPart.find('.cashback-part').show();
					addPart.find('.perk-part').show();
					rootContainer.append(element);
					styleStatus(response, element);
				}
			});
		}
		if(addCashbackWindow.attr('data-id')==="null") {
			storeArray.forEach(function(promotion) {
				promotion.categoryId = levelIdClick;
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
					sendUpdateObj(updatePromotionObj);
				}
			} else {
				sendUpdateObj(updatePromotionObj);
			}
			
		}
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
			'startScore': 100
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
					var element = $(templatePromotions(response));
					element.attr("data-item",JSON.stringify(response));
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

//Quick add new perk
function quickAddPromotionPerk() {
	var saveBtnForPerk = $('.perk-part-prew .save-btn');
	saveBtnForPerk.on('click', function() {
		var nameInput = $('.perk-settings input');
		var descrTextarea = $('.perk-settings textarea');
		nameInput.css('border', '1px solid grey');
		descrTextarea.css('border', '1px solid grey');
		var toSendObj = {
			'userId': i_user_id,
			'storeId': 4,
			'promotionType': 'perk',
			'startDate': todayDate,
			'endDate': todayDate,
			'amount': 0,
			'endScore': 2000000,
			'startScore': 100,
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
		} else {
			api.post('promotion/add', JSON.stringify(toSendObj), function(response) {
				if(response && response.success) {
					console.log('ERROR');
				} else {
					var element = $(templatePromotions(response));
					element.attr("data-item",JSON.stringify(response));
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
quickAddPromotionCashback();
quickAddPromotionPerk();
});