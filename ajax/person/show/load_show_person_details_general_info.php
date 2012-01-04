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
	$data=$person->get_details_general_info($_POST['id']);
	echo "<div class='showPersonDetails' style='width:500px;'>
			<table width='100%' style='margin-top:-20px;'>
				<tr>
					<td align='right'><span class='edit_button' onClick=\"load_edit_person('".$_POST['id']."', 'general_info', false);\"><img src='styles/".$user->settings['style']."/images/edit.png' height='12px' align='top'>&nbsp;&nbsp;".$lang['edit_button']."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='edit_button' onClick=\"delete_person('".$_POST['id']."', '".$lang['delete_msg']."');\"><img src='styles/".$user->settings['style']."/images/delete.png' height='12px' align='top'>&nbsp;&nbsp;".$lang['delete_button']."</span></td>
				</tr>
			</table>
			<table>
				<tr>
					<td class='personDetails_firsttd' nowrap>".$lang['title'].": </td>
					<td class='personDetails_lasttd'><span onClick='selectText(this);'>".$data['title']."</span></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap>".$lang['firstname'].": </td>
					<td class='personDetails_lasttd'><span onClick='selectText(this);'>".$data['firstname']."</span></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap>".$lang['lastname'].": </td>
					<td class='personDetails_lasttd'><span onClick='selectText(this);'>".$data['lastname']."</span></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap>".$lang['bday'].": </td>
					<td class='personDetails_lasttd'><span onClick='selectText(this);'>".$data['bday']."</span></td>
				</tr>
			</table>
		</div>";
		
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