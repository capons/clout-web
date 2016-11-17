<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": Admin Systems";?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.list.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">
    <style type="text/css">
		#page1 {
			position: relative;
		}
		
		#container{
			display: flex;
			justify-content: space-around;
		}

		#third-party-div,
		#code-changes-div  {
			width: 45%;
		}
		
		#code-changes-div td {
			border:none;
		}
		.yellow-warning-ribbon {
			background-color: #FFE79B;
			display: flex;
			align-items: center;
		}
		
		#error-icon {
			margin-right: 1.5%;
		}
		
		#flex-row{
			display: flex;
			justify-content: space-between;
			align-items: center;
			flex-wrap: wrap;
			padding: 8px 1%;
		}

		.select-field {
			width: 40%;
			display: flex;
			justify-content: flex-end;
			align-items: center;
		}
		
		.select-field select {
			width: 75%;
			color: black;
		}
		
		.select-field span {
			margin-right: 8px;
		}

		#copytagname,
		#addtag__repos,
		#flex-col,
		#tag-name-input {
			width: 90%;
			color: black;
		}
		
		#tag-name-input {
			display: flex;
			flex-direction: column;
			height: 70px;
		}
		
		#preview {
			margin-left: 1.5%;
		}
		
		#flex-col {
			display: flex;
			flex-direction: column;
			justify-content: space-around;
			width: 100%;
		}
		
		#flex-col iframe {
			background-color: black;
		}
		
		#add-tag-header {
			border-top: 1px solid #CCC;
		}
		
		#addbtn {
			float: right;
		}
		
		@media screen and (min-width:1200px) and (max-width: 1900px){
			
			#container{
				display: flex;
				justify-content: space-around;
			}

		}
		
		@media screen and (max-width: 1200px){
			
			#container{
				display: flex;
				flex-direction: column;
				justify-content: space-around;
				align-items: center;
			}
			
			#third-party-div {
				height: 200px;
			}
			
			#code-changes-div {
				height: 800px;
			}
			
			#third-party-div,
			#code-changes-div  {
				width: 80%;
			}

		}
		
		@media screen and (max-width: 1900px) {
		
			.select-field {
				display: flex;
				flex-direction: column;
				align-items: flex-start;
			}
			.select-field span {
				margin-right: 0px;
			}
			
			#flex-row{
				display: flex;
				justify-content: space-between;
				align-items: flex-end;
			}
			
			#tag-name-input,
			#flex-row select{
				width: 100%;
			}
			
			.btn {
				min-width: 100px;
			}
		}
	</style>
</head>

<body>

<!-- First Page -->
<div id="page1" class="menu-gap">

<div class="navbar navbar-fixed-top">
<?php 
# Vertical menu content
$this->load->view('addons/vertical_menu', array('__page'=>'support', 
	'area'=>($this->native_session->get('__user_type')? $this->native_session->get('__user_type'): 'random_shopper')
)); 
# Header content
$this->load->view('addons/header_admin', array('__page'=>'support', 'title'=>'Admin Systems'));
 
?>
</div>
<div id="container" class="menu-gap">
	
	<div  id="third-party-div" >
		<table class="normal-list-table">
			<thead class="light-grey-bg">
				<tr>
					<th>System</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><a href="https://clout.signin.aws.amazon.com/console" target="_blank">AWS console</a></td>
					<td>Manage Clout AWS Service</td>
				</tr>
				<tr>
					<td><a href="http://rundeck.clout.com" target="_blank">Rundeck</a></td>
					<td>Manage system and environment cronjobs</td>
				</tr>
				<tr>
					<td><a href="http://news.clout.com/wp-admin" target="_blank">Clout News</a></td>
					<td>Manage Clout News wordpress blog</td>
				</tr>
			</tbody>
		</table>
	</div>
<?php if(check_access($this,'can_copy_repository_changes_to_staging') || check_access($this,'can_copy_repository_changes_to_production')
				|| check_access($this,'can_add_repository_tag')){?>	
	<div id="code-changes-div">
		<table class="normal-list-table">
			<thead>
				<tr>
					<th class="yellow-warning-ribbon">
						<img src="../assets/images/error.png" id="error-icon"/>
						<span>Danger Zone! Please be careful when using this area. <br>
						Copying code changes is permanent and may overwrite another team's work.
						</span>
					</th>
				</tr>
			</thead>
	<?php } if(check_access($this,'can_copy_repository_changes_to_staging') || check_access($this,'can_copy_repository_changes_to_production')){?>		
			<thead class="light-grey-bg">
				<tr><th>Move Changes</th></tr>
			</thead>
			<tbody class="microform ignoreclear">
				<tr>
					<td id="flex-row">
						<div class="select-field">
							<span>Copy From:</span>
							<select id="copyfrom__repos"> 
	 							<option value="">Select a Repository</option> 
	 							<?php echo get_option_list($this, 'repos', 'select', 'copy_from'); ?>
	 						</select> 
						</div>
						<div class="select-field">
							<span>Copy To:</span>
							<select id="copyto__repos"> 
	 							<option value="">Select a Repository</option>
	 							<?php echo get_option_list($this, 'repos', 'select', 'copy_to'); ?>
	 						</select> 
						</div>
						<button class="btn green runbtn submitmicrobtn">Run</button>
					</td>
				</tr>
				<tr>
					<td id="flex-row">
						<span>Tag Name:</span>
	 					<select id="copytagname"> 
	 						<option value="">Select a Tag</option> 
	 					</select> 
					</td>
				</tr>
			</tbody>
	<?php } if(check_access($this,'can_add_repository_tag')){?>
			<thead class="light-grey-bg" id="add-tag-header">
				<tr>
					<th>Add Tag To Repo</th>
				</tr>
			</thead>
			<tbody class="microform">
				<tr>
					<td id="flex-row">
						<span>Select Repo:</span>
						<select id="addtag__repos"> 
	 							<option value="">Select a Repository</option>
	 							<?php echo get_option_list($this, 'repos', 'select', 'add_tag'); ?>
	 					</select> 
					</td>
				</tr>
				<tr>
					<td id="flex-row">
						<span>Tag Name:</span>
						<div id="tag-name-input">
							<input type="text" id="addtagname">
							<span id="preview"></span>
						</div>
					</td>
				</tr>
				<tr>
					<td id="addbtn">
						<button class="btn green addbtn submitmicrobtn">Add Tag</button>
					</td>
				</tr>
			</tbody>
	<?php } if(check_access($this,'can_copy_repository_changes_to_staging') || check_access($this,'can_copy_repository_changes_to_production')
					|| check_access($this,'can_add_repository_tag')){?>	
			<thead class="light-grey-bg" id="add-tag-header">
				<tr>
					<th>Result</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div id="flex-col">
							<iframe srcdoc="" src=""></iframe>
						</div>
					</td>
				</tr>
			</tbody>
	<?php } ?>
		</table>
	</div>
