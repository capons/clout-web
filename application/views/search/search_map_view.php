<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Google Map View</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />

	<style>
html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
}
	  
	  
.locationbubble {
	background: url(<?php echo base_url();?>assets/images/green_location_bubble.png) no-repeat center center; 
	font-weight:bold; 
	color:#FFF; 
	font-size:18px; 
	width:15px; 
	text-align:center; 
	padding: 5px 10px 10px 10px; 
	vertical-align:text-top;
}


#numbercell {
	background-color:#2DA0D1; 
	color:#FFF;
}

#numbercell div {
	width:70px; 
	height:50px; 
	text-align:center;
}

#numbercell div #bignumber {
	font-family: 'Roboto', sans-serif;
    -webkit-font-smoothing: antialiased;
	font-size:24px; 
	font-weight:600; 
}


#numbercell div #smallnumber {
	font-size:10px; 
	font-weight:bold;
}



.noncurrentcell {
	 padding: 10px 10px 0px 10px; 
}


.noncurrentcell #contenttable {
	border: 1px solid #CCC;
	background-color:#FFF;
}



.noncurrentcell #numbercell div {
	width:70px; 
	height:50px; 
	text-align:center;
}

.noncurrentcell #numbercell div #bignumber {
	font-family: 'Roboto', sans-serif;
    -webkit-font-smoothing: antialiased;
	font-size:24px; 
	font-weight:600;
}


.noncurrentcell #numbercell div #smallnumber {
	font-size:10px; 
	font-weight:bold;
}



.currentcell {
	padding: 0px; 
	border-left: 10px solid #333;
	border-top: 1px solid #CCC;
	border-bottom: 1px solid #CCC; 
	background-color:#FFF; 
	margin-right: -2px; 
	margin-top:10px;
	vertical-align:top;
	width:99%;
}

 
.currentcell #contenttable {
	border: 0px;
	cursor:pointer;
}

.clicktoviewdetails {
	cursor:pointer;
}



.rewardcard {
	background-color:#2DA0D1;
	border-radius: 3px 3px 3px 3px;
	/*-moz-border-radius: 3px 3px 3px 3px;*/
	-webkit-border-top-left-radius: 3px;
	-webkit-border-top-right-radius: 3px;
	-webkit-border-bottom-left-radius: 3px;
	-webkit-border-bottom-right-radius: 3px;
	width:45px;
}

.rewardcard .toprow {
	font-size:2px; 
	padding:0px; 
	height:5px;
}

.rewardcard .bottomrow {
	border-top: 4px solid #FFF; 
	color:#FFF; 
	font-weight:700; 
	text-align:center;
	font-size: 12px;
	min-width:45px;
}


.rewardcardbig .toprow {
	font-size:2px; 
	padding:0px; 
	height:8px;
}

.rewardcardbig .bottomrow {
	border-top: 8px solid #FFF; 
	color:#FFF; 
	font-size:18px;
	font-weight:700; 
	text-align:center;
}

.rewardcardbig .editbottomrow {
	border-top: 8px solid #FFF; 
	color:#FFF; 
	font-size:18px;
	font-weight:700; 
	text-align:center;
	padding-right: 15px;
	cursor:pointer;
	background: url(../../assets/images/pencil_icon.png) no-repeat center right;
}

.perkcard {
	background-color:#333333;
	border-radius: 3px 3px 3px 3px;
	/*-moz-border-radius: 3px 3px 3px 3px;*/
	-webkit-border-top-left-radius: 3px;
	-webkit-border-top-right-radius: 3px;
	-webkit-border-bottom-left-radius: 3px;
	-webkit-border-bottom-right-radius: 3px;
	width:45px;
}

.perkcard .toprow {
	font-size:2px; 
	padding:0px; 
	height:5px;
}

.perkcard .bottomrow {
	border-top: 4px solid #FFF; 
	color:#FFF; 
	font-weight:700; 
	text-align:center;
	font-size: 12px;
	min-width:45px;
}


    </style>
</head>






<body>
    <div id="map-canvas"></div>



