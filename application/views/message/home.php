<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <title><?php echo SITE_TITLE.": Inbox";?></title>
   <link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowpage.css" type="text/css" media="screen">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.list.css" type="text/css" media="screen">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.tabs.css" type="text/css" media="screen">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.pagination.css" type="text/css" media="screen">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.messages.css" type="text/css" media="screen">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.network.css" type="text/css" media="screen">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" type="text/css" media="screen">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.date-picker.css" type="text/css" media="screen">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.event-reservation.css" type="text/css" media="screen">
</head>

<body>

<!-- First Page -->
<div id="page1" class="menu-gap top-grey-bg">

<div class="navbar navbar-fixed-top">
<?php
# Vertical menu content
$this->load->view('addons/vertical_menu', array('__page'=>'inbox',
'area'=>($this->native_session->get('__user_type')? $this->native_session->get('__user_type'): 'random_shopper')
));
# Header content
$this->load->view('addons/header_shopper', array('__page'=>'inbox', 'title'=>'Messages'));
?>
</div>





<div style='padding-bottom:40px;'>
   <table class='tab-table'>

      <tr>
         <td class='tab-div selected' id='mail_list' data-type='mail_container'>
            <div class='mail-icon'></div>
            <div>Mail<?php if(!empty($messageStats['unread'])) echo " (".$messageStats['unread'].")";?></div>
         </td>
         <td class='tab-div' id='events_list' data-type='events_container'>
            <div class='events-icon'></div>
            <div>Events<?php if(!empty($messageStats['events'])) echo " (".$messageStats['events'].")";?></div>
         </td>
         <td class='tab-div' id='reservations_list' data-type='reservations_container'>
            <div class='reservations-icon'></div>
            <div>Reservations<?php if(!empty($messageStats['reservations'])) echo " (".$messageStats['reservations'].")";?></div>
         </td>
      </tr>

      <tr>
         <td colspan='3'>
            <div id='tab_details'>

            <?php
            $this->load->view('message/mail_container');
            ?>
         </div>
         </td>
      </tr>
   </table>
</div>




</div>




<div>
<?php $this->load->view('addons/footer_shopper'); ?>
</div>


