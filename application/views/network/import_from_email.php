<?php
if(!empty($getDetails)){
	echo "<form id='imapimport' action='".base_url()."network/import_by_imap'  method='post' onsubmit=\"return submitLayerForm('imapimport')\">"; 
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td width='99%'>
		<table width='100%' border='0' cellspacing='0' cellpadding='5'>
		<tr><td style='text-align:left;'><input name='yourpass' type='password' class='textfield' id='yourpass' value='' placeholder='Enter your email password' style='width:100%;'><input type='hidden' name='youremail' id='youremail' value='".$yourEmail."' />
		<br><span class='smalltxt'>*This will take a while to complete importing (maximum of 5 mins).</span></td></tr>";
	
		if(!empty($getHost))
		{				
			echo "<tr><td style='text-align:left;' nowrap><input name='emailhost' type='text' id='emailhost' value='' placeholder='Enter email IMAP or POP server' style='width:calc(100% - 70px);'> : <input name='hostport' type='text' class='textfield' id='hostport' value='' placeholder='Port' style='width:60px;'></td></tr>";
		}
	
	
	echo "</table></td>
		<td width='1%' style='padding:5px;vertical-align: top;'><input type='submit' name='importbtn' id='importbtn' style='width:110px;' class='btn green' value='Import'><input type='hidden' name='imapimport_displaylayer' id='imapimport_displaylayer' value='import_from_email_details'><input type='hidden' name='imapimport_required' id='imapimport_required' value='yourpass".(!empty($getHost)? '<>emailhost<>hostport': '')."'></td>
		</tr></table>
		</form>";

} 


# Simply requesting the email address - FIRST STEP
else {

	echo "<table class='normal-table'>";
	if(!empty($msg)) echo "<tr><td colspan='2'>".format_notice($this,$msg)."</td></tr>"; 
	echo "<tr>
   <td><input id='youremail' name='youremail' class='email' type='text' value='' placeholder='Enter email to import from' style='width:100%;'></td>
   <td style='width:1%;'><button id='startimportfromemail' name='startimportfromemail' class='btn green' style='min-width:100px;max-width:100px;' onClick=\"updateFieldLayer('".base_url()."network/import_by_imap','youremail','','import_from_email_details','Please enter a valid email')\">Start</button></td></tr>
</table>";
 }?>