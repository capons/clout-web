<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITE_TITLE.": Network";?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.list.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.pagination.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.search.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.network.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.form.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.donut-chart.css" type="text/css" media="screen">
    <style type="text/css">
		#page1 {
			position: relative;
		}
		#code-area textarea {
			resize:none; 
			background-color: #f6f6f6; 
			font-size: 13px; 
			font-family:Menlo,Monaco,Consolas;
			width: 95%;
			margin: auto;
		}
		
		#vip-btn-generator {
			display: flex;
			flex-direction: column;
			justify-content: space-between;
			align-items: stretch;
			height: 300px;
		}
		
		.form-row {
			display: flex;
			flex-direction: row;
			justify-content: space-between;
			align-items: center;
		}
		
		.form-row input:not([type="radio"]),
		.form-row select,
		.radio-button-wrapper {
			width: 80%;
		}
		
		.radio-button-wrapper {
			display: flex;
			flex-direction: row;
			justify-content: flex-start;
			align-items: center;
		}

		.radio-button-wrapper div{
			width: 20%;
			display: flex;
			flex-direction: row;
			align-items: center;
		}
		
		.radio-button-wrapper span{
			margin-left: 5%;
		}

		#redirect-url-input {
			display: flex;
			flex-direction: row;
			justify-content: space-between;
			align-items: center;
			width: 60%;
		}
		
		#redirect-url-input input{
			width: 90%;
		}

		#code-area {
			display: flex;
			justify-content: space-around;
		}
		
		#button-short { 
			width: 50px; 
			height: 10px; 
			background: lightgreen; 
			margin-left: 5%;
		}
		
		#button-long { 
			width: 100px; 
			height: 10px; 
			background: lightgreen; 
			margin-left: 5%;
		}
		
		#generatebtn {
			width:100%;
		}
		
	</style>
</head>

<body>

<!-- First Page -->
<div id="page1" class="menu-gap">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', array('__page'=>'network_home', 
	'area'=>($this->native_session->get('__user_type')? $this->native_session->get('__user_type'): 'random_shopper')
)); 
# Header content
$this->load->view('addons/header_admin', array('__page'=>'network_home', 'title'=>'Network'));
?>
</div>







<div class="search-wrapper">


<!-- ---------------------------------------------------------------------------------
 INVITE BOX STARTS HERE 
 --------------------------------------------------------------------------------- -->

<?php if(check_access($this,'can_view_invite_tools')){?>
<div class='details-box'>
<table style="width:100%; border:none; padding:5px;">
   		<tr><td>Invite Tools</td></tr>
        
        <tr>
          <td>
          <table class='normal-list-table'>
          
          <tr><td><div class='accordion-options'>
          <div class='header paste-emails open'>Enter or Paste Emails</div>
          <div class='details' id='paste_email_details' style="display:block;"><?php $this->load->view('network/paste_email');?></div>
          </div></td></tr>
          
          <tr><td><div class='accordion-options'>
          <div class='header share-your-link'>Share/Create Custom Referral URL</div>
          <div class='details' id='share_your_link_details'><?php $this->load->view('network/share_your_link', array('userLinks'=>$userLinks));?></div>
          </div></td></tr>
          
          <!-- <tr><td><div class='accordion-options'>
          <div class='header import-from-email'>Import From Email</div>
          <div class='details' id='import_from_email_details'><?php #$this->load->view('network/import_from_email');?></div>
          </div></td></tr>
          
          <tr><td><div class='accordion-options'>
          <div class='header import-from-file'>Import From File</div>
          <div class='details' id='import_from_file_details'><?php #$this->load->view('network/import_from_file');?></div>
          </div></td></tr> -->
          
          
          </table>

          
          </td>
        </tr>
        </table>
</div>
<?php }?>










<!-- ---------------------------------------------------------------------------------
 NETWORK BOX STARTS HERE 
 --------------------------------------------------------------------------------- -->

<?php if(check_access($this,'can_view_my_commission_network')){?>
<div class='details-box'>
	<table style="width:100%; border:none; padding:5px;">
		<tr>
			<td>My Commission Network</td>
		</tr>
		
		<tr>
		   <td>
			   <table class='normal-list-table' style='table-layout:fixed;'>
			      <tr>
			      	<td class="tabdiv selected" data-tabcategory='network' id="my_network"><span>Network</span><br><span class="purple" id='my_network_count'><?php echo format_number($pageStats['total_users_in_my_network'],6);?></span></td>
			      	<td class="tabdiv" data-tabcategory='network' id="my_invites"><span>Invites</span><br><span class="blue" id='my_invite_count'><?php echo format_number($pageStats['total_invites_in_my_network'],6);?></span></td>
			      	<td class="tabdiv" data-tabcategory='network' id="my_earnings"><span>Earnings</span><br><span class="green" id='my_earnings_count'><?php echo "$".format_number($pageStats['total_earnings_in_my_network'],6);?></span></td>
			      </tr>
			      <tr>
			      	<td colspan='3' style="padding:0px;">
			      		<div id='tabdivdetails'><?php $this->load->view('network/my_network_details', array('pageStats'=>$pageStats));?></div>
			      	</td>
			      </tr>
			   </table>
		   </td>
		</tr>

<!-- Load the chart from google here and then copy it to the right place -->
		<tr>
			<td>
				<div id='hidden_score_div' style="display:none;">
					<div class='in-cell' id="donutchart">&nbsp;</div>
					<div class='in-cell' id="donutchartskeleton">&nbsp;</div>
					<div class='in-cell' id="donutcharttext">
						<div>
							<span class='score'><?php echo format_number($pageStats['clout_score'],5,0);?></span>
							<span class='score-label'>Clout Score</span>
						</div>
					</div>
					<div id="donutchartsmall">
						<span class='score'><?php echo format_number($pageStats['clout_score'],5,0);?></span>
						<span class='score-label'>Store Score</span>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>
<?php }?>

