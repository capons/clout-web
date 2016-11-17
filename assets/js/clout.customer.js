
$(document).ready(function(){
    /*
    var oReq = new XMLHttpRequest(); //New request object
    oReq.onload = function() {
        console.log(this.responseText);
    };
    oReq.open("get", "http://dev-web/account/user_access_view", true);
    oReq.send();
    */
    var namePage = '';
    var mainListViewBlock = $('#list-view');
    var customerList = $('#customer-list');
    var storeList = $('#store .section-content');
    var customerDetailsList = $('#customer_details .section-content');
    var reservationsList = $('#reservations .section-content');
    var activityList = $('#activity .section-content');
    var filterBy = $('#filterBy');
    var filterBlock = $('#filterBy .country-wrap');
    var labelForChooseCountry = $('.choose-country+label');



    var filterBy = $('#filterBy');
    var filterBlock = $('#filterBy .country-wrap');
    var tileGridMainBlock = $('#tileGrid .mainBlock');
    tileGridMainBlock.empty();

    $('#viewing_group').show();

    var topCustomerList = '<div class="content-customer-column" style="flex: 3">' +
    '<div class="firstCol-content-column-header border-right">' +
    '<input type="checkbox" id="check-all-customers">' +
    '<label for="check-all-customers"></label>' +
    '</div>'+
    '</div>'+

    '<div class="content-customer-column" style="flex: 15">' +
    '<div class="firstCol-content-column-header" style="justify-content: flex-start; padding-left: 5px ">' +
    'Customer List' +
    '</div>'+
    '</div>'+

    '<div class="content-customer-column" style="flex: 1">'+
    '<div class="firstCol-content-column-header">'+
    '<img src="../../../assets/images/customer/exclaim.png" height="20" alt="">'+
    '</div>'+
    '</div>';

    if($('div').is('#list-view') == true){
        namePage = 'listView';
    }
    else{        
        namePage = 'tileView';
    }

    function topListAdd(text, nameParrent){
        var topStoreList =
        '<div class="content-column">'+
        '<div class="content-column-header ui-sortable-handle buttonToFilter">'+
        '<div class="flex">'+
        '<span>'+text+'</span>'+
        '<a class="header-hover">'+
        '<img src="../../../assets/images/customer/arrow_down.png">'+
        '</a>'+
        '</div>'+
        '</div>'+
        '</div>';
        nameParrent.append(topStoreList);
    }

    function left_people_block_show(responseNew){
        customerList.html('');
        customerList.append(topCustomerList);
        var img = 'User_no_photo.png';

        responseNew.forEach(function(item, i, arr) {
            $('#customer-list .content-customer-column:nth-child(1)').append(
                '<div class="content-column-data no-left-border">'+
                '<div class="clout-checkbox">'+
                '<input type="checkbox" value="None" id="user_id_'+i+'" name="check" class="customer-checkbox">'+
                '<label for="user_id_'+i+'"></label>'+
                '</div>'+
                '</div>');
            if(item.photo_url != null && item.photo_url != ""){
                img = item.photo_url;
            }
            else{
                img = 'User_no_photo.png';
            }
            if(2>1){
                var name = "-";
                if(item.name != null && item.name != undefined && item.name != '' && item.name != '0'){
                    name = item.name;
                }
                $('#customer-list .content-customer-column:nth-child(2)').append(
                    '<div class="content-column-data">'+
                    '<img class="customerImage" src="../../../assets/images/customer/'+img+'">'+
                    '<div class="customerName">'+name+'</div>'+
                    '</div>');
            } else{
                $('#customer-list .content-customer-column:nth-child(2)').append(
                    '<div class="content-column-data">'+
                    '<div class="customerNameNew">'+
                    '<div class="topText">Customer:</div>'+
                    '<div class="text">CT27823459670</div>'+
                    '</div>'+
                    '</div>');
            }
            if(item.upcoming!=null && item.last_checkins==null){
                $('#customer-list .content-customer-column:nth-child(3)').append(
                    '<div class="content-column-data user-alerts-data">'+
                    '<div class="blueAlert"></div>'+
                    '</div>');
            }
            else if(item.last_checkins!=null && item.upcoming==null){
                $('#customer-list .content-customer-column:nth-child(3)').append(
                    '<div class="content-column-data user-alerts-data">'+
                    '<div class="purpleAlert"></div>'+
                    '</div>');
            }
            else if(item.upcoming!=null && item.last_checkins!=null){
                $('#customer-list .content-customer-column:nth-child(3)').append(
                    '<div class="content-column-data user-alerts-data">'+
                    '<div class="blueAlert"></div>'+
                    '<div class="purpleAlert"></div>'+
                    '</div>');
            } else{
                $('#customer-list .content-customer-column:nth-child(3)').append(
                    '<div class="content-column-data user-alerts-data">'+
                    '</div>');
            }
        });

    }

    function startLeftFilter(){        
        // Filter By Store Location(s) dropdown / Far Left Menu
        $('#filterBy .tag').click(function openFilterByDropDown(e) {
            $('#filterBy .menu').toggleClass('flex-menu');
        });

        // Far Right Menu
        $('#viewBy .tag').click(function openViewByDropDown(e) {
            $('#viewBy .menu').toggleClass('flex-menu');
        });
    }


    function mainBlockAdd(adress, itemInfo){
        $(adress).append(
            '<div class="content-column-data">'+
            itemInfo +
            '</div>'
            );
    }

    function checkNull(adress, itemCheck, newInfo){

        if((itemCheck==null || itemCheck=='null%' || itemCheck=='null' || itemCheck==undefined || itemCheck=='undefined%' || itemCheck=='undefined' || itemCheck=='') && itemCheck != '0'){
            mainBlockAdd(adress, newInfo);
        }
        else{
            mainBlockAdd(adress, itemCheck);
        }
    }

    function store_show(responseNew){
        storeList.html('');
        var arrTopStoreList = ['SCORE','In-Store Spending','Competitor Spending','Category Spending','Related Spending','Overall Spending','Linked Accounts','Activity'];

        arrTopStoreList.forEach(function(item, i, arr){
            topListAdd(item, storeList);
        });

        function blockAddScoreCollor(info, className){
            if((info==null || info=='null%' || info==undefined || info=='undefined%' || info=='' ) && info != '0'){
                $('#store .section-content .content-column:nth-child(1)').append('<div class="content-column-data score '+className+'">-</div>');
            }
            else{
                $('#store .section-content .content-column:nth-child(1)').append(
                    '<div class="content-column-data score '+className+'">'+
                    info+
                    '</div>'
                    );
            }
        }

        responseNew.forEach(function(item, i, arr) {
            if(2>1){
                blockAddScoreCollor(item.score, 'greenScore');
            } else if(3<1){
                blockAddScoreCollor(item.score, 'purpleScore');
            }
            else{
                blockAddScoreCollor(item.score, 'blueScore');
            }
            checkNull('#store .section-content .content-column:nth-child(2)',item.in_store_spending+'%','-');
            checkNull('#store .section-content .content-column:nth-child(3)',item.competitor_spending+'%','-');
            checkNull('#store .section-content .content-column:nth-child(4)',item.category_spending+'%','-');
            checkNull('#store .section-content .content-column:nth-child(5)',item.related_spending+'%','-');
            checkNull('#store .section-content .content-column:nth-child(6)',item.overall_spending+'%', '-');
            checkNull('#store .section-content .content-column:nth-child(7)',item.linked_accounts+'%','-');
            checkNull('#store .section-content .content-column:nth-child(8)',item.activity,'-');
        });
    }

    function customer_details_show(responseNew){
        customerDetailsList.html('');
        var arrTopCustomerDetailsList = ['City','State','Zip','Country','Gender','Age','Custom Label','Notes','Priority','Network','Invites'];

        arrTopCustomerDetailsList.forEach(function(item, i, arr){
            topListAdd(item, customerDetailsList);
        });

        responseNew.forEach(function(item, i, arr){
            checkNull('#customer_details .section-content .content-column:nth-child(1)',item.city,'-');
            checkNull('#customer_details .section-content .content-column:nth-child(2)',item.state,'-');
            checkNull('#customer_details .section-content .content-column:nth-child(3)',item.zip,'-');
            checkNull('#customer_details .section-content .content-column:nth-child(4)',item.country,'-');
            // checkNull('#customer_details .section-content .content-column:nth-child(5)',item.gender,'-');

            if(item.gender == 'male'){
                mainBlockAdd('#customer_details .section-content .content-column:nth-child(5)', 'M');
            }
            else if(item.gender == 'female'){
                mainBlockAdd('#customer_details .section-content .content-column:nth-child(5)', 'F');
            }
            else if(item.gender == 'unknown'){
                mainBlockAdd('#customer_details .section-content .content-column:nth-child(5)', '?');
            }
            else{
                mainBlockAdd('#customer_details .section-content .content-column:nth-child(5)', '-');
            }

            checkNull('#customer_details .section-content .content-column:nth-child(6)',item.age,'-');
            checkNull('#customer_details .section-content .content-column:nth-child(7)', item.custom_label, '-');

            if(item.notes!=null){
                mainBlockAdd('#customer_details .section-content .content-column:nth-child(8)',item.notes);
            }
            else{
                $('#customer_details .section-content .content-column:nth-child(8)').append(
                    '<div class="content-column-data">'+
                    '<a>+ note</a>'+
                    '</div>'
                    );
            }

            // mainBlockAdd('#customer_details .section-content .content-column:nth-child(9)','');
            if(item.priority == 1){
                mainBlockAdd('#customer_details .section-content .content-column:nth-child(9)', 'High');
            }
            else if(item.priority == 2){
                mainBlockAdd('#customer_details .section-content .content-column:nth-child(9)', 'Medium');
            }
            else if(item.priority == 3){
                mainBlockAdd('#customer_details .section-content .content-column:nth-child(9)', 'Low');
            }
            else if(item.priority == 4){
                mainBlockAdd('#customer_details .section-content .content-column:nth-child(9)', 'The lowest');
            }
            else{
                mainBlockAdd('#customer_details .section-content .content-column:nth-child(9)', '-');
            }
            mainBlockAdd('#customer_details .section-content .content-column:nth-child(10)',item.network);
            mainBlockAdd('#customer_details .section-content .content-column:nth-child(11)',item.invites);
        });
    }



    function reservations_show(responseNew){
        reservationsList.empty();
        var arrTopReservationsList = ['Upcoming','Time','Type','Size','Status','Action!','Other Reservations?'];

        arrTopReservationsList.forEach(function(item, i, arr){
            topListAdd(item,reservationsList);
        });

        responseNew.forEach(function(item, i, arr){
            if(item.upcoming!=null){
                mainBlockAdd('#reservations .section-content .content-column:nth-child(1)',item.upcoming.slice(0,-9));
            }
            else{
                mainBlockAdd('#reservations .section-content .content-column:nth-child(1)','-');
            }
            // checkNull('#reservations .section-content .content-column:nth-child(1)',item.upcoming.slice(0,-9),'-');
            checkNull('#reservations .section-content .content-column:nth-child(2)', item.time,'-');
            checkNull('#reservations .section-content .content-column:nth-child(3)',item.type,'-');
            checkNull('#reservations .section-content .content-column:nth-child(4)',item.size,'-');
            if(item.status=='pending' || item.status=='approved' || item.status=='cancelled'){
                //mainBlockClassAdd('#customer_details .section-content .content-column:nth-child(5)', item.status, item.status);
                $('#reservations .section-content .content-column:nth-child(5)').append(
                    '<div class="content-column-data '+item.status+'">'+
                    item.status +
                    '</div>'
                    );
            }
            else{
                mainBlockAdd('#reservations .section-content .content-column:nth-child(5)','-');
            }
            // if(2<1){
            //     $('#reservations .section-content .content-column:nth-child(6)').append(
            //         '<div class="content-column-data checkbox-data">'+
            //         '<div class="clout-checkbox">'+
            //         '<input type="checkbox" value="None" id="action1" name="check" checked="">'+
            //         '<label for="action1">approve</label>'+
            //         '</div>'+
            //         '<div class="clout-checkbox">'+
            //         '<input type="checkbox" value="None" id="action2" name="check">'+
            //         '<label for="action2">deny</label>'+
            //         '</div>'+
            //         '</div>'
            //         );
            // }
            // else{
            //     mainBlockAdd('#reservations .section-content .content-column:nth-child(6)','-');
            // }
            checkNull('#reservations .section-content .content-column:nth-child(6)', item.action,'-');
            checkNull('#reservations .section-content .content-column:nth-child(7)', item.other_reservations,'-');
        });
    }


    function activity_show(responseNew){
        activityList.empty();
        var arrTopActivityList = ['Last Checkins','Past Checkins','In Network','Transactions','Reviews','Favorited'];


        arrTopActivityList.forEach(function(item, i, arr){
            topListAdd(item,activityList);
        });

        responseNew.forEach(function(item, i, arr){

            if(item.last_checkins != null){
                if(1>2){
                    $('#activity .section-content .content-column:nth-child(1)').append(
                        '<div class="content-column-data purpleBox">'+
                        'In Store Now!'+
                        '<br>'+
                        '3:35pm PST'+
                        '</div>'
                        );
                }
                else{
                    mainBlockAdd('#activity .section-content .content-column:nth-child(1)', item.last_checkins);
                }
            }
            else{
                mainBlockAdd('#activity .section-content .content-column:nth-child(1)','-');
            }
            checkNull('#activity .section-content .content-column:nth-child(2)', item.past_checkins, '-');

            if(item.network == 0){
                mainBlockAdd('#activity .section-content .content-column:nth-child(3)', 'No');
            }
            else if(item.network == 1){
                mainBlockAdd('#activity .section-content .content-column:nth-child(3)', 'Yes');
            }
            else if(item.network == 2){
                mainBlockAdd('#activity .section-content .content-column:nth-child(3)', 'Yes, via VIP Plugin');
            }
            else{
                mainBlockAdd('#activity .section-content .content-column:nth-child(3)', '-');
            }

            // checkNull('#activity .section-content .content-column:nth-child(3)', item.network,'-');
            checkNull('#activity .section-content .content-column:nth-child(4)', item.transactions,'-');
            checkNull('#activity .section-content .content-column:nth-child(5)',item.reviews,'-');

            if(item.favorited == 0){
                mainBlockAdd('#activity .section-content .content-column:nth-child(6)', 'No');
            }
            else if(item.favorited == 1){
                mainBlockAdd('#activity .section-content .content-column:nth-child(6)', 'Yes');
            }
            else{
                mainBlockAdd('#activity .section-content .content-column:nth-child(6)', '-');
            }
        });
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

    function workFilterRight(){
        $('#everyoneRadio+label').click(function(){
            filterTable($(this), {'filter':'everyone'});
        });
        $('#myCustomersRadio+label').click(function(){
            filterTable($(this), {'filter':'mycustomer'});
        });
        $('#hereNowRadio+label').click(function(){
            filterTable($(this), {'filter':'herenow'});
        });
        $('#reservationsRadio+label').click(function(){
            filterTable($(this), {'filter':'reservations'});
        });

        function filterTable(self, filterName){
            $('#viewBy .tag span').text(self.text());
            $('#viewBy .menu').hide();
            api.get('customer/',filterName,function(result){
                console.log(result);
                if(result==null){
                    noResult();
                }
                else{

                    if(namePage == 'listView'){
                        loadTable(result);
                    }
                    else{            
                        addBlocks(result);
                    }

                }
            }, function() {
                $('#viewBy .menu').removeClass('flex-menu');
                $('.load-sircle').css('display', 'block');
            }, function() {                
                $('.load-sircle').css('display', 'none');
            });
        }
    }


    function noResult(){
        $('.noRes').show();
        $('#static-columns').hide();
        $('#sortable-overlay').hide();
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
                toFilterObj.countryCode = '';
                toFilterObj.stateId = '';
            } else {
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
            api.get('customer/filter', toFilterObj,function(response) {
                if(response.length==0){
                    noResult();
                }
                else{
                    if(namePage == 'listView'){
                        loadTable(response);
                    }
                    else{            
                        addBlocks(response);
                    }
                }
            }, function() {
                $('#filterBy .menu').toggleClass('flex-menu');
                $('.load-sircle').css('display', 'block');
            }, function() {
                $('.load-sircle').css('display', 'none');
            });
        });


    }
    
    function loadTable(responseNew){
        $('.noRes').hide();
        left_people_block_show(responseNew);
        store_show(responseNew);
        customer_details_show(responseNew);
        reservations_show(responseNew);
        activity_show(responseNew);
        $('#static-columns').show();
        $('#sortable-overlay').show();
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
        oldTime,
        hereNowTime,
        cardBgReservation,
        reservation_html,
        reservation_time,
        html_here_now = '';
        var promotional_spending_at_store_in_dollars = '-';
        var total_transactions_at_store = '-';
        var spending_at_store_in_dollars = '-';
        var itemScore = '';
        var img = 'User_no_photo.png';
        var nowTime = new Date();



        // if(2>1){
        //     cardBg = 'reservationBg';
        // } else if(3<1){
        //     cardBg = 'neutralBg';
        // }else{
        //     cardBg = 'hereNowBg';
        // }
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
            if(item.in_store_spending!=null){
                cardBg = 'reservationBg';
            }
            else{
                cardBg = 'neutralBg';
            }
            if (item.here_now_clock!=null) {
                // console.log("item.here_now_clock = " + item.here_now_clock.slice(-11, 0));
                oldTime = new Date(item.here_now_clock.slice(0, 19));
                hereNowTime = (nowTime - oldTime)/(1000*60);
                if(hereNowTime<10 && item.here_now_clock.slice(20) != "perk_active"){                  
                    html_here_now = '<div class="checkinAlert yellow">Here Now</div>';
                }
                else if(hereNowTime>=10 && hereNowTime<20 && item.here_now_clock.slice(20) != "perk_active"){
                    html_here_now = '<div class="checkinAlert orange">Here Now</div>';                    
                }
                else if(hereNowTime>=20 && item.here_now_clock.slice(20) != "perk_active"){
                    html_here_now = '<div class="checkinAlert red">Here Now</div>';                    
                }
                else if(item.here_now_clock.slice(20) == "perk_active"){
                    html_here_now = '<div class="checkinAlert green">Here Now</div>';                    
                }
            }
            else{
                html_here_now='';
            }
            if(item.reservation_clock == "No reservation"){
                reservation_html = '<div class="top '+cardBg+'" style="float: left">' +
                '<h4 class="firstLine" style="font-size: 1em; padding: 8px 8px 0;">NO RESERVATIONS</h4>' +
                '</div>';
            }
            else{
                if(item.reservation_clock.length <= 27){
                    cardBgReservation = "topReservationGreen";

                    // reservation_time = item.reservation_clock.slice(0, -8);
                }
                else{
                    reservation_time = item.reservation_clock.slice(0, -13);
                    oldTime = new Date(reservation_time);
                    reservation_time = (nowTime - oldTime)/(1000*60*60);
                    // console.log("reservation_time = "+reservation_time);

                    if(reservation_time>=1 && reservation_time<3){
                        cardBgReservation = "topReservationYellow";
                    }
                    else if(reservation_time>=3 && reservation_time<24){
                        cardBgReservation = "topReservationOrange";
                    }
                    else if(reservation_time>=24){
                        cardBgReservation = "topReservationRed";                        
                    }
                }

                reservation_html = '<div class="top '+cardBgReservation+'" style="float: left">' +
                '<div class="resAlert"></div>' +
                '<h4 class="firstLine" style="font-size: 1em;">RESERVATIONS</h4>' +
                '<h4 class="secondLine" style="font-size: 1em;">'+dateInfo+' AT '+timeInfo+'</h4>' +
                '</div>';
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
                reservation_html +                
                '<div class="bottom '+cardBg+'">' +
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
                console.log(result);
                if(result == null || result.length == 0){
                    noResult();
                }
                else{

                    if(namePage == 'listView'){
                        loadTable(result);
                    }
                    else{            
                        addBlocks(result);
                    }
                }
            }, function() {
                $('.load-sircle').css('display', 'block');
            }, function() {
                $('.load-sircle').css('display', 'none');
            });
        });
    }
    api.get('customer/',{}, function(response){
        console.log('response true');
        console.log(response);
        //console.log(response.success);
        //if(response.success === true) {

            if(namePage == 'listView'){
                loadTable(response);
            }
            else{            
                addBlocks(response);
            }
        //}
    }, function() {
        $('.load-sircle').css('display', 'block');
    }, function() {
        $('.load-sircle').css('display', 'none');
        // $('.score-content, .score-menu').css('display', 'block');
    });

    function filterTableByColumns() {
        var sortDirection = 'DESC';
        var sortField;  
        $(document).on('click', '.buttonToFilter', function() {
            var that = $(this);
            var textThat = that.text();
            var classTextThat ='';
            if(that.hasClass('activeColumn')) {
                classTextThat = 'activeColumn';
            }
            //creating string to send to backend
            var replaceSymbols = /[-,!,?]/gi;  
            var str = that.find('span').text().toLowerCase().replace(replaceSymbols, " ").trim().split(' ');
            var newStr = str[0];
            for(var i=0;i<str.length;i++){
                if(i!=0) {
                    newStr +=  str[i][0].toUpperCase() + str[i].slice(1);
                }
            }
            //Sending ASC and DESC to show in which way backend need to sort column
            if(newStr == sortField) {
                if(sortDirection == 'ASC'){
                    sortDirection='DESC';
                } else {
                    sortDirection='ASC';
                }
            } else {
                sortField = newStr;
                sortDirection='ASC';
            }
            var toSendObj = {
                'filter': '',
                'searchData': '',
                'sortData': sortField,
                'sortType': sortDirection
            };
            api.get('customer', toSendObj, function(response){
                loadTable(response);
                $('.content-column-header').each(function(item, index){
                    var self = $(this);
                    if(self.text()==textThat){
                        if(classTextThat == 'activeColumn') {
                            self.addClass('activeColumnTop');
                            self.find('span , a').css('padding-top', '8px');
                        }
                        else {
                            self.addClass('activeColumn');
                            self.find('span , a').css('padding-top', '8px');
                        }
                    }
                });
            });

        });
    }
    filterTableByColumns();
    searchFunction();
    drawFilterBlock();    
    workFilterRight();
    startLeftFilter();
});