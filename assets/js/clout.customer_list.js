
$(document).ready(function(){

    var mainListViewBlock = $('#list-view');
    var customerList = $('#customer-list');
    var storeList = $('#store .section-content');
    var customerDetailsList = $('#customer_details .section-content');
    var reservationsList = $('#reservations .section-content');
    var activityList = $('#activity .section-content');
    var filterBy = $('#filterBy');
    var filterBlock = $('#filterBy .country-wrap');
    var labelForChooseCountry = $('.choose-country+label');

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

    function topListAdd(text, nameParrent){
        var topStoreList =
            '<div class="content-column">'+
            '<div class="content-column-header ui-sortable-handle">'+
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

        responseNew.forEach(function(item, i, arr) {
            $('#customer-list .content-customer-column:nth-child(1)').append(
                '<div class="content-column-data no-left-border">'+
                '<div class="clout-checkbox">'+
                '<input type="checkbox" value="None" id="user_id_'+i+'" name="check" class="customer-checkbox">'+
                '<label for="user_id_'+i+'"></label>'+
                '</div>'+
                '</div>');
            if(2>1){
                var name = "-";
                if(item.name != null && item.name != undefined && item.name != '' && item.name != '0'){
                    name = item.name;
                }
                $('#customer-list .content-customer-column:nth-child(2)').append(
                    '<div class="content-column-data">'+
                    '<img class="customerImage" src="../../../assets/images/customer/twitter.jpg">'+
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
            if(item.upcoming!=null){
                $('#customer-list .content-customer-column:nth-child(3)').append(
                    '<div class="content-column-data user-alerts-data">'+
                    '<div class="blueAlert"></div>'+
                    '</div>');
            }
            else if(item.last_checkins!=null){
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
            if(item.notes!=null){
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
        var arrTopActivityList = ['Last Checkin','Past Checkins','In Network','Transactions','Reviews','Favorited'];


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
                if(result==null){
                    noResult();
                }
                else{
                    loadTable(result);
                }
            }, function() {
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
                    loadTable(response);
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
                    loadTable(result);
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

        loadTable(response);
        //}
    }, function() {
        $('.load-sircle').css('display', 'block');
    }, function() {
        $('.load-sircle').css('display', 'none');
        $('.score-content, .score-menu').css('display', 'block');
    });
    searchFunction();
    drawFilterBlock();
    $('#viewBy').click(function(){
        workFilterRight();
    });
});