<!-- ---------------------------------------------------------------------------------
 GENERATE VIP MODULE BOX STARTS HERE 
 --------------------------------------------------------------------------------- -->
 
<?php if(check_access($this,'can_generate_referral_button')){?>
<div class='details-box'>
	<table style="width:100%; border:none; padding:5px;">
   		<tr><td><?php echo $menuVipButtonLabel;?></td></tr>
        
        <tr>
          <td>
          	<table class="normal-list-table microform ignoreclear">
				<tr>
					<td id="vip-btn-generator">

						<div class="form-row">
							<?php echo $referralUrlLabel;?>: <input type="text" id="userLinks" class="searchable drop-down-icon" placeholder="<?php echo $referralUrlHint;?>">
						</div>
						<div class="form-row">
							<?php echo $buttonStyleLabel;?>: 
							<div class="radio-button-wrapper">
								<div>
									<input type="radio" id="radioShort" name="length" value="short" checked ><div id="button-short"></div>
								</div>
								<div>
									<input type="radio" id="radioLong" name="length" value="long" ><div id="button-long"></div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<?php echo $navigationLabel;?>: 
							<div class="radio-button-wrapper">
								<div>
									<input type="radio" id="radioPopup" name="navigation" value="popup" checked><span>Pop-up</span>
								</div>
								<div>
									<input type="radio" id="radioRedirect" name="navigation" value="redirectUrl"><span>Redirect</span>
								</div>
								<div id="redirect-url-input" style="visibility:hidden;">
									<span>to</span>
									<input type="text" id="redirectUrl" name="redirectUrl" placeholder="<?php echo $redirectHint;?>" class="url optional">
								</div>
							</div>
						</div>
						<div class="form-row">
							<?php echo $dataPostUrlLabel;?>: <input type="text" id="websiteLink" class="url" name="website" placeholder="<?php echo $dataPostUrlLabel;?>">															<!-- class="url"  -->
						</div>
						<div class="form-row">
							<button id="generatebtn" name="vip_form_btn" class="btn green submitmicrobtn"><?php echo $generateButtonLabel;?></button>
							<input type="hidden" id="resultsdiv" name="resultsdiv" value="code-area"/>
							<input type="hidden" id="action" name="action" value="<?php echo base_url();?>network/business_network" />
						</div>
					</td>
				</tr>
				<tr>
					<td style="display:none"><div id="code-area"></div></td>
				</tr>
		
			</table>

          </td>
        </tr>
	</table>
</div>
<?php }?>


</div>








<?php $this->load->view('addons/footer_admin'); ?>
</div>





<?php echo minify_js('network__business_network', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.search.js', 'clout.network.js', 'clout.list.js', 'clout.pagination.js'));?>


<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]}); 
      google.setOnLoadCallback(drawChart);
      
	  
	  function drawChart() {
        var data1 = google.visualization.arrayToDataTable([
          ['Clout', 'Score'],
          ['', <?php echo ($pageStats['clout_score'] > 1000)? 1000: $pageStats['clout_score'];?>],
          ['', <?php echo (1000 - ($pageStats['clout_score'] > 1000? 1000: $pageStats['clout_score']));?>]
        ]);
		
		var data2 = google.visualization.arrayToDataTable([
          ['Clout', 'Score'],
          ['',  160],
          ['',  160],
		  ['',  160],
          ['',  160],
		  ['',  160]
        ]);

        var options1 = {
          pieHole: 0.7,
		  backgroundColor: 'transparent',
		  legend: 'none',
          pieSliceText: 'none',
          pieStartAngle: 180,
		  pieSliceBorderColor: '#F2F2F2',
          tooltip: { trigger: 'none' },
          slices: {
            0: { color: '#2DA0D1' },
            1: { color: '#E0E0E0' }
          },
		  chartArea: {left:0,top:0,width:"180",height:"180"}
        };
		
		var options2 = {
          pieHole: 0.7,
		  backgroundColor: 'transparent',
		  legend: 'none',
          pieSliceText: 'none',
          pieStartAngle: 180,
		  pieSliceBorderColor: '#F2F2F2',
          tooltip: { trigger: 'none' },
          slices: {
            0: { color: 'transparent' },
            1: { color: 'transparent' },
            2: { color: 'transparent' },
            3: { color: 'transparent' },
            4: { color: 'transparent' }
          },
		  chartArea: {left:0,top:0,width:"180",height:"180"}
        };

        var chart1 = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart1.draw(data1, options1);
		
		var chart2 = new google.visualization.PieChart(document.getElementById('donutchartskeleton'));
        chart2.draw(data2, options2);
		
      }



//Copy the html of a score chart to a destination where it is going to be shown
function copyScoreChart(source, destination){
	$('#'+destination).html($('#'+source).html());
}

$(document).ready(function(){
	//Show or hide an input field for entering redirect URL
	$('input[name="navigation"]').change(function() {    
	    
	    if($(this).val() == "redirectUrl"){   
	        $('#redirect-url-input').css("visibility","visible");
	        $('#redirect-url-input input').removeClass("optional");
	    }
	    else if($(this).val() == "popup"){
	        $('#redirect-url-input').css("visibility","hidden");
		        $('#redirect-url-input input').addClass("optional");
	    }
	
	});

	//Show code area
	$("#generatebtn").on("click", function(){
		$("#code-area").parent().css("display","inline");
	});
});

</script>
</body>
</html>