<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<?php echo minify_js('search__search_map_view', array('jquery-2.1.1.min.js', 'clout.js', 'clout.search.js'));?>
<script>
function newPopup(url, width, height) 
{
    var left = (screen.width/2)-(width/2);
  	var top = (screen.height/2)-(height/2);
  
	popupWindow = window.open(
url,'popUpWindow','height='+height+',width='+width+',left='+left+',top='+top+',resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
}

// This example displays a marker at the center of Australia.
// When the user clicks the marker, an info window opens.
function initialize() {
  // Origins, anchor positions and coordinates of the marker
  // increase in the X direction to the right and in
  // the Y direction down.
  var markerImage = {
    url: '<?php echo base_url();?>assets/images/map_marker.png',
    // This marker is 43 pixels wide by 54 pixels tall.
    size: new google.maps.Size(43, 54),
    // The origin for this image is 0,0.
    origin: new google.maps.Point(0,0),
    // The anchor for this image is the base of the marker at 0,40.
    anchor: new google.maps.Point(0, 40)
  };
  
  //Sample restaurant marker array
  //Place format is Array(RESTAURANT_NAME, LATITUDE, LONGITUDE, PLACE_TIP_CONTENT)
  var searchPlaces = new Array();
  
  //Pop up content string
  var contentString = new Array();

<?php
$searchResults = $this->native_session->get('search_results')? $this->native_session->get('search_results'): array();
$defaultStoreId = $this->native_session->get('current_viewed_store')? $this->native_session->get('current_viewed_store'): '';

if(!empty($searchResults))
{
	$i=0;
	$alphabetCounter = 'A';
	$validResults = array();
	
 	foreach($searchResults AS $row) 
  	{
  		if(!empty($row['latitude']) && !empty($row['longitude']))
		{
			echo "\ncontentString[".$i."] = '<div id=\"content\" style=\"min-width: 300px;\">'+
      '<div id=\"siteNotice\">'+
      '</div>'+
      '<div id=\"bodyContent\" style=\"height:140px;padding-top:3px;\">'+
      '<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"  id=\"contenttable\">'+
      '<tr>'+
      '<td id=\"numbercell\" width=\"1%\" style=\"padding-bottom:5px;\"><div><span id=\"bignumber\">".(!empty($row['store_score'])? format_number($row['store_score'],5,0): 0)."</span><br><span id=\"smallnumber\"  nowrap>Store Score</span></div></td>'+
      '<td style=\"padding:0px;margin:0px;\"><div class=\"locationbubble\">".$alphabetCounter."</div></td>'+
      '<td width=\"98%\" valign=\"top\" style=\"padding:10px 10px 0px 0px;\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
      '<tr>'+
      '<td class=\"title\" width=\"99%\" style=\"font-weight:bold;\">".addslashes(html_entity_decode($row['name']))."</td>'+
      '<td style=\"padding-left:3px;padding-right:3px;\"><img src=\"".base_url()."assets/images/small_favorite_icon.png\"></td>'+
      '<td>".(!empty($row['distance'])? format_number($row['distance'],4,1): 0)."mi</td>'+
      '</tr>'+
      
      '</table></td>'+
      '</tr>'+
      '<tr>'+
      '<td colspan=\"3\" style=\"padding:10px 10px 0px 0px;\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">'+
      '<tr>'+
      '<td width=\"98%\">".(!empty($row['search_category'])?  html_entity_decode($row['search_category'], ENT_QUOTES): "&nbsp;")."</td>'+".
	  (!empty($row['max_cashback'])? "'<td style=\"padding-left:0px;\" width=\"1%\">'+
      '<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" class=\"rewardcard\"><tr><td class=\"toprow\"></td></tr><tr><td class=\"bottomrow\" nowrap>".($row['min_cashback'] == $row['max_cashback']? format_number($row['max_cashback'],3,0): format_number($row['min_cashback'],3,0)."-".format_number($row['max_cashback'],3,0))."%</td></tr></table>'+
      '</td>'+": "").((!empty($row['has_perk']) && $row['has_perk']=='Y')? "
      '<td style=\"padding-left:3px;padding-right:0px;\" width=\"1%\">'+
      '<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" class=\"perkcard\"><tr><td class=\"toprow\"></td></tr><tr><td class=\"bottomrow\" nowrap>Perk</td></tr></table>'+
      '</td>'+": "")."
      '</tr>'+
      '</table>'+
      '</td>'+
      '</tr>'+
	  '<tr>'+
      '<td colspan=\"3\" style=\"padding:5px 5px 0px 0px;\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">'+
      '<tr>'+
      '<td>".(!empty($row['address_line_1'])?"<a href=\"javascript:;\" onClick=\"newPopup(\'".base_url()."search/map_to_location/a/".encrypt_value($row['address_line_1'].' '.$row['address_line_2'].', '.$row['city'].', '.$row['state'].' '.$row['zipcode'])."\',\'700\',\'500\')\"  class=\"bluebold\" style=\"font-weight:bold;\">Directions to here</a>": "&nbsp;")."</td>'+
      '<td align=\"right\"><a href=\"javascript:;\" onClick=\"loadSearchDetails(\'".format_id($row['store_id'])."\', window.parent.document)\" class=\"bluebold\" style=\"font-weight:bold;\">More</a></td>'+
      '</tr>'+
      '</table>'+
      '</td>'+
      '</tr>'+
      '</table>'+
      '</div>'+
      '</div>';";


			echo "\nsearchPlaces[".$i."] = new Array('".addslashes(html_entity_decode($row['name'], ENT_QUOTES))."', ".$row['latitude'].", ".$row['longitude'].", contentString[".$i."]);";  
			$validResults[$i] = $row;
			
			#If you have a default store ID, watch out for it and get the default store
			if(!empty($defaultStoreId) && $row['store_id'] == $defaultStoreId) 
			{
				$defaultStore = $row;
				$defaultCount = $i;
			}
			$alphabetCounter++;
			$i++;
		}
  	}
	$totalSuggested = $i;
}


if(!empty($defaultStore) || !empty($validResults[0]))
{
	$defaultStore = !empty($defaultStore)? $defaultStore: $validResults[0];
	$defaultCount = !empty($defaultCount)? $defaultCount: 0;
	
echo "\nvar myLatlng = new google.maps.LatLng(".$defaultStore['latitude'].", ".$defaultStore['longitude'].");
  var mapOptions = {
    zoom: 12,
    center: myLatlng
  };

  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  
  var infowindow = new google.maps.InfoWindow({
      content: contentString[".$defaultCount."],
	  maxWidth: 300,
	  pixelOffset: 0
  });
  

  //Plot the selected marker and show its info window
 var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: '".addslashes(html_entity_decode($defaultStore['name'], ENT_QUOTES))."',
	  icon: markerImage
  });
  
  
  //Show marker and content window open the first time
  infowindow.open(map,marker);
  
  //Also add a listener on click in case the user closed it
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });
  
  ";
}
?>
  
  //Now plot all other markers but do not open them
  for(var i=0; i<searchPlaces.length; i++)
  {
     var otherMarker = plotMarker(map, markerImage, searchPlaces[i][1], searchPlaces[i][2], searchPlaces[i][0]);
	 createInfoWindow(map, otherMarker, searchPlaces[i][3]);
  }
  
}


//To plot additional markers onto the map
function plotMarker(map, markerImage, lat, long, title) {
  var marker = new google.maps.Marker({
     position: new google.maps.LatLng(lat, long),
	 map: map,
     title: title,
	 icon: markerImage
  });
  return marker;
}


//To add info windows for the markers
function createInfoWindow(map, marker, popupContent) {
    var infowindow = new google.maps.InfoWindow({
      content: popupContent,
	  maxWidth: 300,
	  minWidth: 300
  	});
	
	google.maps.event.addListener(marker, 'click', function () {
		// Close any open infowindows
	  	if($('.gm-style-iw').length) {
	         $('.gm-style-iw').parent().remove();
	    }
	    
	    infowindow.open(map, marker);
    });
}

//Start the google map event listener
google.maps.event.addDomListener(window, 'load', initialize);




// Go to a store's details
function loadSearchDetails(storeId){
	$('.map-view-icon', window.parent.document).removeClass('make-list');
	window.parent.document.location.href = getBaseURL()+'search/store/id/'+storeId;
}



</script>
  </body>
</html>

