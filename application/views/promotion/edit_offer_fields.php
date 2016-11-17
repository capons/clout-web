<?php
// Days/Times
if (empty ( $type ) || $type == 'blackouts') {
	?>


<!-- START TABBED CONTENT -->

<div class="tabContent">
    <!-- START LEFT TABBED CONTENT -->
    <div class="tabLeft" style="line-height: 25px;">
        <input type="checkbox" id="checks" name="date" value="" style="vertical-align:sub;"><span>Date:</span><BR>
        <input type="checkbox" id="checks" name="day" value="" style="vertical-align:sub;"><span>Day:</span><BR>
        <input type="checkbox" id="checks" name="time" value="" style="vertical-align:sub;"><span>Time:</span>       
    </div>
    <!-- START MIDDLE TABBED CONTENT -->
    <div class="tabMiddle">
            <span><input id="blackoutdate" name="blackoutdate" type="text" value="" class="calendartextfield" placeholder="MM / DD / YYYY"></span><BR>
            <span>
            <select class="smallselect" name="filterday" id="filterday">
                <option value="">Day</option>
                <option value="monday">Mondays</option>
                <option value="tuesday">Tuesdays</option>
                <option value="wednesday">Wednesdays</option>
                <option value="thursday">Thursdays</option>
                <option value="friday">Fridays</option>
                <option value="saturday">Saturdays</option>
                <option value="sunday">Sundays</option>
            </select>
            </span><BR><span>
            <select class="smallselect" name="time" id="time">
                <option value="">Time</option>
                <option value="2400">12:00am</option>
                <option value="0100">1:00am</option>
                <option value="0200">2:00am</option>
                <option value="0300">3:00am</option>
                <option value="0400">4:00am</option>
                <option value="0500">5:00am</option>
                <option value="0600">6:00am</option>
                <option value="0800">7:00am</option>
                <option value="0900">8:00am</option>
                <option value="1000">9:00am</option>
                <option value="1100">10:00am</option>
                <option value="1200">11:00am</option>
                <option value="1300">12:00pm</option>
                <option value="1400">1:00pm</option>
                <option value="1500">2:00pm</option>
                <option value="1600">3:00pm</option>
                <option value="1700">4:00pm</option>
                <option value="1800">5:00pm</option>
                <option value="1900">7:00pm</option>
                <option value="2000">8:00pm</option>
                <option value="2100">9:00pm</option>
                <option value="2200">10:00pm</option>
                <option value="2300">11:00pm</option>
            </select> 
            to:
            <select class="smallselect" name="time" id="time">
                <option value="">Time</option>
                <option value="2400">12:00am</option>
                <option value="0100">1:00am</option>
                <option value="0200">2:00am</option>
                <option value="0300">3:00am</option>
                <option value="0400">4:00am</option>
                <option value="0500">5:00am</option>
                <option value="0600">6:00am</option>
                <option value="0800">7:00am</option>
                <option value="0900">8:00am</option>
                <option value="1000">9:00am</option>
                <option value="1100">10:00am</option>
                <option value="1200">11:00am</option>
                <option value="1300">12:00pm</option>
                <option value="1400">1:00pm</option>
                <option value="1500">2:00pm</option>
                <option value="1600">3:00pm</option>
                <option value="1700">4:00pm</option>
                <option value="1800">5:00pm</option>
                <option value="1900">7:00pm</option>
                <option value="2000">8:00pm</option>
                <option value="2100">9:00pm</option>
                <option value="2200">10:00pm</option>
                <option value="2300">11:00pm</option>
            </select>
            </span><BR><span>
                <input id="applychanges" name="applychanges" type="button" value="Apply" class="greenbtn" style="font-size: 12px; padding: 3px 7px 3px 7px; width: 90px; margin-top: 10px;">
            </span>
        
    </div>
    <!-- START RIGHT TABBED CONTENT -->
    <div class="tabRight">
        <span class="customClose red">x</span><span>December 25th, 2015</span>
        <BR>
        <span class="customClose red">x</span><span>October 31st, 2015</span>
    
       
    </div>
</div>
<!-- END TABBED CONTENT -->




<?php
} else if ($type == 'locations') {
	?>
        
        
        
<!-- START TABBED CONTENT -->
<div class="tabContent">
    <!-- START LEFT TABBED CONTENT -->
    <div class="tabLeft">        
        <input type="radio" id="alllocations_yes" name="alllocations[]" value="no" style="vertical-align:sub;" onClick="hideLayerSet('locations_specific')" checked><span>All my stores</span> 
        <input type="radio" id="alllocations_no" name="alllocations[]" value="yes" style="vertical-align:sub; margin-left:15px;" onClick="showLayerSet('locations_specific')"><span>Select specific stores</span>
    </div>
   
    <!-- START HIDDEN CONTENT -->    
    <div id="locations_specific" style="display: none;">
        <!-- START DOWN TABBED CONTENT -->
        <div class="tabDown" style="padding:10px 0 10px 10px;">  
            <span class="formHeader">View locations by:</span> 
            <input type="text" name="locationsearch" id="locationsearch" value="" placeholder="Search in locations" class="searchfield" style="width: 200px; margin-right:15px;">
            
            <span>or select by</span>
            <input type="radio" id="locationsview_all" name="locationsview[]" value="all" style="vertical-align:sub; margin-left:15px;" >All
            <input type="radio" id="locationsview_country" name="locationsview[]" value="country" style="vertical-align:sub; margin-left:15px;" >Country
            <input name="locationsview[]" type="radio" id="locationsview_state" value="state" style="vertical-align:sub; margin-left:15px;" checked>State
            <input type="radio" id="locationsview_city" name="locationsview[]" value="city" style="vertical-align:sub; margin-left:15px;" >City
        </div>
        
        <!-- START DOWN TABBED CONTENT -->
        <div class="tabDown" style="padding:10px 0 8px 0;">
            
            <span class="tabDown" style="display:block; border:none; padding-bottom:0px;">
                <input type="checkbox" id="selectallcheck" name="selectallcheck" value="all" style="vertical-align:sub;" onClick="selectAll(this,'statelist')">Select all       
                <input name="statelist" id="statelist" type="hidden" value="al|ak|il|in|az|ar|ca|co|ct|de|fl|ga|hi|id|ks">
            </span>
	
            <span class="tabDown" style="border:none;">
                <input type="checkbox" id="al" name="states[]" value="AL" style="vertical-align:sub;">Alabama (2)</BR>
                <input type="checkbox" id="ak" name="states[]" value="AK" style="vertical-align:sub;">Alaska (1)</BR>
                <input type="checkbox" id="il" name="states[]" value="IL" style="vertical-align:sub;">Illinois (16)</BR>
                <input type="checkbox" id="in" name="states[]" value="IN" style="vertical-align:sub;">Indiana (3)
            </span>
        
            <span class="tabDown" style="border:none;">
                <input type="checkbox" id="az" name="states[]" value="AZ" style="vertical-align:sub;">Arizona</BR>
                <input type="checkbox" id="ar" name="states[]" value="AR" style="vertical-align:sub;">Arkansas (5)</BR>
                <input name="states[]" type="checkbox" id="ca" value="CA" style="vertical-align:sub;" checked> California (3)</BR>
                <input type="checkbox" id="co" name="states[]" value="CO" style="vertical-align:sub;">Colorado (6)
            </span>
        
            <span class="tabDown" style="border:none;">
                <input type="checkbox" id="ct" name="states[]" value="CT" style="vertical-align:sub;">Connecticut (11)</BR>
                <input type="checkbox" id="de" name="states[]" value="DE" style="vertical-align:sub;">Delaware (2)</BR>
                <input type="checkbox" id="fl" name="states[]" value="FL" style="vertical-align:sub;">Florida (17)</BR>
                <input type="checkbox" id="ga" name="states[]" value="GA" style="vertical-align:sub;">Georgia (9)
            </span>

            <span class="tabDown" style="border:none;">
                <input type="checkbox" id="hi" name="states[]" value="HI" style="vertical-align:sub;">Hawaii (7)</BR>
                <input type="checkbox" id="id" name="states[]" value="ID" style="vertical-align:sub;">Idaho (3)</BR>
                <input type="checkbox" id="ks" name="states[]" value="KS" style="vertical-align:sub;">Kansas (2)    
            </span> 

        </div> 
        
        <!-- START DOWN TABBED CONTENT -->
        <div class="tabDown" style="padding:10px 0 8px 0;"> 
            
            <span class="tabDown" style="display:block; border:none; padding-bottom:0px;">
                <input type="checkbox" id="selectallcheck" name="selectallcheck" value="all" style="vertical-align:sub;" onClick="selectAll(this,'addresslist')">Select all
                <input name="addresslist" id="addresslist" type="hidden" value="address_001|address_002|address_003">
            </span>	

            <span class="tabDown" style="border:none;">
                <input type="checkbox" id="address_001" name="address[]" value="001" style="vertical-align:sub;">125 St. Francis Drive, Los Angeles CA 90035</BR>
                <input type="checkbox" id="address_002" name="address[]" value="002" style="vertical-align:sub;">75 Rodeo Blvd, Beverly Hills CA 90210</BR>										
                <input type="checkbox" id="address_003" name="address[]" value="003" style="vertical-align:sub;">575 San Vicente Blvd, Los Angeles CA 90036
            </span>

        </div>
    
									  
        
    </div>
    <!-- END HIDDEN CONTENT -->  
</div>
<!-- END TABBED CONTENT -->   
       



        
<?php 
}
#Run Time 
else if($type == 'runtime')
{
?>

<!-- START TABBED CONTENT -->

<div class="tabContent">
    <!-- START MID TABBED CONTENT -->
    <div class="tabMiddle" style="margin-left:10px;">
            <span class="formHeader">Start date:</span><BR>        
            <input type="radio" id="startdatecheck_yes" name="startdatecheck[]" value="yes" style="vertical-align:sub;" checked><span>When I publish</span><BR>        
            <input type="radio" id="startdatecheck_no" name="startdatecheck[]" value="no" style="vertical-align:sub;">
            <span><input id="blackoutdate" name="startdate" type="text" value="" class="calendartextfield" placeholder="MM / DD / YYYY"></span><BR>     
    </div>
    <div class="tabMiddle">
            <span class="formHeader">End date:</span><BR>         
            <input type="radio" id="enddatecheck_yes" name="enddatecheck[]" value="" style="vertical-align:sub;" checked><span>When I delete</span><BR>        
            <input type="radio" id="enddatecheck_no" name="enddatecheck[]" value="" style="vertical-align:sub;">
            <span><input id="blackoutdate" name="startdate" type="text" value="" class="calendartextfield" placeholder="MM / DD / YYYY"></span><BR> 
    </div>
    <div class="tabRight">
            <span class="formHeader">Max promotional spend:</span><BR>
            <input type="radio" id="spendcheck" name="spendcheck[]" value="" style="vertical-align:sub;" checked><span>No Max</span><BR> 
            <input type="radio" id="spendcheck" name="spendcheck[]" value="" style="vertical-align:sub;"><span>100k</span><BR>        
            <input type="radio" id="spendcheck" name="spendcheck[]" value="" style="vertical-align:sub;"><span>50k</span>
    </div>     
</div> 

    
        
        
        
        
<?php 
}
#Run Time 
else if($type == 'qrcode')
{
?>

<!-- START TABBED CONTENT -->

<div class="tabContent">
  <!-- START LEFT TABBED CONTENT -->
    <div class="tabLeft" style="line-height: 23px;">
        <span class="formHeader">Email Address:</span><BR>
        <span class="formHeader">Data Type:</span><BR>
        <span class="formHeader">Website URL:</span>
    </div>
    <!-- START MIDDLE TABBED CONTENT -->
    <div class="tabMiddle">
        <span><input type="text" name="locationsearch" id="email" value="" placeholder="name@company.com" class="" style="width: 200px; margin-right:15px;"></span>
        <BR><span>
            <input type="radio" id="" name="" value="web"   style="vertical-align:sub;" >Web
            <input type="radio" id="" name="" value="phone" style="vertical-align:sub; margin-left:15px;" >Phone#
            <input type="radio" id="" name="" value="sms"   style="vertical-align:sub; margin-left:15px;" checked>SMS
            <input type="radio" id="" name="" value="text"  style="vertical-align:sub; margin-left:15px;" >Plain Text
        </span>
        <BR><span><input type="text" name="" id="web" value="" placeholder="http://www.clout.com" class="" style="width: 200px; margin-right:15px;"></span>
        <BR><span><input id="applychanges" name="applychanges" type="button" value="Generate" class="greenbtn" style="font-size: 12px; padding: 3px 7px 3px 7px; width: 90px; margin-top: 10px;"></span>
        
    </div>
    <!-- START RIGHT TABBED CONTENT -->
    <div class="tabRight" >
        <span><img style="float:left;" src="../assets/images/qr_code.png" width="120px" height="120px"></span>    
    </div>  
     <div class="tabRight">
        <span>
            JPG  |  <a href="">EPS</a>  |  <a href="">SVG</a> 
            <BR><input id="applychanges" name="applychanges" type="button" value="Download" class="greenbtn" style="font-size: 12px; padding: 3px 7px 3px 7px; width: 90px; margin-top: 10px; margin-bottom: 10px; ">
           <BR><a href="">Embed QR Code</a>
        </span>   
    </div> 
</div> 
   
    
    
        
        
        
        

<?php 
}
else
{
	echo format_notice('ERROR: Fields are not yet set.');
}
?>