<?php if(!defined('IN_AWEBCOM'))die('Access Denied'); ?><script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
  var map;
  var overlay;
  var marker;
  var infowindow;
  function initialize() {
    var opts = {
      zoom: 14,
  //<?php echo $mappoint;?> - User map
      center: new google.maps.LatLng(<?php echo $mappoint;?>),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map"), opts);

var image = new google.maps.MarkerImage('templates/<?php echo $CFG['tplname'];?>/images/icons/icon-custom-marker.png',
 new google.maps.Size(33, 46),
 new google.maps.Point(0,0),
 new google.maps.Point(16, 44)
);

marker = new google.maps.Marker({
 position: new google.maps.LatLng(<?php echo $mappoint;?>),
 map: map,
 //title: '<?php echo $title;?>',
 icon: image
});

infowindow = new google.maps.InfoWindow({
 content: '<?php if($address) { ?><table><tr><td><?php echo $address;?></td></tr></table><?php } ?>'
});
infowindow.open(map, marker);

google.maps.event.addListener(marker, 'click', function() {
 infowindow.open(map, this);
});
  }

</script>
<div id="map" style="width:700px; height:400px;"></div>
<script language="javascript">window.onload = initialize();</script>
<script language="javascript">
function loadGMap(){
setTimeout('google.maps.event.trigger(map, "resize")', 500);
setTimeout('map.setCenter(new google.maps.LatLng(<?php echo $mappoint;?>))', 500);
setTimeout('infowindow.close()', 500);
setTimeout('infowindow.setContent("<?php if($address) { ?><table><tr><td><?php echo $address;?></td></tr></table><?php } ?>")', 600);
setTimeout('infowindow.open(map, marker)', 700);
}
</script>