<?php
echo $tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 

echo "<table width='100%' cellpadding='10' border='0' cellspacing='0' class='normal-table'>
<tr><td colspan='2' style='text-align:center;'><span class='h2'>FAQs</span>
<br><span class='h3'>Linking My Cards</span></td></tr>

<tr><td class='bold' style='vertical-align:top;'>1.</td><td class='bold'>Will any of my bank accounts or credit cards ever be charged?</td></tr>
<tr><td>&nbsp;</td><td>NO.  We only deposit money into your accounts, we never take money out -- unless you specifically subscribe to a premium service.</td></tr>

<tr><td class='bold' style='vertical-align:top;'>2.</td><td class='bold'>Is it required sign in to my issuing bank to use Clout?</td></tr>
<tr><td>&nbsp;</td><td>YES.</td></tr>

<tr><td class='bold' style='vertical-align:top;'>3.</td><td class='bold'>Why do you need my user name and password to my issuing bank?</td></tr>
<tr><td>&nbsp;</td><td>We don’t need it, your bank does.  The web form that you sign in through to link your cards is being submitted directly to your bank via a secure third party API.  Once your bank confirms your identity, Clout gets back a security token which allows us to get notifications from your bank when you swipe your card.  It is the only way your bank is able to identify you so Clout rewards can be applied to each of your cards.</td></tr>

<tr><td class='bold' style='vertical-align:top;'>4.</td><td class='bold'>Is Clout safe?</td></tr>
<tr><td>&nbsp;</td><td>YES.  It is safer than making a purchase on an e-commerce site.  E-commerce websites store your credit card numbers, and have the ability to charge transactions to your cards.  Clout doesn’t require you to enter your credit card number.  Clout receives \"read-only\" recipes that do not contain the information that would be needed to bill your cards.</td></tr>

<tr><td colspan='2'><button id='continuelinkingbtn' name='continuelinkingbtn' class='btn blue' onclick=\"".(!empty($f)? "closeShadowBoxInFrame();": "showLayerSet('sync_accounts');hideLayerSet('connection_faqs_div');")."\" style='width:100%;'>Continue to Link Cards</button></td></tr>

</table>";

echo minify_js('page__link_help', array('jquery-2.1.1.min.js', 'clout.js', 'clout.shadowbox.js'));

?>