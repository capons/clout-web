<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.list.css" type="text/css" media="screen" />
</head>
<body <?php if(empty($r) && !empty($service) && $service == 'GMAIL') {?> onLoad="document.location.href='https://www.google.com/accounts/OAuthAuthorizeToken?oauth_token=<?php echo $oauth->rfc3986_decode($accessToken['oauth_token']);?>'" <?php }?>>		
<?php 
#

/**********************************************************
 * This file obtains and processes email provider contacts
 **********************************************************/

#Process the response
if(!empty($r))
{
	$inPageForms = array('import_from_email', 'import_from_file', 'paste_email');
		
	echo "<form ";
		#Add this section to not redirect the page if some one submits
		if(in_array($r,$inPageForms))
		{
			echo " action='".base_url()."network/send_invitations/r/".$r."/t/internal' method='post'  id='".$r."_sendform' onsubmit=\"return submitLayerForm('".$r."_sendform')\"";
		}
		else 
		{
			echo " action='".base_url()."network/send_invitations' method='post' ";
		}
		
		echo "><table width='100%'> 
		<tr>
		<td width='99%' style='text-align:left;padding-top:0px;'><span class='h3'>Your ".(!empty($service)? $service: '')." Contacts</span><br>
Select contacts and click the Send button to send an invitation
</td>
		<td width='1%' valign='top' style='padding:5px;'><button type='submit' name='send_invitations' id='send_invitations' class='btn purple' style='width:90px;'>Send</button>";
		
		#Add this section to not redirect the page if some one submits
		if(in_array($r,$inPageForms))
		{
			echo "<input type='hidden' name='".$r."_sendform_displaylayer' id='".$r."_sendform_displaylayer' value='".$r."_details'>";
		}
		
		
		echo "</td>
		</tr>
		
		<tr><td colspan='2'>
		<div style='max-height:450px; overflow:auto;'>
		<table  border='0' cellspacing='0' cellpadding='3 width='100%'  class='normal-list-table' style='border-left: solid 1px #E0E0E0;border-bottom: solid 1px #E0E0E0;'>
		<tr style='background-color:#F2F2F2;'><td width='1%'><input type='checkbox' id='selectallcheck' name='selectallcheck' value='allcontacts' class='bigcheckbox' checked/><label for='selectallcheck'></label></td><td  width='".(($r != 'paste_email')?"1%":"99%")."' style='font-weight:bold;'>Email</td><td style='font-weight:bold;'>".($r != 'paste_email'? "Name": '')."</td></tr>";
		foreach($finalContactsList AS $key=>$contact)
		{
			echo "<tr><td>";
			if(empty($contact['last_invitation_sent_on']) || (!empty($contact['can_send']) && $contact['can_send'] == 'YES'))
			{
				echo "<input type='checkbox' id='".$key."_c' class='bigcheckbox' name='contacts[]' value='".$contact['email_address']."' checked/><label for='".$key."_c'></label>";
			}
			else
			{
				echo "&nbsp;";
			}
			
			echo "</td><td>".$contact['email_address']."</td>";
			echo "<td nowrap>".($r != 'paste_email'? $contact['name']: "")."</td>
			</tr>";
		}
	
	echo "</table>
		</div>
		</td></tr>
		</table>
		</form>";

	
}
#Getting the contacts
else
{
	echo "<img src='".base_url()."assets/images/loading.gif' border='0'/>";
}
?>

<?php echo minify_js('network__invite_contacts', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.list.js'));?>

</body>
</html>