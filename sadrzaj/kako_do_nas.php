
<br>
<div class="col-md-8" >
<div id="kako-do-nas-mapa">
</div>
</div>
<div class="col-md-4">

<h2><?php echo $naslov; ?></h2>
    		<address>
    			<strong><?php echo $adresa; ?></strong><br>
    			<abbr title="Fiksni telefon">Telefon:</abbr> <a href="tel:<?php echo $ftelefon; ?>"><?php echo $ftelefon; ?></a><br>
    			<abbr title="Mobilni telefon">Mobilni:</abbr> <a href="tel:<?php echo $mtelefon; ?>"><?php echo $mtelefon; ?></a><br>
    			E-mail: <a href="mailto:<?php echo $emailaddr; ?>"><?php echo $emailaddr; ?></a><br>
    		</address>
</div>
<script>
   function myMap() {

var myCenter=new google.maps.LatLng(<?php echo $gmkoordinate; ?>);

function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:15,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("kako-do-nas-mapa"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter,
  icon:"http://maps.google.com/mapfiles/ms/micons/ylw-pushpin.png"
  });

marker.setMap(map);

var infowindow = new google.maps.InfoWindow({
  content:"<cetner><b><?php echo $naslov; ?></b></center><br><br>Telefon: <?php echo $mtelefon; ?><br>Adresa: <?php echo $adresa; ?>"
  });

infowindow.open(map,marker);
}


google.maps.event.addDomListener(window, 'load', initialize);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $maps_api; ?>&callback=myMap"></script>