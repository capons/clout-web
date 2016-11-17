// JavaScript Document

$(function() {
$(document).ready(function(){
	var selectedBanks = new Array(10);
	var selectedBanksId = new Array(10);
	var submitted;
	var next = 4;
	var endOfTheSubmittedList;

	$(".microform").on("click", "#addbtn", function(e){
        e.preventDefault();
        var addto = "#row" + next;
        next++;

        if($('tr').length < 12) {

			//Add full width input field if user haven't submitted
            if(!submitted) {
	        	var newIn = '<tr id="row' +next+'"><td><div><input type="text" id="'+next+'_bankname__banks" class="textfield searchable do-not-clear optional" '+
	        	'placeholder="Optional"><div id="activate-btn-div" class="activate-btn-div"><a class="bankLink shadowbox" href=""><button id="activate'+next+'" class="btn activateBtn">Activate</button></a></div></div></td></tr>';
			//Add an input field with submit button after user submitted
	        } else {
            	var newIn = '<tr id="row' +next+'"><td><div><input type="text" id="'+next+'_bankname__banks" class="textfield searchable do-not-clear optional" '+
            	'placeholder="Optional" style="width: 65%;"><div id="activate-btn-div" class="activate-btn-div" style="width: 30%; opacity: 1;"><button id="submitMoreBtn" class="btn green">Submit</button></div></div></td></tr>';
            }

            var newInput = $(newIn);
	        $(addto).after(newInput);
         } else if( $('tr').length >= 12 && submitted){
             $("#addbtn").remove();
         }
    });

    //Detect duplicate banks from input fields
	$(".microform").on("change", ".textfield", function(){

		var inputField = $(this).attr('id').split('_').shift()-1;


		if($(this).val().indexOf("Request") >= 0){

			var requestedBank = $(this).siblings('.drop-down-div').children('#notFound').attr('data-value');
			$(this).val('Not Found, Request to Add \"'+requestedBank+'\"');
			$(this).addClass('notFound');

		}else if($.inArray($(this).val(),selectedBanks) != -1){

			showServerSideFadingMessage('ERROR: The bank you have provided already exist.');
			$(this).val('');
			selectedBanks.splice(inputField, 1 ,"");

		} else {
			selectedBanks.splice(inputField, 1 ,$(this).val());
		}

    });

    //get the hidden input value of bank id
    $(".microform").on("change", "input[type='hidden']", function(){
    	var inputField = $(this).attr('id').split('_').shift()-1;
    	var id = $(this).val().split(" ").shift();

		if($.inArray(id,selectedBanks) != -1){

			selectedBanksId.splice(inputField, 1 ,"");

		} else {
			selectedBanksId.splice(inputField, 1 ,id);
		}

		$.ajax({
	        url: getBaseURL()+"Account/list_banks/",
	        data: {selected_banks: selectedBanksId},
	        type: "post",
	        success: function (result) {
	        },
	        error: function (xhr, ajaxOptions, thrownError) {
	        	showServerSideFadingMessage('ERROR: Cannot find your banks try again.');
	        }
	  	});

    });

    //Use ajax to get the links for each bank
	$(".microform").on("click", "#submitbtn", function(){

		 $.ajax({
		        url: getBaseURL()+"Account/generate_activate_button/",
		        data: {bankname__banks: selectedBanks},
		        type: "post",
		        success: function (result) {
			        var links = jQuery.parseJSON(result);

			        //Activate buttons slides in
		        	$('.activate-btn-div').css({'width': '30%', 'opacity': '1'});
		        	$('.textfield').css('width', '65%');
		        	$('.textfield').prop('readonly', true).removeClass('searchable');

		        	//Remove empty input fields
		        	$('.textfield').each(function(index, value){
		        		if($(this).val() == ""){
		        			$(this).closest("tr").remove();
		        			next = next - 1;
			        	}
			        	if($(this).hasClass('notFound')){
				        	var requestedBank = $(this).val().split("\"")[1];
							$(this).val(requestedBank);
				        }
			        });

					//Delete empty value from selectedBanks and sort
			        $.grep(selectedBanks, function(n, i){
							return n != "";
				    });

					//Assign links for each activate buttons
		        	$('.bankLink').each(function(index, value){

			        	var link = links.shift();

			        	if(link != ""){
			        		$(this).attr('href', link);
			        	//A bank that is not in our system
			        	} else {
				        	//Set Requested button
				        	$(this).css('pointer-events', 'none');
							$(this).children().removeClass('green').addClass('grey').html('Requested').css('color','black');

							//Set input field grey
							$(this).parent().siblings('.textfield').css('background-color','#ccc');
				        }
					});

					//Set properties of Continue Btn then hide it
					$('.submitmicrobtn').html('Continue').attr('id','continueBtn').hide();
					$('#continueBtn').attr('data-parenturl','account/update_user_phone');
					submitted = true;
					endOfTheSubmittedList = $(".textfield:last").attr('id').split('_').shift();
					next = endOfTheSubmittedList;

		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		        	showServerSideFadingMessage('ERROR: Cannot find your banks try again.');
		        }
		  });

	});

    //Generate the links for the bank that user add after they submitted
	$(".microform").on("click", "#submitMoreBtn", function(){

		var newBank = $(this).parent().siblings(".textfield").val();
		var newBankInputField =  $(this).parent().siblings(".textfield");
		var newBankBtnDiv = $(this).parent();
		var idNumber = newBankInputField.attr('id').split('_').shift();

		if(newBank != "" && newBank.indexOf("Request") < 0){
			$.ajax({
		        url: getBaseURL()+"Account/generate_activate_button/",
		        data: {bankname__banks: [newBank]},
		        type: "post",
		        success: function (result) {
			        var link = jQuery.parseJSON(result);

		        	newBankInputField.prop('readonly', true).removeClass('searchable');
		        	newBankBtnDiv.html('<a class="bankLink shadowbox" href="'+link+'"><button id="activate'+idNumber+'" class="btn activateBtn">Activate</button></a>');

		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		        	showServerSideFadingMessage('ERROR: Cannot find your banks try again.');
		        }
		  	});
		} else {
			var requestMore = newBank.split(' ').pop().replace(/"/g,'');
			newBankInputField.prop('readonly', true).removeClass('searchable').css('background-color','#ccc').val(requestMore);
        	newBankBtnDiv.html('<a class="bankLink shadowbox" style="pointer-events: none;" href=""><button id="activate'+idNumber+'" class="btn activateBtn grey" style="color: black;">Requested</button></a>');
		}

	});

	$(".microform").on("click", ".activateBtn", function(){
        var trigger_id = $(this).attr('id');
		$('#iframe_trigger').val(trigger_id);
    });


});

});

function closeIFrame(){
    $('#__shadowbox_closer').click();
    if($("button").is("#activated")){
		$(".submitmicrobtn").show();
    }
};
