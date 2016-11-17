<?php if(empty($msg)) $msg = get_session_msg($this);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo SITE_TITLE.": Add Review";?></title>
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

<tr><td style="text-align:center;">
<div id='review_count_div'><?php echo "<table class='review-table'>
<tr>
<td><div class='review-container fill-".(!empty($c)? $c: '0')."'><div></div><div></div></div></td>
<td>".(!empty($r)? $r: '0')." Review".(!empty($r) && $r == 1? '': 's')."</td>
</tr>
</table>";?></div></td></tr>


<?php 
if(empty($a)){?>
<tr><td>
<div class="microform one-column-table" style="border: #CCC 1px solid; width:99%; max-width:99%;">
<table>
<tr><td class="h2 dark-grey" style="text-align:left;">Add Review</td></tr>
<tr><td><select id='review__reviewgrades' name='review__reviewgrades' class='drop-down'><?php echo get_option_list($this, 'reviewgrades','select','',array('selected'=>(!empty($reviewDetails['score'])? $reviewDetails['score']: '') ));?></select></td></tr>
<tr><td><textarea id='reviewdetails' name='reviewdetails' class='optional' placeholder="Review Details (Optional)" style="width:100%;"><?php echo (!empty($reviewDetails['details'])? html_entity_decode($reviewDetails['details'],ENT_QUOTES): ''); ?></textarea></td></tr>
<tr><td style="padding-bottom:0px;"><button type="button" id="submitreview" name="submitreview" class="btn blue submitmicrobtn" style="width:100%;">Submit</button>

<?php echo (!empty($reviewDetails['score'])? "<input type='hidden' id='previousscore' name='previousscore' value='".$reviewDetails['score']."' />": '');?>
<input type='hidden' id='action' name='action' value='<?php echo base_url().'search/add_review'.(!empty($storeId)? '/s/'.$storeId: '').(!empty($r)? '/r/'.$r: '').(!empty($c)? '/c/'.$c: '');?>' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Submitting your review..' />
<input type='hidden' id='errormessage' name='errormessage' value='ERROR: Your review score is required to continue.' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='review_list_div' />
</td></tr>
</table>
</div>
</td></tr>
<?php }?>


<tr><td><div id='review_list_div'><?php $this->load->view('search/review_list', array('reviews'=>$reviews)); ?></div></td></tr>

</table>

<?php echo minify_js('search__add_review', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.search.js'));?>
</body>
</html>