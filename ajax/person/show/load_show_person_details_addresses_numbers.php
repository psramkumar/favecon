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
	$data=$person->get_details_addresses_numbers($_POST['id'], $lang['ntypes']);
	echo "<div class='showPersonDetails'>
			<table width='100%' style='margin-top:-20px;'>
				<tr>
					<td align='right'><span class='edit_button' onClick=\"load_edit_person('".$_POST['id']."', 'addresses_numbers', false);\"><img src='styles/".$user->settings['style']."/images/edit.png' height='12px' align='top'>&nbsp;&nbsp;".$lang['edit_button']."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='edit_button' onClick=\"delete_person('".$_POST['id']."', '".$lang['delete_msg']."');\"><img src='styles/".$user->settings['style']."/images/delete.png' height='12px' align='top'>&nbsp;&nbsp;".$lang['delete_button']."</span></td>
				</tr>
			</table>
			<table width='100%'>
				<tr>
					<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['phone_numbers']."</td>
				</tr>
				<tr>
					<td>";
	if($data[0])
	{
		echo "<table>";
		foreach(array_keys($data[2]['numbers']) as $key)
		{
			foreach($data[2]['numbers'][$key] as $number)
			{
				echo "<tr>
						<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$key.": </td>
						<td class='personDetails_lasttd'><span onClick='selectText(this);' nowrap>".$number['number']."</span></td>
					</tr>";
			}
		}
	}
	else
	{
		echo "<table width='100%'>
				<tr>
					<td colspan='2' align='center'>".$lang['no_numbers']."</td>
				</tr>";
	}
	echo "				</table>
					</td>
				</tr>
				
				<tr>
					<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['addresses']."</td>
				</tr>
				<tr>
					<td>";
	if($data[1])
	{
		echo "<table width='100%'>";
		$i=1;
		foreach($data[2]['addresses'] as $address)
		{
			echo "<tr>
					<td class='personDetails_firsttd' nowrap style='vertical-align:top; font-weight:200; color:#036;' nowrap>Address ".$i.": </td>
					<td><span onClick='selectText(this);'>".$address['street']."<br>".$address['iso3']."-".$address['plz']." ".$address['city']."<br><img src='images/countries/".$address['iso2'].".gif' alt=''/>&nbsp;".$address['name']."</span></td>
				</tr>";
			if($user->settings['google_maps']==1)
			{
				echo "<tr>
						<td colspan='2' nowrap>
							<div class='gmaps_table'>
								<table width='100%' id='gmaps_".$address['ID']."'>
									<tr class='gmaps_toggle' onClick=\"gmaps_toggle('".$address['ID']."');\">
										<td colspan='2' style='padding-left:30px;'>".$lang['gmaps_show']."</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>";
			}
			$i=$i+1;
		}
	}
	else
	{
		echo "<table width='100%'>
				<tr>
					<td colspan='2' align='center'>".$lang['no_addresses']."</td>
				</tr>";
	}
	echo "				</table>
					</td>
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