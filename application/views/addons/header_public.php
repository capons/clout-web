<div class="menu-icon">&nbsp;</div>
<div class="logo">&nbsp;</div>

<?php
# user is not logged in
if(!$this->native_session->get('__user_id'))
{

if(!(!empty($__page) && $__page=='login')) {?>
<div class="secure-icon show-on-tablet show-on-mobile btndiv" id="loginbtn" data-url="account/login">Login</div>
<?php }?>

<div class="top-left-btns">
<?php if(!(!empty($__page) && $__page=='signup')) {?>
<button id="signupbtn" name="signupbtn" data-url="account/sign_up"><?php echo $signup;?></button>
<?php }?>

<?php if(!(!empty($__page) && $__page=='login')) {?>
<button id="loginbtn" name="loginbtn" data-url="account/login"><?php echo $login;?></button>
<?php }?>


</div>
<?php }



# user is logged in
else { ?>
<div class="top-left-btns">
<button id="logoutbtn" name="logoutbtn" data-url="account/log_out">Logout</button>
</div>
<?php }?>
