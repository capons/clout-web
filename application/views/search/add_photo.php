<?php if(empty($msg)) $msg = get_session_msg($this);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITE_TITLE.": Add Photo";?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL;?>favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/external-fonts.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.shadowbox.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.date-picker.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.search.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.list.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.menu.css" type="text/css" media="screen">
</head>

<body>

<table style="width:100%;">

<tr><td>
<div class="microform one-column-table" style="border: #CCC 1px solid; width:99%; max-width:99%;">
<table>
<tr><td class="h2 dark-grey" style="text-align:left;">Add Photo</td></tr>
<tr><td><input type='text' id='photourl' name='photourl' class='filefield' placeholder="Browse to add your photo" value='' data-val='jpg,jpeg,gif,png,tiff' data-size='3000' />
<div class="smalltext">Allowed Formats: JPG, JPEG, GIF, PNG, TIFF  &nbsp;&nbsp;&nbsp;&nbsp; Max Size: 3MB</div>
</td></tr> 
<tr><td><input type='text' id='photocomment' name='photocomment' class='optional' placeholder="Photo Comment (Optional)" style="width:100%;" /></td></tr>
<tr><td style="padding-bottom:0px;"><button type="button" id="submitphoto" name="submitphoto" class="btn blue submitmicrobtn" style="width:100%;">Submit</button>
 
<input type='hidden' id='action' name='action' value='<?php echo base_url().'search/add_photo'.(!empty($storeId)? '/s/'.$storeId: '');?>' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Uploading your photo..' />
<input type='hidden' id='errormessage' name='errormessage' value='ERROR: A photo is required to continue.' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
</td></tr>
</table>
</div>
</td></tr>

</table>

<?php echo minify_js('search__add_photo', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.search.js'));?>
</body>
</html>