<?php echo minify_js('message__home', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.menu.js', 'clout.shadowbox.js', 'clout.shadowpage.js', 'clout.search.js', 'clout.pagination.js', 'clout.list.js', 'clout.scroller.vertical.js', 'clout.mail.js', 'jquery-ui-timepicker-addon.js', 'jquery.datepick.js', 'clout.datepicker.js', 'clout.fileform.js', 'clout.inbox.js'));?>
<script>
$(document).ready(function(){

   $(document).on('click', '#modifyreservation', function(){
      var reservationId = $(this).attr('value');
      var formRow = '#modifyreservation_'+reservationId;
      $.ajax({
         url: getBaseURL()+"message/get_reservation_details",
         data: { reservation_id : reservationId},
         type: "post",
         success: function (result) {
            var data = $.parseJSON(result);

            //set list of phone providers
            $(formRow+' #provider').append("<?php echo get_option_list($this, 'provider');?>");
            $(formRow+' #phonetypes').append("<?php echo get_option_list($this, 'phonetypes');?>");
            //show details
            $(formRow+' #email').val(data['scheduler_email']);
            $(formRow+' #name').val(data['scheduler_name']);
            $(formRow+' #phone').val(data['scheduler_phone']);
            $(formRow+' #provider').val(data['telephone_provider_id']);
            $(formRow+' #phonetypes').val(data['phone_type']);
            $(formRow+' #reservationdate_'+reservationId).val(data['schedule_date']);
            $(formRow+' #numberinparty').val(data['number_in_party']);
            $(formRow+' #specialrequest').val(data['special_request']);

            //set details value
            $(formRow+' #email').attr('value', data['scheduler_email']);
            $(formRow+' #name').attr('value', data['scheduler_name']);
            $(formRow+' #phone').attr('value', data['scheduler_phone']);
            $(formRow+' #provider').attr('value', data['telephone_provider_id']);
            $(formRow+' #phonetypes').attr('value', data['phone_type']);
            $(formRow+' #reservationdate_'+reservationId).attr('value', data['schedule_date']);
            $(formRow+' #numberinparty').attr('value', data['number_in_party']);
            $(formRow+' #specialrequest').attr('value', data['special_request']);

            $(formRow).css('display','flex');

         },
         error: function (xhr, ajaxOptions, thrownError) {
            showServerSideFadingMessage('ERROR: can not get reservation details');
         }
      });

   });

   $(document).on('click', '#responsetoevent > a', function(){

      var ans = true;
      var thisRow = $(this).closest('tr');
      var thisOption = $(this);
      var eventId = thisRow.attr('id').split('_').pop();
      var storeId = thisRow.attr('value');
      var response = $(this).attr('name');
      var dateTime = thisRow.find('.date').attr('value');

      if ( response == 'yes' ){

         var idofattend = $(this).attr('id');
         ans = false;

         if(idofattend == 'reservationform'){
            //append provider list when needed
            thisRow.next().find('#provider').append("<?php echo get_option_list($this, 'provider');?>");
            thisRow.next().find('#phonetypes').append("<?php echo get_option_list($this, 'phonetypes');?>");
         } else if (idofattend == 'enternumberofpeople') {

            if(thisRow.next().find('#numberinparty').is('select')){
               var limit = thisRow.next().find('#numberinparty').attr('data-limit');
               for ( i=1; i<=limit; i++){
                  thisRow.next().find('#numberinparty').append($('<option></option>').val(i).html(i));
               }
            }
         }

         thisRow.next().css('display','flex');

      } else if ( response == 'maybe' ) {
         var attendStatus = 'pending';
         var eventStatus = 'read';
      } else if ( response == 'no' ) {
         var attendStatus = 'not_going';
         var eventStatus = 'archived';
      }

      if (ans) {
         updateEventNotice(eventId, storeId, attendStatus, eventStatus, dateTime, thisOption);
      }
   });

});

//Pass variables to update promotion_notices table in database
function updateEventNotice(eventId, storeId, attendStatus, eventStatus, dateTime, thisOption)
{
   var response = thisOption.attr('name');

   $.ajax({
      url: getBaseURL()+"message/update_event_notice",
      data: {
         promotion_id : eventId,
         store_id : storeId,
         attend_status : attendStatus,
         event_status : eventStatus,
         event_time: dateTime,
         info: $('#info').val()
      },
      type: "post",
      beforeSend: function(){
         showServerSideFadingMessage('Saving changes...');
      },
      success: function (result) {

         if ( response == 'yes' ){

            thisOption.addClass('boldtext greenbar');
            if(thisOption.next().hasClass('boldtext')) {
               thisOption.next().removeClass('boldtext bluebar');
            } else if(thisOption.prev().hasClass('boldtext')) {
               thisOption.next().next().removeClass('boldtext redbar');
            }

         } else if ( response == 'maybe' ) {

            thisOption.addClass('boldtext bluebar');
            if(thisOption.next().hasClass('boldtext')) {
               thisOption.next().removeClass('boldtext redbar');
            } else if(thisOption.prev().hasClass('boldtext')) {
               thisOption.prev().removeClass('boldtext greenbar');
            }
            thisOption.closest('tr').css('background-color','#FFC');
            showServerSideFadingMessage('Your choice has been noted. We will remind you before the event to check if you are still interested.');

         } else if ( response == 'no' ) {

            thisOption.addClass('boldtext redbar');
            if(thisOption.prev().hasClass('boldtext')){
               thisOption.prev().removeClass('boldtext bluebar');
            } else if(thisOption.prev().prev().hasClass('boldtext')) {
               thisOption.prev().prev().removeClass('boldtext greenbar');
            }
            thisOption.closest('tr').css('background-color','white');

         } else if (response == 'cancel'){

            thisOption.closest('tr').css('background-color','#FFF');
            thisOption.parent().html('<a id="reservationform" name="yes">Yes</a> <a name="maybe">Maybe</a> <a name="no">No</a>');

         }

      },
      error: function (xhr, ajaxOptions, thrownError) {
         showServerSideFadingMessage('ERROR: Your changes haven not been made. Please try again later.');
      }
   });
}

//Reaction of switch list of Reservation Tab
function switcharchived(switchTo)
{
   var resultDiv = $('#resultsdiv').val();
   var url = $('#action').val();

   $.ajax({
      url: url,
      data: { 'sort__switcharchived__hidden' : switchTo},
      type: "post",
      success: function (result) {

         $('#'+resultDiv).html(result);
         if(switchTo == 'archived') {
            $('#reservationdate').removeClass('future-date');
            $('.response').hide();
         } else {
            $('#reservationdate').addClass('future-date');
            $('.response').show();
         }
      },
      error: function (xhr, ajaxOptions, thrownError) {
         showServerSideFadingMessage('ERROR: can not show the list.');
      }
   });
}

//Reaction of switch list of Event Tab
function switcheventslist(switchTo)
{
   var resultDiv = $('#resultsdiv').val();
   var url = $('#action').val();

   $.ajax({
      url: url,
      data: { 'sort__switcheventslist__hidden' : switchTo},
      type: "post",
      success: function (result) {

         $('#'+resultDiv).html(result);
         if(switchTo == 'passed') {
            $('#eventdate').removeClass('future-date');
            $('.response').hide();
            $('tbody tr').css('background-color','white');
         } else {
            $('#eventdate').addClass('future-date');
            $('.response').show();
         }
      },
      error: function (xhr, ajaxOptions, thrownError) {
         showServerSideFadingMessage('ERROR: can not show the list.');
      }
   });
}
</script>
</body>
</html>
