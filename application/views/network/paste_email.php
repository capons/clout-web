<?php
echo "<script src='".base_url()."assets/js/jquery-2.1.1.min.js' type='text/javascript'></script>
	  <script type='text/javascript' src='".base_url()."assets/js/clout.js'></script>
	  <script type='text/javascript' src='".base_url()."assets/js/clout.fileform.js'></script>
	  
	  <table class='normal-table microform'>";

if(!empty($msg)) echo "<tr><td>".format_notice($this,$msg)."</td></tr>"; 

echo "<tr><td>Clout will send an invitation for you to each of your contacts</td></tr>
            <tr><td>
            <div class='textfield mocktextfield' style='font-size:16px; width:100%;min-height:150px;'>
   <input name='newemail' type='text' id='newemail' value='' style='border: 0px;margin-bottom:20px;' placeholder='Enter or Paste Email'><input type='hidden' value='' name='emailpastevalues' id='emailpastevalues'>
    </div>
            </td></tr>
          	<tr><td><button id='sendpasteemails' name='sendpasteemails' data-type='internal' class='btn green' style='width:100%;'>Send Invitation</button></td></tr>
</table>";
# Update the invitation count
if(!empty($invitationCount)){
	echo "<script>document.getElementById('my_invite_count').innerHTML='".$invitationCount."';</script>";
}
?>