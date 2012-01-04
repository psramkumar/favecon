<?php
	header('Content-Type: text/html; charset=utf-8'); // sorgt für die korrekte HTML-Kodierung
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
	$countries=$person->get_countries();
	$languages=$user->get_langs("../../");
	echo "<div class='showPersonDetails' style='width:700px;'>
			<input type='hidden' value='0' id='changedContents'>
			<form action='javascript:save_settings_settings();'>
				<table class='form' width='100%'>
					<tr>
						<td id='error' colspan='2' align='center'></td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='lang' style='font-weight:200; color:#036;'>".$lang['settings_lang'].":</label></td>
						<td>
							<select name='lang' id='lang' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
								<optgroup>";
		foreach($languages as $language)
		{
			echo "<option value='".$language['abbr']."' style='background-image:url(images/countries/".$language['iso2'].".gif); background-repeat:no-repeat; background-position:center left; padding-left:20px;'";
			if($language['abbr']==$user->settings['lang'])
			{
				echo " selected";
			}
			echo ">".$language['language']."</option>";
		}
		echo "					</optgroup>
							</select>
						</td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='std_country' style='font-weight:200; color:#036;'>".$lang['settings_std_country'].":</label></td>
						<td>
							<select name='state_std_num' id='std_country' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
								<optgroup>";
		foreach($countries as $country)
		{
			echo "<option value='".$country['num_code']."' style='background-image:url(images/countries/".$country['iso2'].".gif); background-repeat:no-repeat; background-position:center left; padding-left:20px;'";
			if($country['num_code']==$user->settings['state_std_num'])
			{
				echo " selected";
			}
			echo ">".$country['name']."</option>";
		}
		echo "					</optgroup>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['settings_contact_ordering']."&nbsp;&nbsp;&nbsp;<span class='edit_button' onClick=\"load_info('contact_settings');\"><img src='styles/".$user->settings['style']."/images/help.png' height='17px' style='vertical-align:bottom;'></span></td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='order' style='font-weight:200; color:#036;'>".$lang['settings_order'].":</label></td>
						<td>
							<select name='order' id='order' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
								<optgroup>
									<option value='firstname'";
		if($user->settings['order']=="firstname")
		{
			echo " selected";
		}
		echo ">".$lang['firstname']."</option>
									<option value='lastname'";
		if($user->settings['order']=="lastname")
		{
			echo " selected";
		}
		echo ">".$lang['lastname']."</option>
								</optgroup>
							</select>
							<select name='order_type' id='order_type' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
								<optgroup>
									<option value='ASC'";
		if($user->settings['order_type']=="ASC")
		{
			echo " selected";
		}
		echo ">".$lang['asc']."</option>
									<option value='DESC'";
		if($user->settings['order_type']=="DESC")
		{
			echo " selected";
		}
		echo ">".$lang['desc']."</option>
								</optgroup>
							</select>
						</td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='show_persons' style='font-weight:200; color:#036;'>".$lang['settings_show_persons'].":</label></td>
						<td><input type='text' name='show_persons' id='show_persons' style='width:360px;' value='".$user->settings['show_persons']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='show_persons1' style='font-weight:200; color:#036;'>".$lang['settings_show_persons1'].":</label></td>
						<td><input type='text' name='show_persons1' id='show_persons1' style='width:360px;' value='".$user->settings['show_persons1']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
					</tr>
					<tr>
						<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['settings_settings_search_engine']."</td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='search_show_limit' style='font-weight:200; color:#036;'>".$lang['settings_search_show_limit'].":</label></td>
						<td><input type='text' name='search_show_limit' id='search_show_limit' style='width:360px;' value='".$user->settings['search_show_limit']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
					</tr>";
		if($user->settings['facebook'])
		{
			echo "	<tr>
						<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['settings_facebook_addon']."</td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='fb_id' style='font-weight:200; color:#036;'>".$lang['settings_fb_id'].":</label></td>
						<td>
							<input type='text' name='fb_id' id='fb_id' readonly style='width:200px;' value='".$user->settings['fb_id']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">&nbsp;
							<span class='edit_button' onClick=\"$('#fb_id').val('');\" onmouseover=\"this.title='".$lang['clear_input']."';\"><img src='styles/".$user->settings['style']."/images/clear_input.png' height='16px' style='vertical-align:text-bottom;'></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span class='edit_button' onClick=\"load_no_lang_info('facebook_connect', '');\"><img src='styles/".$user->settings['style']."/images/facebook_connect.png' style='vertical-align:text-bottom;'></span>
						</td>
					</tr>";
		}
		echo "		<tr>
						<td colspan='2' align='center'><input type='submit' id='save' disabled value='".$lang['save']."'></td>
					</tr>
				</table>
			</form>
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