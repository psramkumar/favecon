<?php
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../includes/ajaxInits/includes.ajaxInit.php");
	
	//Starte Klassen
	$user=new user();
	
	//Sprache laden
	include("../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	echo "<div id='personDetail_links'>
			<ul>
				<li onClick=\"load_sorting('number_type', '".$lang['editError']."');\" class='selectedDetails' id='DetailLink_number_type'><span>".$lang['sorting_number_type']."</span></li>
				<li onClick=\"load_sorting('social_type', '".$lang['editError']."');\" id='DetailLink_social_type'><span>".$lang['sorting_social_type']."</span></li>
			</ul>
		</div>
		
		<div id='personDetails'></div>";
	
	//Schließe MySQL
	mysql_close();
?>
<script type="text/javascript">
	$(function() {
		load_sorting("number_type", '');
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