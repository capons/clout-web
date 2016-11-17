<?php
$shopperIcon = $this->native_session->get('__photo_url')? $this->native_session->get('__photo_url'): BASE_URL.'assets/uploads/public_user_icon.png';

# use default labels if not provided
if(!empty($this->native_session->get('__first_name'))) {
	$menuHeader = $this->native_session->get('__first_name').' '.$this->native_session->get('__last_name');
}
else if(empty($menuHeader)) {
	$menuHeader = 'Welcome!';
}

$menuHomeLabel = !empty($menuHomeLabel)? $menuHomeLabel: 'Home';
$menuBusinessLabel = !empty($menuBusinessLabel)? $menuBusinessLabel: 'Business';
$menuAffiliateLabel = !empty($menuAffiliateLabel)? $menuAffiliateLabel: 'Affiliates';
$menuAgentLabel = !empty($menuAgentLabel)? $menuAgentLabel: 'Agents';
$menuVideoLabel = !empty($menuVideoLabel)? $menuVideoLabel: 'Videos';
$menuContactLabel = !empty($menuContactLabel)? $menuContactLabel: 'Contact';
$menuSignUpLabel = !empty($menuSignUpLabel)? $menuSignUpLabel: 'Sign Up';
$menuLoginLabel = !empty($menuLoginLabel)? $menuLoginLabel: 'Login';
$menuUsingCloutLabel = !empty($menuUsingCloutLabel)? $menuUsingCloutLabel: 'Using Clout As:';
$footerPrivacyLabel = !empty($footerPrivacyLabel)? $footerPrivacyLabel: 'Privacy';
$footerTermsLabel = !empty($footerTermsLabel)? $footerTermsLabel: 'Terms';
$menuBanksLabel = !empty($menuBanksLabel)? $menuBanksLabel: 'Banks';
$menuInvestorLabel = !empty($menuInvestorLabel)? $menuInvestorLabel: 'Investor Relations';

# the user type
$userType = $this->native_session->get('__user_type')? $this->native_session->get('__user_type'): '';


if(in_array($userType, array('clout_owner','clout_admin_user')) && check_access($this))
{
	# Set a default page to show as active if none is specified
	$__page = !empty($__page)? $__page: 'dashboard';
	$__user_name = $this->native_session->get('__first_name').' '.$this->native_session->get('__last_name');
?>
<!-- Admin Menu -->

<div class="menu-details">
<div class="menu-header" data-refdiv="shopper_sub_menu"><div style="background: url(<?php echo BASE_URL."assets/uploads/public_user_icon.png";?>) no-repeat center top;" class="user-photo">&nbsp;</div><div class='clicktoswitch'><?php echo $this->native_session->get('__first_name')."/Clout";?></div></div>


<div class="sub-menu" id="shopper_sub_menu">

<div class="separator"></div>
<div class="sign-out-icon title link active btndiv"  data-url="account/log_out">Sign Out</div>


</div>


<div class="menu-item dashboard-icon<?php if($__page == 'dashboard') echo ' active';?>" data-url="account/admin_dashboard">Dashboard</div>
<div class="menu-item user-admin-icon<?php if($__page == 'shopper_users') echo ' active';?>" data-url="user/shopper_dashboard">Users</div>
<div class="menu-item store-owner-icon<?php if($__page == 'store_owner_users') echo ' active';?>" data-url="user/store_owner_dashboard">Store Owners</div>
<div class="menu-item affiliate-icon<?php if($__page == 'affiliate_admin') echo ' active';?>" data-url="affiliate/home">Affiliates</div>
<div class="menu-item transaction-matching-icon<?php if($__page == 'transaction_matching') echo ' active';?>" data-url="transaction/match_by_each">Transaction Matching</div>
<div class="menu-item money-transfer-icon<?php if($__page == 'money_transfer_admin') echo ' active';?>" data-url="transfer/home">Money Transfers</div>
<div class="menu-item promotion-icon<?php if($__page == 'promotion_admin') echo ' active';?>" data-url="promotion/admin">Promotions</div>
	<div class="menu-item user-admin-icon<?php if($__page == 'customer_home') echo ' active';?>" data-url="customer/home">Customers</div>
<div class="menu-item marketing-icon<?php if($__page == 'marketing_admin') echo ' active';?>" data-url="marketing/home">Marketing</div>
<div class="menu-item data-admin-icon<?php if($__page == 'data_admin') echo ' active';?>" data-url="data/home">Data Administration</div>
<div class="menu-item system-users-icon<?php if($__page == 'admin_users') echo ' active';?>" data-url="user/admin_dashboard">System Users</div>
<div class="menu-item system-settings-icon<?php if($__page == 'system_settings') echo ' active';?>" data-url="setting/dashboard">System Settings</div>
<div class="menu-item admin-systems-icon<?php if($__page == 'admin_systems') echo ' active';?>" data-url="support/admin_systems">Admin Systems</div>
<div class="menu-item message-icon<?php if($__page == 'inbox') echo ' active';?>" data-url="message/home">Inbox <?php echo $this->native_session->get('__unread_count')? '('.$this->native_session->get('__unread_count').')': '';?></div>
<div class="separator"></div>
<div class="title link<?php if($__page == 'contact') echo ' active';?>" data-url="page/contact">Contact</div>

</div>
<?php
}



