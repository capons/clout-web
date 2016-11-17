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

		#title {
			margin-bottom: 3px;
		}

		#message {
			display: flex;
			flex-direction: column;
			align-items: center;
			align-content: center;
			justify-content: space-between;
			height: 180px;
		}

		#message-main,
		#message-steps {
			display: flex;
			justify-content: space-around;
			flex-wrap: wrap;
			font-weight: 200;
			font-size: 15px;
		}

		#message-sub {
			width: 100%;
			font-weight: 400;
			fon-size: 18px;
		}

		#message-perks {
			margin: 0px 0px 10px 0px ;
			font-weight: 400;
			font-size: 20px;
		}

 		.textfield {
 			float: left;
 			width: 100%;
 			transition-property: width;
			transition-duration:1s;
			transition-timing-function: ease-out;

 		}

 		.one-column-table table td div:first-child{
			float: left;
			width: 100%;
		}

		#addbtn {
			float: left;
		}

		.submitmicrobtn {
			width: 70%;
		}

		.activate-btn-div {
			position: relative;
			width: 0px;
			overflow: hidden;
			opacity: 0;
			transition-property: width, opacity;
			transition-duration:1s;
			transition-timing-function: ease-out;
		}
		.activate-btn-div a{
			color: black;
			width: 0px;
		}

		#addBtnRow > td {
			padding-top: 0;
		}

		#addBtnRow a {
			cursor: pointer;
		}

		@media only screen and (max-width: 700px){
			#activate-btn-div {
				display: inline;
				width: 0px;
			}

			#message {
				height: 100%;
			}
		}

	</style>
</head>

<body>

<?php
# Show if it is not being veiwed in a popup
if(empty($t)){?>
<!-- First Page -->
<div id="page1" class="menu-gap">

	<div class="navbar navbar-fixed-top">
	<?php
	# Vertical menu content
	$this->load->view('addons/vertical_menu',
		array('__page'=>'privacy', 'header'=>$menuHeader, 'home'=>$menuHomeLabel, 'business'=>$menuBusinessLabel, 'affiliates'=>$menuAffiliateLabel, 'agents'=>$menuAgentLabel, 'news'=>$menuNewsLable, 'signup'=>$menuSignUpLabel, 'login'=>$menuLoginLabel, 'usingCloutAs'=>$menuUsingCloutLabel, 'userLabel'=>$menuUserLabel));

	# Header content
	$this->load->view('addons/header_public', array('__page'=>'privacy', 'signup'=>$signUpBtnLabel, 'login'=>$loginBtnLabel));
	?>
	</div>

	<div class="center-block menu-gap" style="width:100%;">
		<div id="title" class="h2"><?php echo $title;?></div>

		<div id="message">
			<div id="message-main"><?php echo $messageMain;?></div>
			<div id="message-sub">
				<div><?php echo $messageSub;?></div>
				<div id="message-steps">
					<img src="<?php echo base_url();?>assets/images/bank_registration_steps.png" />
				</div>
			</div>
			<div id="message-perks" class="h2"><?php echo $messagePerksFlyIn;?></div>
		</div>

		<div class="one-column-table">
			<table class="microform ignoreclear">

				<tr id="row1">
					<td>
						<div>
							<input type="text" id="1_bankname__banks" class="textfield searchable do-not-clear" placeholder="<?php echo $placeholderLabel;?>" >
							<div id="activate-btn-div" class="activate-btn-div">
								<a href="" class="bankLink shadowbox"><button id="activate1" class="btn activateBtn">Activate</button></a>
							</div>
						</div>

					</td>
				</tr>
				<tr id="row2">
					<td>
						<div>
							<input type="text" id="2_bankname__banks" class="textfield searchable do-not-clear optional" placeholder="<?php echo $placeholderLabelOptional;?>" >

							<div id="activate-btn-div" class="activate-btn-div">
								<a href="" class="bankLink shadowbox"><button id="activate2" class="btn activateBtn">Activate</button></a>
							</div>
						</div>
					</td>
				</tr>
				<tr id="row3">
					<td>
						<div>
							<input type="text" id="3_bankname__banks" class="textfield searchable do-not-clear optional" placeholder="<?php echo $placeholderLabelOptional;?>" >

							<div id="activate-btn-div" class="activate-btn-div">
								<a href="" class="bankLink shadowbox"><button id="activate3" class="btn activateBtn">Activate</button></a>
							</div>
						</div>
					</td>
				</tr>
				<tr id="row4">
					<td>
						<div>
							<input type="text" id="4_bankname__banks" class="textfield searchable do-not-clear optional" placeholder="<?php echo $placeholderLabelOptional;?>" >

							<div id="activate-btn-div" class="activate-btn-div">
								<a href="" class="bankLink shadowbox"><button id="activate4" class="btn activateBtn">Activate</button></a>
							</div>
						</div>
					</td>
				</tr>
				<tr id="addBtnRow">
					<td>
						<div>
							<a id="addbtn">Add another bank</a>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div>
							<button id="submitbtn" name="submit_btn" class="btn green submitmicrobtn"><?php echo $submitButtonLabel;?></button>
							<input type="hidden" id="iframe_trigger" name="iframe_trigger" value="" >
							<input type="hidden" id="action" name="action" value="<?php echo base_url();?>account/list_banks" >
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div>
<?php $this->load->view('addons/footer_public'); ?>
</div>
<script type="text/javascript" src="https://www.clout.com/assets/js/clout.googleanalytics.js"></script>
<?php echo minify_js('account__list_banks', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js', 'clout.shadowbox.js', 'clout.fileform.bank.js'));?>

<?php }?>

</body>
</html>
