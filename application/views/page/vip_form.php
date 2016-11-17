<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": ".$pageTitle;?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">
    <style type="text/css">
		#page1 {
			position: relative;
		}
		
		textarea {
			resize:none; 
			background-color: #f6f6f6; 
			font-size: 13px; 
			font-family:Menlo,Monaco,Consolas;
		}
	 	
	 	.radio_button_wrapper div input[type="radio"] {
	 		
			width: 5%;

	 	}
	 	
	 	.radio_button_wrapper {
	 		width:50%; 
	 		text-align:left;
	 	}
	 	.one-column-table {
	 		max-width: 700px;
	 	}

	 	.one-column-table table td div:first-child {
	 		width: 20%;
	 		text-align:left;
	 		margin: auto;
	 		padding-top: 1.5%;	
	 	}
	 	
	 	.one-column-table table td div:last-child {
	 		width: 80%;
	 		float: left; 
	 	}
	 	
	 	#first_choise {
			width: 25%;
		}
		
		#redirect_url_input span {
	 		float: left; 
	 		padding: 2%;
	 		margin-top: 1%;
	 	}
	 		
	 	@media screen and (max-width:700px){
	 	
	 		.one-column-table {
	 			max-width: 550px;
	 		}
	 		.one-column-table table td div:first-child {
	 			width:50%;
	 			text-align:left;
	 		}
	 		
	 		.one-column-table table td div:last-child {
	 			width: 100%;
	 			float: left; 
	 		}

			#first_choise {
				width: 20%;
			}
	 		
	 		#redirect_url_input span {
	 			float: right;  			
	 			padding-left: 5px;
	 		}
	 		
	 	}
	</style>
</head>

<body>


<?php 
# Show if it is not being veiwed in a popup
if(empty($t)){?>
<!-- First Page -->
<div id="page1" class="fill menu-gap">

	<div class="navbar navbar-fixed-top">
	<?php 
	# Vertical menu content
	$this->load->view('addons/vertical_menu', 
		array('__page'=>'privacy', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel, 'news'=>$menuNewsLable, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel)); 
		
	# Header content
	$this->load->view('addons/header_public', array('__page'=>'privacy', 'signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
	?>
	</div>
	
	<div class="center-block" style="width:100%;">
		<div class="one-column-table">
			<table class="microform ignoreclear">
				<tr>
					<td class="h2 dark-grey" style="text-align:left;"><?php echo $menuVipButtonLabel;?></td>
				</tr>
				<tr>
					<td>
						<div><?php echo $userIDFieldLabel;?>:</div>
						<div>
							<input type="text" id="userIdInput" name="userid" placeholder="<?php echo $userIDFieldHint;?>" >
						</div>
					</td>
				</tr>
				<tr>
				
					<td>
						<div><?php echo $referralUrlLabel;?>:</div>
						<div>
							<input type="text" id="referralUrlInput" name="referralId" class="url" placeholder="<?php echo $referralUrlLabel;?>" >
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div><?php echo $buttonLengthLabel;?>:</div>
						<div class="radio_button_wrapper">
							<div class="col-span" style="white-space:nowrap">
								<table style="border:none;">
									<tr>
										<td id="first_choise">
											<input type="radio" id="radioShort" name="length" value="short" checked ><span>Short</span>
										</td>
										<td>
											<input type="radio" id="radioLong" name="length" value="long" ><span>Long</span>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</td>
				</tr>
				
				<tr>
					<td>
						<div><?php echo $buttonSizeLabel;?>:</div>
						<div class="radio_button_wrapper">
							<div class="col-span" style="white-space:nowrap">
								<table style="border:none;">
									<tr>
										<td id="first_choise">
											<input type="radio" id="radioSmall" name="size" value="small" checked ><span>Small</span>
										</td>
										<td>
											<input type="radio" id="radioNormal" name="size" value="normal" ><span>Normal</span>
										</td>
									</tr>
								</table>
							</div>
							
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div><?php echo $navigationLabel;?>:</div>
						<div class="radio_button_wrapper">
							
							<div class="col-span" style="width:100%; white-space:nowrap">
								<table style="border:none;">
									<tr>
										<td>
											<input type="radio" id="radioPopup" name="navigation" value="popup" checked><span>Pop-up</span>
										</td>
										<td>
											<input type="radio" id="radioRedirect" name="navigation" value="redirectUrl"><span>Redirect</span>
										</td>
										<td id="redirect_url_input" style="display: table-cell; visibility:hidden; white-space:nowrap;">
											<table style="border:none;">
												<tr>
													<td>
														<span> to</span>
													</td>
													<td>
														<input style="width:95%; float: right; margin: 0;" type="text" id="redirectUrl" name="redirectUrl" placeholder="<?php echo $redirectHint;?>" class="url optional">
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</td>
				</tr>
				
				<tr>
					<td>
						<div><?php echo $yourWebsiteLabel;?>:</div>
						<div>
							<input type="text" id="websiteLink" name="website" class="url" placeholder="<?php echo $yourWebsiteLabel;?>">
						</div>
					</td>
				</tr>
				
					
				<tr>
					<td>
						<button id="generatebtn" name="vip_form_btn" class="btn green submitmicrobtn " style="width:100%;"><?php echo $generateButtonLabel;?></button>
						<input type="hidden" id="resultsdiv" name="resultsdiv" value="code_area"/>
						<input type="hidden" id="action" name="action" value="<?php echo base_url();?>page/vip_form" />
					</td>
					
				</tr>
				
				<tr>
					<td style="text-align:left;"><div id="code_area" style="width:100%;"></div></td>
				</tr>
		
			</table>
		</div>
	</div>
</div>
<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>

<?php echo minify_js('page__vip_form', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js'));?>

<?php }?>
<script>
	$('input[name="navigation"]').change(function() {    
	    
	    if($(this).val() == "redirectUrl"){   
	        $('#redirect_url_input').css("visibility","visible");
	        $('#redirect_url_input input').removeClass("optional");
	    }
	    else if($(this).val() == "popup"){
	        $('#redirect_url_input').css("visibility","hidden");
 	        $('#redirect_url_input input').addClass("optional");
	    }

	});
	
</script>

</body>
</html>