<?php
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../includes/ajaxInits/includes.ajaxInit.ebene1.php");
	
	//Starte Klassen
	$user=new user();
	$person=new person();
	
	//Sprache laden
	include("../../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	if($_POST['query']!="")
	{
		$results=$person->search(true, $_POST['query']);
		if(count($results[0])>0)
		{
			echo "<ul id='ls_search_ul'>";
			foreach($results[0] as $result)
			{
				$output=$result['firstname']." <b>".$result['lastname']."</b>";
				if(isset($result['string']))
				{
					$output.="<br>&nbsp;&nbsp;".$result['string'];
				}
				echo "<li onClick=\"load_show_person('".$result['ID']."', 'general_info'); $('#live_search_results').toggle('blind', {}, 300); $('#search_query').val('');\">".$output."</li>";
			}
			echo "</ul>";
		}
		else
		{
			echo "<div align='center'>".$lang['live_search_no_data']."</div>";
		}
	}
	else
	{
		echo "<div align='center'>".$lang['live_search_no_query']."</div>";
	}
	
	//Schließe MySQL
	mysql_close();
?>

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