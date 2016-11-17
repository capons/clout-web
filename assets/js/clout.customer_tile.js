$(document).ready(function(){

    var filterBy = $('#filterBy');
    var filterBlock = $('#filterBy .country-wrap');
    var tileGridMainBlock = $('#tileGrid .mainBlock');
    tileGridMainBlock.empty();

    $('#viewing_group').show();

    function startFunction(){
        // Filter By Store Location(s) dropdown / For Left Menu
        $('#filterBy .tag').click(function openFilterByDropDown(e) {
            $('#filterBy .menu').toggle();
        });

        // For Right Menu
        $('#viewBy .tag').click(function openViewByDropDown(e) {
            $('#viewBy .menu').toggle();
        });
    }

    function noResult(){
        $('.noRes').show();
        $('#static-columns').hide();
        $('#sortable-overlay').hide();
    }


    function drawCountry(country){
        var varName = country.country_name.replace(/ /g, '');
        filterBlock.append(
            '<div class="menu-row country-row">'+
            '<span class="bold-menu-text">'+country.country_name+':</span>'+
            '<input name="filterBy-'+varName+'" type="radio" id="all-'+varName+'" class="all-country" data-code="'+country.country_code+'">'+
            '<label for="all-'+varName+'">All</label>'+
            '<input name="filterBy-'+varName+'" type="radio" id="choose-'+varName+'" class="choose-country">'+
            '<label for="choose-'+varName+'" data-code="'+country.country_code+'">Choose</label>'+
            '<div class="state-list"></div>'+
            '</div>'
        );
    }
    function drawState(state){
        var varName = state.state_name.replace(/ /g, '');
        var stateName;
        if(state.state_name.length>7){stateName = state.state_name.slice(0,6)+'... '}else{stateName = state.state_name}
        return '<div class="menu-row state-row">'+
            '<span class="spacer"></span>'+
            '<span style="font-weight: 400;">'+stateName+':</span>'+
            '<input name="filterBy-'+varName+'" type="radio" id="all-'+varName+'" class="all-state" data-id="'+state.state_id+'">'+
            '<label for="all-'+varName+'">All</label>'+
            '<input name="filterBy-'+varName+'" type="radio" id="choose-'+varName+'" class="choose-state">'+
            '<label for="choose-'+varName+'" data-id="'+state.state_id+'">Choose</label>'+
            '<div class="store-list"></div>'+
            '</div>'
    }
    function drawStore(store){
        var varName = store.address.replace(/ /g, '');
        return '<div class="menu-columns">'+
            '<input type="checkbox" class="filled-in" id="choose-'+varName+'">'+
            '<label for="choose-'+varName+'" data-address="'+store.address+'">Store : '+store.address+'</label>'+
            '</div>'
    }

    function drawFilterBlock(){
        function setCheckCountryToFalse() {
            filterBlock.find('.all-country').each(function(i, item) {
                if($(item).prop('checked') == true){
                    $(item).prop('checked', false);
                }
            });
        }
        function setCheckStateToFalse() {
            filterBlock.find('.all-state').each(function(i, item) {
                if($(item).prop('checked') == true){
                    $(item).prop('checked', false);
                }
            });
        }
        var toFilterObj = {
            "stores":"",
            "countryCode":"",
            "stateId":"",
            "storeAddress":""
        };
        var storeAddress = [];
        var countryCode = [];
        var stateId = [];

        $(document).on('click','.all-country+label',function(){
            var that = $(this);
            filterBlock.find('.state-list').empty();
            filterBlock.find('.choose-country').prop('checked', false);
            toFilterObj.stateId = '';
        });

        $(document).on('click','.all-state+label',function(){
            var that = $(this);
            filterBlock.find('.store-list').empty();
            filterBlock.find('.choose-state').prop('checked', false);
            toFilterObj.storeAddress = '';
        });

        $(document).on('click','#all-store+label',function(){
            var that = $(this);
            filterBy.find('.tag span').text('All');
            filterBlock.empty();
        });

        filterBy.find('#choose-store+label').click(function(){
            $('#all-store').prop('checked', false);
            filterBy.find('.tag span').text('Custom');
            if($('#choose-store').prop("checked")==false){
                $('#filterBy .menu .country-wrap').empty();
                api.get('customer/get_country',{},function(result){
                    console.log(result);
                    result.forEach(function(country, i) {
                        drawCountry(country);
                    });
                }, function() {
                    $('.load-sircle-small').css('display', 'block');
                }, function() {
                    $('.load-sircle-small').css('display', 'none');
                });
            }
        });

        $(document).on('click','.choose-country+label',function() {
            var that = $(this);
            storeAddress =[];
            countryCode = [];
            stateId = [];
            toFilterObj.countryCode = that.data('code');
            filterBy.find('.choose-country').prop('checked',false).parent().find('.state-list').empty();
            that.parent().find('.choose-country').prop('checked', true);
            var toSendObj = {
                "stores":"",
                "countryCode": that.data('code'),
                "stateId":"",
                "storeAddress":""
            };
            setCheckCountryToFalse();
            api.get('customer/get_state', toSendObj, function(response) {
                that.parent().find('.state-list').show();
                response.forEach(function(state) {
                    that.parent().find('.state-list').append(drawState(state));
                });
                console.log(response);
            }, function() {
                $('.load-sircle-small').css('display', 'block');
            }, function() {
                $('.load-sircle-small').css('display', 'none');
            });
        });

        $(document).on('click','.choose-state+label',function() {
            var that = $(this);
            storeAddress =[];
            stateId = [];
            toFilterObj.stateId = that.data('id');
            filterBy.find('.choose-state').prop('checked',false).parent().find('.store-list').hide().empty();
            that.parent().find('.choose-state').prop('checked', true);
            var toSendObj = {
                "stores":"",
                "countryCode": "",
                "stateId": that.data('id'),
                "storeAddress":""
            };
            setCheckStateToFalse();
            api.get('customer/get_address', toSendObj, function(response) {
                that.parent().find('.store-list').show();
                console.log(response);
                response.forEach(function(store) {
                    that.parent().find('.store-list').append(drawStore(store));
                });
            }, function() {
                $('.load-sircle-small').css('display', 'block');
            }, function() {
                $('.load-sircle-small').css('display', 'none');
            });
        });

        $(document).on('click','.filled-in+label',function() {
            var that = $(this);
            if(that.parent().find('.filled-in').prop('checked')===true) {
                storeAddress = storeAddress.filter(function(item) {
                    return item != that.data('address');
                });
                toFilterObj.storeAddress = storeAddress.toString();
            } else {
                storeAddress.push(that.data('address'));
                toFilterObj.storeAddress = storeAddress.toString();
            }
        });

        $('.startFilterBtn').click(function() {
            stateId= [];
            countryCode = [];
            if($('#all-store').prop('checked') == true) {
                toFilterObj.stores = 'all';
                toFilterObj.countryCode = '';
                toFilterObj.stateId = '';
            } else {
                toFilterObj.stores = 'choose';
                filterBlock.find('.all-country').each(function(i, item) {
                    if($(item).prop('checked') == true){
                        countryCode.push($(item).data('code'));
                        toFilterObj.countryCode = countryCode.toString();
                    }
                });
                filterBlock.find('.all-state').each(function(i, item) {
                    if($(item).prop('checked') == true){
                        stateId.push($(item).data('id'));
                        toFilterObj.stateId = stateId.toString()
                    }
                });
            }
            console.log(toFilterObj);
            api.post('customer/filter', JSON.stringify(toFilterObj),function(response) {
                if(response.length==0){
                    noResult();
                }
                else{
                    addBlocks(response);
                }
            }, function() {
                $('#filterBy .menu').toggle();
                $('.load-sircle').css('display', 'block');
            }, function() {
                $('.load-sircle').css('display', 'none');
            });
        });


    }

    function searchFunction(){
        $('#filter-input').bind('keypress', function(e)
        {
            if(e.keyCode==13)
            {
                console.log('dsfdsf');
                $('.searchBtn').click();
            }
        });

        $('.searchBtn').click(function(){
            api.get('customer/',{'searchData':$('#filter-input').val()},function(result){
                // console.log(result);
                if(result == null){
                    noResult();
                }
                else{
                    addBlocks(result);
                }
            }, function() {
                $('.load-sircle').css('display', 'block');
            }, function() {
                $('.load-sircle').css('display', 'none');
            });
        });
    }


    function workFilterRight(){
        $('#everyoneRadio+label').click(function(){
            filterTable($(this), {'everyone':'everyone'});
        });
        $('#myCustomersRadio+label').click(function(){
            filterTable($(this), {'myCustomer':'myCustomer'});
        });
        $('#hereNowRadio+label').click(function(){
            filterTable($(this), {'hereNow':'hereNow'});
        });
        $('#reservationsRadio+label').click(function(){
            filterTable($(this), {'reservation':'reservation'});
        });

        function filterTable(self, filterName){
            $('#viewBy .tag span').text(self.text());
            $('#viewBy .menu').hide();
            api.get('customer/',filterName,function(result){
                console.log(result);
                tileGridMainBlock.empty();
                if(result==null || result.length == 0){
                    noResult();
                }
                else{
                    addBlocks(result);
                }
            }, function() {
                $('.load-sircle').css('display', 'block');
            }, function() {
                $('.load-sircle').css('display', 'none');
            });
        }
    }
    function addBlocks(response){
        var cardBg,
            dateInfo,
            timeInfo,
            itemCountry,
            itemNetworkSize,
            itemGender,
            itemAge,
            itemCity,
            store_name,
            itemName,
            html_here_now = '';
        var promotional_spending_at_store_in_dollars = '-';
        var total_transactions_at_store = '-';
        var spending_at_store_in_dollars = '-';
        var itemScore = '';
        var img = 'User_no_photo.png';



        if(2>1){
            cardBg = 'reservationBg';
        } else if(3<1){
            cardBg = 'neutralBg';
        }else{
            cardBg = 'hereNowBg';
        }

        tileGridMainBlock.empty();

        function notNull(itemElement, newItem){
            if((itemElement == null || itemElement == undefined || itemElement == "") && itemElement!=0){
                return newItem;
            }
            else{
                return itemElement;
            }
        }
        function notNullText(itemElement, newItem){
            if(itemElement == null || itemElement == undefined || itemElement == ""){
                return newItem;
            }
            else{
                return itemElement;
            }
        }
        response.forEach(function(item, i, arr) {
            console.log(item);
            if (item.here_now) {
                html_here_now = '<div class="checkinAlert">Here Now</div>';
            }

            if(item.photo_url != null && item.photo_url != ""){
                img = item.photo_url;
            }
            else{
                img = 'User_no_photo.png';
            }

            if(item.activity != null && item.activity != ""){
                dateInfo = item.activity.slice(0, -9);
            }
            else{
                dateInfo = '-';
            }

            total_transactions_at_store = notNull(item.transactions, '-');
            timeInfo = notNull(item.time, '-');
            itemScore = notNull(item.score, '-');
            itemName = notNull(item.name, '-');
            itemCity = notNullText(item.city, '-');
            itemCountry = notNullText(item.country, '-');
            itemNetworkSize = notNull(item.network_size, '-');
            itemGender = notNull(item.gender, '-');
            itemAge = notNull(item.age, '-');
            store_name = notNull(item.store_name, '-');
            spending_at_store_in_dollars = notNull(item.in_store_spending, '-');
            promotional_spending_at_store_in_dollars = notNull(item.promo_spending, '-');


            tileGridMainBlock.append(
                '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 tile-column">' +
                '<div class="tile" style="background-image: url(../../assets/images/customer/'+img+'); background-position: top center; background-size: 200px; background-repeat: no-repeat">' +
                '<img class="corner" src="../../assets/images/customer/corner.png">' +
                '<div class="top '+cardBg+'" style="float: left">' +
                '<div class="resAlert"></div>' +
                '<h4 class="firstLine" style="font-size: 1em;">RESERVATIONS</h4>' +
                '<h4 class="secondLine" style="font-size: 1em;">'+dateInfo+' AT '+timeInfo+'</h4>' +
                '</div>' +
                '<div class="bottom reservationBg">' +
                html_here_now +
                '<div class="tile_Score"><span>'+itemScore+'</span></div>' +
                '<div class="promos">' +
                '<div class="promo one"><span>10-20%</span></div>' +
                '<div class="promo two"><span>Perk</span></div>' +
                '</div>' +
                '<h1>'+itemName+'</h1>' +
                '<h2>'+itemCity+','+itemCountry+'</h2>' +
                '<h3>Network Size: ' +
                itemNetworkSize + '<br>' +
                itemGender + ', ' +
                itemAge +
                '</h3>' +
                '<div class="storeActivity">' +
                '<div class="activityHeader">'+store_name+'</div>' +
                '<div class="activityDetails">' +
                '<div class="amount">'+spending_at_store_in_dollars+'</div>' +
                '<div class="identification"> STORE <br> SPENDING </div>' +
                '</div>' +
                '<div class="activityDetails">' +
                '<div class="amount">'+total_transactions_at_store+'</div>' +
                '<div class="identification">TOTAL <br>TRANSACTIONS</div>' +
                '</div>' +
                '<div class="activityDetails">' +
                '<div class="amount">'+promotional_spending_at_store_in_dollars+'</div>' +
                '<div class="identification">PROMO <br>SPENDING</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>');
        });
    }

    startFunction();
    drawFilterBlock();
    searchFunction();

    $('#viewBy').click(function(){
        workFilterRight();
    });
    api.get('customer',{}, function(response){
        //console.log('response true');
        console.log(response);
        //addBlocks(response);
        tileGridMainBlock.empty();
        if(response.length==0 || response == null){
            noResult();
        }
        else{
            addBlocks(response);
        }

    }, function() {
        $('.load-sircle').css('display', 'block');
    }, function() {
        $('.load-sircle').css('display', 'none');
        //$('.score-content, .score-menu').css('display', 'block');
    });
});