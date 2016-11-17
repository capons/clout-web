<!DOCTYPE html>
<html>
  <head>
    <style>
      #map_canvas {
        width: 100%;
        height: 180px;
      }
    
      html, body {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>


 <script>
// This example displays a store marker at the center of the map.
// When the user clicks the marker, an info window opens.
function initialize() {
  var myLatlng = new google.maps.LatLng(<?php echo $location['latitude'];?>, <?php echo $location['longitude'];?>);
  
  var mapOptions = {
    zoom:15,
    center: myLatlng,
	draggable: false
  };

  var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

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

  //Plot the selected marker and show its info window
  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: '<?php echo addslashes(html_entity_decode($name, ENT_QUOTES));?>',
	  icon: markerImage
  });
  
}


google.maps.event.addDomListener(window, 'load', initialize);
</script>
  </head>
  <body><div id="map_canvas"></div></body>
</html>
