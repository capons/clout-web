<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": ".$pageTitle;?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen" >
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">
</head>

<body>

<?php echo "<div id='sync_accounts'>";



$institutionName = $this->native_session->get('login_institution')? $this->native_session->get('login_institution'): '';
$institutionCode = $this->native_session->get('login_institution_code')? $this->native_session->get('login_institution_code'): '';
$institutionId = $this->native_session->get('login_institution_id')? $this->native_session->get('login_institution_id'): '';
$institutionLogo = $this->native_session->get('login_institution_logo')? $this->native_session->get('login_institution_logo'): '';


if(!empty($area) && $area == 'mfa_answer')
{
	echo "<table class='normal-table microform'>
		 ".(!empty($institutionLogo)? "<tr><td style='text-align:center;'><img src='".API_S3_URL.$institutionLogo."'></td></tr>": "<tr><td class='h1'>".html_entity_decode($institutionName)."</td></tr>")."
		
		
		
		<tr><td class='h4' style='text-align:left;'><span style='font-weight: bold;'>Answer this question:</span><br>".addslashes($response['mfa'][0]['question'])."</td></tr>
		<tr><td><input name='questionanswer' type='password' class='textfield' id='questionanswer' placeholder='Your Answer' style='width:100%;'></td></tr>
		
		<tr><td style='text-align:center;'><button name='submitanswer' id='submitanswer' class='btn blue secure-btn-icon submitmicrobtn' style='width:100%;'>Submit</button></td></tr>
		<tr><td>
		<table width='100%' border='0' cellpadding='0'  cellspacing='0'>
		<tr><td style='text-align:left;'>This is a secure connection directly to your financial institution. Clout does not store your login. 
<a href='javascript:;' onclick=\"updateFieldLayer('".base_url()."page/link_help','','','connection_faqs_div','');hideLayerSet('sync_accounts');\">For more information, read our FAQ.</a>
		
		<input type='hidden' id='action' name='action' value='".base_url()."account/post_to_bank_api/a/display_question' />
		<input type='hidden' id='redirectaction' name='redirectaction' value='".base_url()."account/load_bank_form' />
		<input type='hidden' id='tempmessage' name='tempmessage' value='Securely sending your bank information..' />
		<input type='hidden' id='errormessage' name='errormessage' value='ERROR: All fields are required except where indicated.' />
		<input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
		
		</td></tr>
		</table>
		</td></tr>
	</table>";












}

else if(!empty($area) && $area == 'choose_code_delivery') 
{
	echo "<table class='normal-table microform'>
		".(!empty($institutionLogo)? "<tr><td colspan='3' style='text-align:center;'><img src='".API_S3_URL.$institutionLogo."'></td></tr>": "<tr><td colspan='3' class='h1'>".html_entity_decode($institutionName, ENT_QUOTES)."</td></tr>")."
		
		<tr><td colspan='3' class='h4' style='text-align:center;'>Choose how to receive your access code:</td></tr>";
	foreach($response['mfa'] AS $receiveOption)
	{
		echo "<tr><td width='1%'><input type='radio' name='receiveoption' id='receive_".$receiveOption['type']."' onclick=\"passFormValue('receive_".$receiveOption['type']."', 'questionanswer', 'radio')\" value='".$receiveOption['type']."'></td><td width='1%'>".ucfirst($receiveOption['type'])."</td><td width='98%'>".$receiveOption['mask']."</td></tr>";
	}
					
	echo "<tr><td style='text-align:center;' colspan='3'><button name='submitanswer' id='submitanswer' class='btn blue secure-btn-icon submitmicrobtn' style='width:100%;'>Submit</button><input type='hidden' name='questionanswer' id='questionanswer' value='email'></td></tr>
		<tr><td colspan='3'>
		<table width='100%' border='0' cellpadding='0'  cellspacing='0'>
		<tr><td style='text-align:left;'>This is a secure connection directly to your financial institution. Clout does not store your login. 
<a href='javascript:;' onclick=\"updateFieldLayer('".base_url()."page/link_help','','','connection_faqs_div','');hideLayerSet('sync_accounts');\">For more information, read our FAQ.</a>
		
		<input type='hidden' id='action' name='action' value='".base_url()."account/post_to_bank_api/a/display_options' />
		<input type='hidden' id='redirectaction' name='redirectaction' value='".base_url()."account/load_bank_form' />
		<input type='hidden' id='tempmessage' name='tempmessage' value='Securely sending your bank information..' />
		<input type='hidden' id='errormessage' name='errormessage' value='ERROR: All fields are required except where indicated.' />
		<input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
		
		</td></tr>
		</table>
		</td></tr>
	</table>";












}