else if(in_array($userType, array('store_owner_owner','store_owner_admin_user')) && check_access($this))
{
	$__user_name = $this->native_session->get('__first_name').' '.$this->native_session->get('__last_name');
?>
<!-- Store Owner Menu -->

<div class="menu-details">
<div class="menu-header" data-refdiv="shopper_sub_menu"><div style="background: url(<?php echo BASE_URL."assets/uploads/sample_store_1.png";?>) no-repeat center top;" class="user-photo">&nbsp;</div><div class='clicktoswitch'><?php echo $this->native_session->get('__first_name')."/Starbucks..";?></div></div>


<div class="sub-menu" id="shopper_sub_menu">

<div class="separator"></div>
<div class="sign-out-icon title active btndiv"  data-url="account/log_out">Sign Out</div>

</div>


<div class="menu-item customer-home-icon<?php if($__page == 'customer_home') echo ' active';?>" data-url="customer/home">Customers</div>
<div class="menu-item promotion-icon<?php if($__page == 'promotion_home') echo ' active';?>" data-url="promotion/home">Promotions</div>
<div class="menu-item money-home-icon<?php if($__page == 'money_home') echo ' active';?>" data-url="money/home">Money</div>
<div class="menu-item network-home-icon<?php if($__page == 'network_home') echo ' active';?>" data-url="network/home">Network</div>
<div class="menu-item message-icon<?php if($__page == 'inbox') echo ' active';?>" data-url="message/home">Inbox <?php echo $this->native_session->get('__unread_count')? '('.$this->native_session->get('__unread_count').')': '';?></div>

<div class="separator"></div>
<div class="title link<?php if($__page == 'contact') echo ' active';?>" data-url="page/contact">Contact</div>

</div>


<?php
}









# *******************************************************************************
# Shopper menu
# *******************************************************************************

else if(in_array($userType, array('invited_shopper','random_shopper')) && check_access($this,'',array('search','network')) )
{
	# Set a default page to show as active if none is specified
	$__page = !empty($__page)? $__page: 'search_home';
	$__user_name = $this->native_session->get('__first_name').' '.$this->native_session->get('__last_name');
?>
<!-- Shopper Menu -->

<div class="menu-details">
<div class="menu-header" data-refdiv="shopper_sub_menu"><div style="background: url(<?php echo $shopperIcon;?>) no-repeat center top;" class="user-photo">&nbsp;</div><div class='clicktoswitch limited-length' data-minlength='9' data-maxlength='16' data-value='<?php echo $__user_name;?>'><?php echo $__user_name;?></div></div>


<div class="sub-menu" id="shopper_sub_menu">
<div class="sign-out-icon title active btndiv"  data-url="account/log_out">Log Out</div>
</div>


<?php if(check_access($this,'',array('search'))){?><div class="menu-item search-home-icon<?php if($__page == 'search_home') echo ' active';?>" data-url="search/home">Search</div><?php }?>

<?php if(check_access($this,'',array('network'))){?><div class="menu-item network-home-icon<?php if($__page == 'network_home') echo ' active';?>" data-url="network/home">Network</div><?php }?>
<div class="menu-item message-icon<?php if($__page == 'inbox') echo ' active';?>" data-url="message/home">Inbox <?php echo $this->native_session->get('__unread_count')? '('.$this->native_session->get('__unread_count').')': '';?></div>

<div class="separator"></div>
<div class="title link<?php if($__page == 'contact') echo ' active';?>" data-url="page/contact">Contact</div>

</div>

<?php
}


