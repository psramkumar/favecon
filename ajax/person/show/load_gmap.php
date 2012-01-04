<?php
	header('Content-Type:text/html;'); // sorgt für die korrekte XML-Kodierung
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../../includes/ajaxInits/includes.ajaxInit.ebene2.php");
	
	//Starte Klassen
	$user=new user();
	$person=new person();
	
	//Sprache laden
	include("../../../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	//Hole Address
	$address=$person->getGoogleMapsAddress($_POST['id']);
	echo "<div id='map_canvas' style='height:450px;'></div>";
	
	//Schließe MySQL
	mysql_close();
?>
<script type="text/javascript">
	var map = null;
	var geocoder = null;
	
	function initialize() {
	  if (GBrowserIsCompatible()) {
		map = new GMap2(document.getElementById("map_canvas"));
		//map.setUIToDefault();
		var customUI = map.getDefaultUI();
		customUI.maptypes.normal = true;
		customUI.maptypes.satellite = true;
		customUI.maptypes.hybrid = true;
		customUI.maptypes.physical = false;
		map.setUI(customUI);
		geocoder = new GClientGeocoder();
		showAddress("<?=$address['geolocator']?>");
	  }
	}
	
	function showAddress(address) {
	  if (geocoder) {
		geocoder.getLatLng(
		  address,
		  function(point) {
			if (!point) {
			  alert(address + " not found");
			} else {
			  map.setCenter(point, 15);
			  var marker = new GMarker(point);
			  map.addOverlay(marker);
			  map.openInfoWindowHtml(point, "<?=$address['mark']?>");
			  marker.value=1;
			  GEvent.addListener(marker,"click", function() {
			  map.openInfoWindowHtml(point, "<?=$address['mark']?>");
			  });
			}
		  }
		);
	  }
	}
	
	$(function() {
		initialize();
	});
</script>

<!--
	*********************
     FaveCon AddressBook
    *********************
    Copyright (C) 2010-2011 Daniel Mühlbachler
    
    FaveCon AddressBook is a contact management system with Google Maps and Facebook Integration (if you have API keys for it!).
	
	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
    *********************
     Contact Information
    *********************
    To contact the developer of this program visit: http://www.muehlbachler.org
-->