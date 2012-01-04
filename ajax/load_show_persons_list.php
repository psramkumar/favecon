<?php
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../includes/ajaxInits/includes.ajaxInit.php");
	
	//Starte Klassen
	$user=new user();
	$person=new person();
	
	//Sprache laden
	include("../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	//Daten holen
	$buchstaben=str_split("#ABCDEFGHIJKLMNOPQRSTUVWXYZ");
	if($user->settings['order_type']=='DESC')
		$buchstaben=array_reverse($buchstaben);
	$persons=$person->load_show_persons($user->settings);
	echo "<div class='ueberschrift'>".$lang['titles']['contacts']."&nbsp;&nbsp;<img align='absmiddle' src=\"styles/".$user->settings['style']."/images/reload.png\" height=\"16px\" alt=\"Reload\" onClick=\"$('#list_persons').load('ajax/load_show_persons_list.php');\" class='reload_list' onMouseOver=\"this.title='Reload contact list';\"/></div>";
	//Daten ausgeben
	foreach($buchstaben as $key)
	{
		if($persons[0])
		{
			if(count($persons[1][$key])>0)
			{
				echo "<div class='letter'>".$key."</div>
					<ul>";
			}
			foreach($persons[1][$key] as $pers)
			{
				echo "<li onClick=\"load_show_person1('".$pers['id']."', 'general_info', '".$lang['editError']."');\">".$pers['print']."</li>";
			}
			if(count($persons[1][$key])>0)
				echo "</ul>";
		}
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