# ********************************************************************************
#  Merchant menu
# ********************************************************************************
else if(in_array($userType, array('clout_merchant')) && check_access($this))
{

	# Set a default page to show as active if none is specified
	$__page = !empty($__page)? $__page: 'search_home';
	$__user_name = $this->native_session->get('__first_name').' '.$this->native_session->get('__last_name');
	?>
	<!-- Shopper Menu -->

	<div class="menu-details">
		<div class="menu-header" data-refdiv="shopper_sub_menu"><div style="background: url(<?php echo $shopperIcon;?>) no-repeat center top;" class="user-photo">&nbsp;</div><div class='clicktoswitch limited-length' data-minlength='9' data-maxlength='16' data-value='<?php echo $__user_name;?>'><?php echo $__user_name;?></div></div>


		<div class="sub-menu" id="shopper_sub_menu">
			<div class="sign-out-icon title active btndiv"  data-url="account/log_out">Log Out</div>
		</div>


		<div class="menu-item search-home-icon<?php if($__page == 'search_home') echo ' active';?>" data-url="search/home">Search</div>

		<div class="menu-item network-home-icon<?php if($__page == 'network_home') echo ' active';?>" data-url="network/home">Network</div>

		<div class="menu-item promotion-icon<?php if($__page == 'promotion_home' || $__page == 'promotion_home') echo ' active';?>" data-url="promotion/home">Promotions</div>
		<div class="menu-item user-admin-icon<?php if($__page == 'customer_home') echo ' active';?>" data-url="customer/home">Customers</div>

		<div class="menu-item message-icon<?php if($__page == 'inbox') echo ' active';?>" data-url="message/home">Inbox <?php echo $this->native_session->get('__unread_count')? '('.$this->native_session->get('__unread_count').')': '';?></div>

		<div class="separator"></div>
		<div class="title link<?php if($__page == 'contact') echo ' active';?>" data-url="page/contact">Contact</div>

	</div>

	<?php
}





# *******************************************************************************
# Public menu
# *******************************************************************************
else
{
	# Set a default page to show as active if none is specified
	$__page = !empty($__page)? $__page: 'home';

?>

<!-- Public Menu -->

<div class="menu-details">

	<div class="menu-header">
		<div><?php echo $menuHeader;?></div>
	</div>
	<div class="menu-item home-icon<?php if($__page == 'home') echo ' active';?>" data-url="page"><?php echo $menuHomeLabel;?></div>
	<div class="menu-item business-icon<?php if($__page == 'business') echo ' active';?>" data-url="page/businesses"><?php echo $menuBusinessLabel;?></div>
	<div class="menu-item affiliate-icon<?php if($__page == 'affiliates') echo ' active';?>" data-url="page/affiliates"><?php echo $menuAffiliateLabel;?></div>
	<div class="menu-item ach-icon<?php if($__page == 'banks') echo ' active';?>" data-url="page/banks"><?php echo $menuBanksLabel;?></div>

	<div class="separator"></div>

	<div class="menu-item<?php if($__page == 'investor') echo ' active';?>" data-url="page/investor"><?php echo $menuInvestorLabel;?></div>
	<div class="menu-item" data-url="page/contact">Contact us</div>

	<?php
	# user is not logged in
	if(!$this->native_session->get('__user_id')){?>
	<div class="buttons-row">
		<div class="login active btndiv" data-url="account/login">Login</div>
		<div class="signup active btndiv" data-url="account/sign_up">Sign Up</div>
	</div>
	<?php }?>

</div>

<?php } ?>
