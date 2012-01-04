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
	$i=$_POST['i'];
	$stypes=$person->get_social_com_types();
	if($_POST['id']!="")
	{
		$stype=$stypes[$_POST['id']];
		echo "<tr>
				<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['social_com_name'].":</td>
				<td><input type='text' name='uname[]' style='width:235px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
			</tr>";
		if($stype['fb_pid'])
		{
			echo "<tr>
					<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['social_com_fbpid']."</td>
					<td>
						<input type='text' id='fb_pid_".$i."' name='fb_pid[]' style='width:200px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">";
			if($user->settings['fb_id']!="")
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span class='edit_button' onClick=\"load_no_lang_info('facebook_friends', '".$i."');\"><img src='styles/".$user->settings['style']."/images/facebook_icon.gif' style='vertical-align:text-bottom;'>&nbsp;".$lang['select_fb_friend']."</span>";
			}
			echo "	</td>
				</tr>";
		}
		else
		{
			echo "<input type='hidden' name='fb_pid[]'>";
		}
		if($stype['praefixUsage'])
		{
			echo "<tr>
					<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['social_com_praefix'].":</td>
					<td>
						<select name='praefix[]' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
							<optgroup>
								<option value='1'>".$stype['praefix1Text']."</option>
								<option value='2'>".$stype['praefix2Text']."</option>
							</optgroup>
						</select>
					</td>
				</tr>";
		}
		else
		{
			echo "<input type='hidden' name='praefix[]' value='1'>";
		}
		echo "<tr>
				<td class='personDetails_firsttd' style='font-weight:200; color:#036; vertical-align:top;' nowrap>".$lang['infoText'].":</td>
				<td><textarea name='info[]' style='width:235px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></textarea></td>
			</tr>";
	}
	else
	{
		echo "<input type='hidden' name='uname[]'><input type='hidden' name='fb_pid[]'><input type='hidden' name='praefix[]' value='1'><input type='hidden' name='info[]'>";
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