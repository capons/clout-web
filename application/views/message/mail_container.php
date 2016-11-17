<table style="width:100%;">
<tr><td style="padding:5px;">
<table class='list-scope microform ignoreclear'>
<tr>
<td style="width:98%;"><input type="text" id="mailsearchphrase" data-type="changes" name="mailsearchphrase" class='optional submit-on-enter' data-targetbtn='mailsearchbtn' placeholder="Search.." style="width:100%;" value=""/>
<input type='hidden' id='resultsdiv' name='resultsdiv' value='mailsearch__1' />
<input type='hidden' id='tempmessage' name='tempmessage' value='Loading results that meet your search criteria..' />
<input type='hidden' id='action' name='action' value='<?php echo base_url()."lists/load/t/mail/n/10";?>' /></td>
<td style="width:1%;"><button id='mailsearchbtn' name='mailsearchbtn' class='btn green submitmicrobtn' style="min-width:50px;">GO</button></td>
<td style="width:1%;"><div id='user_actions' class='actions-list-btn list-actions' data-url='message/list_actions' data-width='300' data-targetdiv='paginationdiv__mailsearch_list'><div>&nbsp;</div><div>&nbsp;</div></div></td>
<td style="width:1%;"><button id="messagefilterbtn" name="messagefilterbtn" class="btn blue hide-on-mobile" style="min-width:80px;">Filter</button></td>
<?php if(check_access($this,'can_send_message')){ ?>
<td style="width:1%;"><button id="messagenewbtn" name="messagenewbtn" class="btn purple shadowpage" data-href='message/add' style="min-width:80px;">New</button></td>
<?php }?>
</tr>

<tr><td colspan='3' style="padding-left:0px;">
<div id='messagefilter' style="display:none;">
<table style="width:100%; border:0">
<tr><td class='row-divs'><div><select id='message__messagetypes' name='message__messagetypes' class='optional drop-down small submit-on-enter' data-targetbtn='mailsearchbtn'><?php echo "<option value=''>Message Type</option>".get_option_list($this, 'messagetypes');?></select></div>
<div><select id='message__level1categories' name='message__level1categories' class='optional drop-down small submit-on-enter' data-targetbtn='mailsearchbtn'><?php echo "<option value=''>Category</option>".get_option_list($this, 'level1categories');?></select></div>
<div><select id='message__cashbackrange' name='message__cashbackrange' class='optional drop-down small submit-on-enter' data-targetbtn='mailsearchbtn'><?php echo "<option value=''>Cash Back Range</option>".get_option_list($this, 'cashbackrange');?></select></div>
<div><input type='text' id='message__placesearch' name='message__placesearch' class='optional searchable drop-down-icon do-not-clear submit-on-enter smalltextfield' data-targetbtn='mailsearchbtn' placeholder="Location" value=''/></div>
</td></tr>
</table>
</div>
</td></tr>

</table>
</td></tr>


<tr><td>
<div id="paginationdiv__mailsearch_list">
<div id="mailsearch__1">
<?php $this->load->view('message/mail_list', array('messageList'=>$messageList)); ?>
</div>
</div>
<div id="mail_details_div" style="display:none;"></div>
</td></tr>

<tr>
<td style="text-align:center;padding:10px;">
          
<div id='mail_pagination_div' class='pagination' style="margin:0px;padding:0px;"><div id="mailsearch" class="paginationdiv no-scroll"><div class="previousbtn" style='display:none;'>&#x25c4;</div><div class="selected">1</div><div class="nextbtn">&#x25ba;</div></div><input name="paginationdiv__mailsearch_action" id="paginationdiv__mailsearch_action" type="hidden" value="<?php echo base_url()."lists/load/t/mail";?>" />
<input name="paginationdiv__mailsearch_maxpages" id="paginationdiv__mailsearch_maxpages" type="hidden" value="<?php echo NUM_OF_LISTS_PER_VIEW;?>" />
<input name="paginationdiv__mailsearch_noperlist" id="paginationdiv__mailsearch_noperlist" type="hidden" value="<?php echo NUM_OF_ROWS_PER_PAGE;?>" />
<input name="paginationdiv__mailsearch_showdiv" id="paginationdiv__mailsearch_showdiv" type="hidden" value="paginationdiv__mailsearch_list" />
<input name="paginationdiv__mailsearch_extrafields" id="paginationdiv__mailsearch_extrafields" type="hidden" value="mailsearchphrase=phrase" /></div>
          
</td>
</tr>
          
          
</table>