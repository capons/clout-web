// JavaScript Document
$(function() {
   $(document).ready(function(){

      var counterEvents = makeEventCounter();
      var counterReservations = makeReservationCounter();

      $(document).on('click', '.tab-div', function(){
         $(this).parent().find('.tab-div').each(function(i, element){
            $(this).removeClass('selected');
         });
         $(this).addClass('selected');


         $.ajax({
            url: getBaseURL()+"message/tab_handler",
            data: { tab_details : $(this).attr('data-type')},
            type: "post",
            success: function (result) {
               $('#tab_details').html(result);
               counterEvents = makeEventCounter();
               counterReservations = makeReservationCounter();
               $('.showtime.clickactivated').datetimepicker({
                  changeMonth: true,
                  changeYear: true,
                  dateFormat: 'mm/dd/yy',
                  timeFormat: "hh:mm tt"
               });
            },
            error: function (xhr, ajaxOptions, thrownError) {
               showServerSideFadingMessage('ERROR: Sorry! Something went wrong.');
            }

         });
      });

      $(document).on('click', '#events-filter-btn', function(){
         $('#filter').toggle();
         $(this).toggleClass( "blue" );
      });

      $(document).on('click', '.cancelreservation', function(){

         var promotionId = $(this).attr('value');
         var ans = confirm("Are you sure you want to cancel this reservation? This action is irreversible and a notice will be sent to the business owner about your cancellation.");
         var resultDiv = $('#resultsdiv').val();
         var attendStatus = 'cancelled';
         var eventStatus = 'read';
         var thisRow = $(this).closest('tr');
         var thisOption = $(this);
         var eventId = thisRow.attr('id').split('_').pop();
         var storeId = thisRow.attr('value');
         var dateTime = thisRow.find('.date').attr('value');
         var info = $(this).attr('data-info');

         if(ans) {
            $.ajax({
               url: getBaseURL()+"message/cancel_reservation",
               data: { promotion_id : promotionId,
                        store_id: storeId,
                        info: info},
               type: "post",
               beforeSend: function(){
                  showServerSideFadingMessage('Canceling your reservation...');
               },
               success: function (result) {

                  if (resultDiv == 'eventlistdiv') {
                     updateEventNotice(eventId, storeId, attendStatus, eventStatus, dateTime, thisOption);
                     showServerSideFadingMessage('Your reservation has been canceled');
                  } else {
                     //Cancel Reservation in Reservation Tab
                     thisRow.css('display','none');
                     showServerSideFadingMessage('Your reservation has been canceled');
                  }
               },
               error: function (xhr, ajaxOptions, thrownError) {
                  showServerSideFadingMessage('ERROR: can not cancel your reservation right now. please try again later.');
               }
            });
         }
      });

      $(document).on('click', '#makereservation', function(){

         var formRow = '#'+$(this).parents('tr').attr('id');
         var infoRow = $(formRow).prev();
         var promotionId = $(this).val();
         var name =  $(formRow+' #name').val();
         var email = $(formRow+' #email').val();
         var phone = $(formRow+' #phone').val();
         var phoneId = $(formRow+' #provider').val();
         var phoneType = $(formRow+' #phonetypes').val();
         var scheduleDate = $(formRow+' #eventdate_'+promotionId).val();
         var numberInParty = $(formRow+' #numberinparty').val();

         //data for update promotion_notices
         var thisOption = infoRow.find('a[name="yes"]');
         var storeId = infoRow.attr('value');
         var attendStatus = 'confirmed';
         var eventStatus = 'read';
         var dateTime = infoRow.find('.date').attr('value');

         var parameters = "";

         if (typeof name === 'undefined' && numberInParty != '') {
            parameters = {
               promotion_id : promotionId,
               schedule_date : dateTime,
               number_in_party : numberInParty,
               info: $(formRow+' #info').val()
            };

         } else if (typeof name !== 'undefined' && email != '' && phone != '' && phoneId != '' &&
                     phoneType != '' && scheduleDate != '' && numberInParty != '') {

            parameters = {
               promotion_id : promotionId,
               scheduler_name : name,
               scheduler_email : email,
               scheduler_phone : phone,
               telephone_provider_id : phoneId,
               phone_type : phoneType,
               schedule_date : scheduleDate,
               number_in_party : numberInParty,
               special_request : $(formRow+' #specialrequest').val(),
               info: $(formRow+' #info').val()
            };

         } else {
            showServerSideFadingMessage('Enter all required fields to continue.');
         }

         if(parameters != ''){
            $.ajax({
               url: getBaseURL()+"message/make_reservation",
               data: parameters,
               type: "post",
               beforeSend: function(){
                  showServerSideFadingMessage('Saving changes...');
               },
               success: function (result) {

                  var data = $.parseJSON(result);
                  if(data['result'] == 'SUCCESS'){
                     showServerSideFadingMessage('Your reservation on this event has been submitted.');
                     updateEventNotice(promotionId, storeId, attendStatus, eventStatus, dateTime, thisOption);
                     $(formRow).css('display','none');

                     //set 'reservation_id' to the cancel reservation button and highlight the row
                     infoRow.css('background-color','#FFC');
                     if(typeof name !== 'undefined') {
                        infoRow.find('#responsetoevent').html('<button class="smallbtn blacksmallbtn cancelreservation" name="cancel" value="'+promotionId+'">Cancel Reservation</button>');
                     }
                     infoRow.find('.friends').text(function(i,oldVal ){
                           if (parseInt(oldVal ,10) + parseInt(numberInParty, 10) > 20) {
                              $(this).show();
                              return (parseInt(oldVal ,10) + parseInt(numberInParty, 10)) +' people going' ;
                           }
                     });
                  }
               },
               error: function (xhr, ajaxOptions, thrownError) {
                  showServerSideFadingMessage('ERROR: can not make reservation right now. Please try again later.');
               }
            });
         }
      });

      $(document).on('click', '#updatereservation', function(){

         var reservationId = $(this).attr('value');
         var formRow = '#modifyreservation_'+reservationId;
         var submitbtn = $(this);
         var name =  $(formRow+' #name').val();
         var email = $(formRow+' #email').val();
         var phone = $(formRow+' #phone').val().replace(/-|\(|\)| /g,'');
         var phoneId = $(formRow+' #provider').val();
         var phoneType = $(formRow+' #phonetypes').val();
         var scheduleDate = $(formRow+' #reservationdate_'+reservationId).val();
         var numberInParty = $(formRow+' #numberinparty').val();

         var parameters = "";

         if (name != '' && email != '' && phone != '' && phoneId != '' &&
                     phoneType != '' && scheduleDate != '' && numberInParty != '') {

            parameters = {
               reservation_id : reservationId,
               scheduler_name : name,
               scheduler_email : email,
               scheduler_phone : phone,
               telephone_provider_id : phoneId,
               phone_type : phoneType,
               schedule_date : scheduleDate,
               number_in_party : numberInParty,
               special_request : $(formRow+' #specialrequest').val(),
               info: $('#info').val(),
               store_id: $('#storeid').val()
            };

         }
         console.log(parameters);
         if (parameters != '') {
            $.ajax({
               url: getBaseURL()+"message/update_reservation",
               data: parameters,
               type: "post",
               beforeSend: function(){
                  showServerSideFadingMessage('Saving changes...');
               },
               success: function (result) {
                  showServerSideFadingMessage('Your changes have been saved.');
                  $(formRow).css('display','none');
                  submitbtn.prop("disabled",false);
               },
               error: function (xhr, ajaxOptions, thrownError) {
                  showServerSideFadingMessage('ERROR: can not get reservation details');
               }
            });
         } else {
            showServerSideFadingMessage('Enter all required fields to continue.');
         }
      });

      $(document).on('click', '.closerow', function(){
         var thisRow = $(this).parents('tr').attr('id');
         $('#'+thisRow).css('display','none');
      });

      $(document).on('click', '.redirect', function(){
         $.ajax({
            url: getBaseURL()+"message/email_landing_page",
            data: { redirect: true},
            type: "post",
            success: function (view) {
               window.location.replace( getBaseURL()+view);
            },
            error: function (xhr, ajaxOptions, thrownError) {
             showServerSideFadingMessage('ERROR: Something went wrong.');
            }
         });
      });


      $(document).on('click', '#seemoreevents', function(){
         var i = counterEvents();
         var url = $('#action').val();

         $.ajax({
            url: url,
            data: { offset: i},
            type: "post",
            beforeSend: function(){
               showServerSideFadingMessage('Loading more events...');
            },
            success: function (result) {

               if ( result.indexOf("error") != -1) {
                  showServerSideFadingMessage('No more events.');
               } else {
                  $('.events-table:last-child').after(result);
                  $('.showtime.clickactivated').datetimepicker({
                     changeMonth: true,
                     changeYear: true,
                     dateFormat: 'mm/dd/yy',
                     timeFormat: "hh:mm tt"
                  });
               }
            },
            error: function (xhr, ajaxOptions, thrownError) {
               showServerSideFadingMessage('ERROR: can not make reservation right now. Please try again later.');
            }
         });

      });
      $(document).on('click', '#seemorereservations', function(){
         var i = counterReservations();
         var url = $('#action').val();

         $.ajax({
            url: url,
            data: { offset: i},
            type: "post",
            beforeSend: function(){
               showServerSideFadingMessage('Loading more reservations...');
            },
            success: function (result) {

               if ( result.indexOf("error") != -1) {
                  showServerSideFadingMessage('No more reservations.');
               } else {
                  $('.events-table:last-child').after(result);
                  $('.showtime.clickactivated').datetimepicker({
                     changeMonth: true,
                     changeYear: true,
                     dateFormat: 'mm/dd/yy',
                     timeFormat: "hh:mm tt"
                  });
               }
            },
            error: function (xhr, ajaxOptions, thrownError) {
               showServerSideFadingMessage('ERROR: can not make reservation right now. Please try again later.');
            }
         });

      });

      $(document).one('focus', '.timerange', function(){
         var endDate = $(this).attr('data-end');
         var startDate = $(this).attr('data-start')

         $(".timerange" ).datetimepicker( "option", "maxDate", endDate);
      });

   });

   //count for offset that pass to query
   function makeEventCounter()
   {
      var count = 0;
      return function() {
         count += 5;
         return count;
      };
   }

   //count for offset that pass to query
   function makeReservationCounter()
   {
      var count = 0;
      return function() {
         count += 5;
         return count;
      };
   }

});
