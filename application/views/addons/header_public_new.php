<div class="intro__buttons">
<?php
# user is not logged in
if(!$this->native_session->get('__user_id'))
{?>

<?php if(!(!empty($__page) && $__page=='signup')) {?>
<a href="<?php echo base_url();?>account/sign_up" class="btn__hollow"><?php echo $signup;?></a>
<?php }?>

<?php if(!(!empty($__page) && $__page=='login')) {?>
<a href="<?php echo base_url();?>account/login" class="btn__hollow btndiv" id="loginbtn">Login</a>
<?php }?>

<?php }


# user is logged in
else { ?>
  <a href="<?php echo base_url();?>account/log_out" id="logoutbtn" class="btn__hollow">Logout</a>
<?php }?>

</div>