else if(!empty($area) && $area == 'verification_code') 
{
	echo "<table class='normal-table microform'>
		".(!empty($institutionLogo)? "<tr><td style='text-align:center;'><img src='".API_S3_URL.$institutionLogo."'></td></tr>": "<tr><td class='h1'>".html_entity_decode($institutionName)."</td></tr>")."
		
		<tr><td class='h4' style='text-align:center;'>".addslashes($response['mfa']['message'])."</td></tr>
		<tr><td><input name='questionanswer' type='password' class='textfield' id='questionanswer' placeholder='Your Code' style='width:100%;'></td></tr>
		
		<tr><td style='text-align:center;'><button name='submitanswer' id='submitanswer' class='btn blue secure-btn-icon submitmicrobtn' style='width:100%;'>Submit</button></td></tr>
		<tr><td>
		<table width='100%' border='0' cellpadding='0'  cellspacing='0'>
		<tr><td style='text-align:left;'>This is a secure connection directly to your financial institution. Clout does not store your login. 
<a href='javascript:;' onclick=\"updateFieldLayer('".base_url()."page/link_help','','','connection_faqs_div','');hideLayerSet('sync_accounts');\">For more information, read our FAQ.</a>
		
		<input type='hidden' id='action' name='action' value='".base_url()."account/post_to_bank_api/a/display_code' />
		<input type='hidden' id='redirectaction' name='redirectaction' value='".base_url()."account/load_bank_form' />
		<input type='hidden' id='tempmessage' name='tempmessage' value='Securely sending your bank information..' />
		<input type='hidden' id='errormessage' name='errormessage' value='ERROR: All fields are required except where indicated.' />
		<input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
		
		</td></tr>
		
	</table>";











}

else if(!empty($area) && $area == 'user_bank_list') 
{
	echo "<script>
		
		var trigger = window.parent.document.getElementById('iframe_trigger').value;
		var btn = window.parent.document.getElementById(trigger);
		btn.innerHTML = 'Activated';
		btn.classList.remove('green');
		btn.classList.add('blue');
		btn.id = 'activated';
		btn.style.backgroundImage = 'url(".base_url()."assets/images/activated_checkmark.png)';
		btn.style.backgroundRepeat = 'no-repeat';
		btn.style.backgroundPosition = '5% 50%';
		btn.parentNode.style.color = '#333';
		btn.parentNode.style.pointerEvents = 'none';
		window.parent.closeIFrame();
		</script>";

}

else if(!empty($area) && $area == 'login_form') 
{
	echo "<table class='normal-table microform'>
		".(!empty($institutionLogo)? "<tr><td style='text-align:center;'><img src='".API_S3_URL.$institutionLogo."'></td></tr>": "<tr><td class='h1' style='text-align:center;'><b>".html_entity_decode($institutionName)."</b></td></tr>")."
		
		".(!empty($response['resolve'])? "<tr><td>".format_notice($this, "WARNING: ".$response['resolve'])."</td></tr>": "")."
		<tr><td class='h4' style='text-align:center;'>Enter Online Banking Credentials</td></tr>
		<tr><td><input name='username' type='text' class='textfield' autocapitalize='off' autocomplete='off' id='username' placeholder='User Name' style='width:100%;'></td></tr>
		<tr><td><input name='bankpassword' type='password' autocapitalize='off' autocomplete='off' class='textfield' id='bankpassword' placeholder='Password' style='width:100%;'></td></tr>
		
		".($institutionCode == 'usaa'? "<tr><td><input name='bankpin' type='password' class='textfield' autocapitalize='off' autocomplete='off' id='bankpin' placeholder='PIN Number' style='width:100%;'></td></tr>": "")."
		
		<tr><td style='text-align:center;'><button name='banklogin' id='banklogin' class='btn green secure-btn-icon submitmicrobtn' style='width:100%;'>Link Account Securely</button></td></tr>
		<tr><td>
		<table width='100%' border='0' cellpadding='0'  cellspacing='0'>
		<tr><td style='text-align:left;'>This is a secure connection directly to your financial institution. Clout does not store your login. 
<a href='javascript:;' onclick=\"updateFieldLayer('".base_url()."page/link_help','','','connection_faqs_div','');hideLayerSet('sync_accounts');\">For more information, read our FAQ.</a>
		
		<input type='hidden' id='action' name='action' value='".base_url()."account/post_to_bank_api' />
		<input type='hidden' id='redirectaction' name='redirectaction' value='".base_url()."account/load_bank_form' />
		<input type='hidden' id='tempmessage' name='tempmessage' value='Securely sending your bank information..' />
		<input type='hidden' id='errormessage' name='errormessage' value='ERROR: All fields are required except where indicated.' />
		<input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
		
		</td></tr>
		</table>
		</td></tr>
	</table>";
	
}






echo "</div>


<!-- answers to user FAQs -->
<div id='connection_faqs_div'></div>

<input type='hidden' id='layerid' name='layerid' value='' />";

echo minify_js('account__bank_forms', array('jquery-2.1.1.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js',  'clout.shadowbox.js'));?>

</body>
</html>