</div>
</div>

<div>
<?php $this->load->view('addons/footer_admin'); ?>
</div>

<?php echo minify_js('support__admin_systems', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.menu.js', 'clout.fileform.js'));?>

<script>
$(document).ready(function(){
	$('#addtagname').on("keyup", function(){

		//Revise tag name of user input
		var tmpTagName = $(this).val().replace(/ /g,"-").toLowerCase();
		var date = $.datepicker.formatDate('mmddyy', new Date());
		var finalTagName = "tag-"+date+"-"+tmpTagName;
		
		$('#preview').html(finalTagName);
	});

	//Decide the second drop-down list and tag name drop-down list
	$("#copyfrom__repos").change(function() {

		if ($(this).data('options') == undefined) {
	    	
	    	$(this).data('options', $('#copyto__repos option').clone());
	    }

		var copyFromRepo = $(this).val();
		//Clear previous options
		$("#copytagname").children().not(":first").remove();

		$.ajax({
			url: getBaseURL()+"Support/get_tag_names/",
			data: { copy_from_repo: copyFromRepo},
			type: "get",
			success: function (result) {
				
				$("#copytagname").append(result);
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
	        	showServerSideFadingMessage('ERROR: Something went wrong. Please try again later');
	        }

		});
		var type = copyFromRepo.split("-").pop();
		var root = copyFromRepo.split("-").shift();
		var version = copyFromRepo.replace(type, '').replace(root,'');

		//Decide the second drop-down value
		if( root == "dev") {
			
			var val = "sta"+version+type;
			
		} else if( root == "sta") {
			
			var val = "pro"+version+type;
			
		} else if( root == "test") {

			if( type == "dev") {
				var val = root+"-repo-sta";
			} else if ( type == "sta") {
				var val = root+"-repo-pro";
			}
		}

		$('#copyto__repos').html("<option value='"+ val +"'>"+ val +"</option>");
		
	});

	//Run copy between repos
	$(".runbtn").click(function(){
		if( ($("#copyto__repos").val() != "") && ($("#copyfrom__repos").val() != "") && ($("#copytagname").val() != "")){
			
			var ans = confirm("Are you sure you want to copy these changes? \n"+
					"This overwrites the files in the destination repository and attached server with the changes in the origin repository.");

			if( ans == true) {
				var submitBtn = $(this);
	
				$.ajax({
					url: getBaseURL()+"Support/admin_systems/",
			        data: { copy_from: $("#copyfrom__repos").val(), copy_to: $("#copyto__repos").val(), tag_name: $("#copytagname").val()},
			        type: "post",
			        beforeSend: function() {

			        	var msg = "<p style='color:white; font-family:Lucida Console;'>Running...</p>";
				        $("iframe").prop("srcdoc",msg);
			        	submitBtn.prop("disabled",true).removeClass("green");
			        },
			        success: function (result) {
				        
			        	$("iframe").removeAttr("srcdoc").prop("src",result);
				        submitBtn.prop("disabled",false).addClass("green");
				        
			        },
			        error: function (xhr, ajaxOptions, thrownError) {
			        	showServerSideFadingMessage('ERROR: Something went wrong. Please try again later');
			        }
				});
			}
		}
	});

	//Add tag to repos
	$(".addbtn").click(function(){
		
		if( ($("#addtag__repos").val() != "") && ($("#addtagname").val() != "")){
			
			var submitBtn = $(this);
			
			$.ajax({
				url: getBaseURL()+"Support/admin_systems/",
		        data: { addto: $("#addtag__repos").val(), addtag: $('#preview').html()},
		        type: "post",
		        beforeSend: function() {

		        	var msg = "<p style='color:white; font-family:Lucida Console;'>Running...</p>";
			        $("iframe").prop("srcdoc",msg);
		        	submitBtn.prop("disabled",true).removeClass("green");
		        	
		        },
		        success: function (result) {

		        	$("iframe").removeAttr("srcdoc").prop("src",result);
			        submitBtn.prop("disabled",false).addClass("green");
			        
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		        	showServerSideFadingMessage('ERROR: Something went wrong. Please try again later');
		        }
			});
		}
	});

	//Set default text of the iframe
	var defaultWaitText = "<p style='color:white; font-family:Lucida Console;'>Awaiting command...</p>";
	$("iframe").prop("srcdoc",defaultWaitText);
});

</script>


</body>
</html>