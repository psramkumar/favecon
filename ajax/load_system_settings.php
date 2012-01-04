<?php
	header('Content-Type: text/html; charset=utf-8'); // sorgt für die korrekte HTML-Kodierung
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../includes/ajaxInits/includes.ajaxInit.php");
	
	//Starte Klassen
	$user=new user();
	$person=new person();
	
	//Sprache laden
	include("../translations/lang.".$user->sys_settings['lang'].".php");
	
	
	//Ausgabe
	$countries=$person->get_countries();
	$languages=$user->get_langs("../");
	echo "<div class='showPersonDetails' id='system_settings' style='width:800px;'>
			<input type='hidden' value='0' id='changedContents'>
			<form action='javascript:save_system_settings();'>
				<table class='form' width='100%'>
					<tr>
						<td colspan='2' class='first' nowrap>".$lang['titles']['system_settings']."</td>
					</tr>
					<tr>
						<td id='error' colspan='2' align='center'></td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='favecon_title' style='font-weight:200; color:#036;'>".$lang['favecon_title'].":</label></td>
						<td>
							<input type='text' name='favecon_title' id='favecon_title' style='width:360px;' value='".$user->sys_settings['favecon_title']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
							<input type='hidden' name='style' value='default'>
						</td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='lang' style='font-weight:200; color:#036;'>".$lang['system_lang'].":</label></td>
						<td>
							<select name='lang' id='lang' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
								<optgroup>";
		foreach($languages as $language)
		{
			echo "<option value='".$language['abbr']."' style='background-image:url(images/countries/".$language['iso2'].".gif); background-repeat:no-repeat; background-position:center left; padding-left:20px;'";
			if($language['abbr']==$user->sys_settings['lang'])
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
						<td class='personDetails_firsttd' nowrap><label for='std_country' style='font-weight:200; color:#036;'>".$lang['system_std_country'].":</label></td>
						<td>
							<select name='state_std_num' id='std_country' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
								<optgroup>";
		foreach($countries as $country)
		{
			echo "<option value='".$country['num_code']."' style='background-image:url(images/countries/".$country['iso2'].".gif); background-repeat:no-repeat; background-position:center left; padding-left:20px;'";
			if($country['num_code']==$user->sys_settings['state_std_num'])
			{
				echo " selected";
			}
			echo ">".$country['name']."</option>";
		}
		echo "					</optgroup>
							</select>
						</td>
					</tr>
					<tr class='update_notification'>
						<td class='personDetails_firsttd' nowrap><label for='update_notification' style='font-weight:200; color:#036;'>".$lang['system_update_notification'].":</label></td>
						<td><input type='checkbox' id='update_notification' name='update_notification' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"";
		if($user->sys_settings['update_notification'])
		{
			echo " checked";
		}
		echo "></td>
					</tr>
					<tr class='news'>
						<td class='personDetails_firsttd' nowrap><label for='news' style='font-weight:200; color:#036;'>".$lang['system_news'].":</label></td>
						<td><input type='checkbox' id='news' name='news' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"";
		if($user->sys_settings['news'])
		{
			echo " checked";
		}
		echo "></td>
					</tr>
					<tr>
						<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['system_contact_ordering']."&nbsp;&nbsp;&nbsp;<span class='edit_button' onClick=\"load_info('contact_settings');\"><img src='styles/".$user->sys_settings['style']."/images/help.png' height='17px' style='vertical-align:bottom;'></span></td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='order' style='font-weight:200; color:#036;'>".$lang['system_order'].":</label></td>
						<td>
							<select name='order' id='order' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
								<optgroup>
									<option value='firstname'";
		if($user->sys_settings['order']=="firstname")
		{
			echo " selected";
		}
		echo ">".$lang['firstname']."</option>
									<option value='lastname'";
		if($user->sys_settings['order']=="lastname")
		{
			echo " selected";
		}
		echo ">".$lang['lastname']."</option>
								</optgroup>
							</select>
							<select name='order_type' id='order_type' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
								<optgroup>
									<option value='ASC'";
		if($user->sys_settings['order_type']=="ASC")
		{
			echo " selected";
		}
		echo ">".$lang['asc']."</option>
									<option value='DESC'";
		if($user->sys_settings['order_type']=="DESC")
		{
			echo " selected";
		}
		echo ">".$lang['desc']."</option>
								</optgroup>
							</select>
						</td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='show_persons' style='font-weight:200; color:#036;'>".$lang['system_show_persons'].":</label></td>
						<td><input type='text' name='show_persons' id='show_persons' style='width:360px;' value='".$user->sys_settings['show_persons']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='show_persons1' style='font-weight:200; color:#036;'>".$lang['system_show_persons1'].":</label></td>
						<td><input type='text' name='show_persons1' id='show_persons1' style='width:360px;' value='".$user->sys_settings['show_persons1']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
					</tr>
					<tr>
						<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['system_user_settings']."</td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='passwd_length' style='font-weight:200; color:#036;'>".$lang['system_passwd_length'].":</label></td>
						<td><input type='text' name='passwd_length' id='passwd_length' style='width:360px;' value='".$user->sys_settings['passwd_length']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='required_user_fields' style='font-weight:200; color:#036;'>".$lang['system_required_user_fields'].":</label></td>
						<td>
							<select name='required_user_fields[]' size='4' multiple id='required_user_fields' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
									<option value='firstname'";
		$required=explode(",", $user->sys_settings['required_user_fields']);
		foreach($required as $field)
		{
			$required_fields[$field]=$field;
		}
		if(array_key_exists("firstname", $required_fields))
		{
			echo " selected";
		}
		echo ">".$lang['firstname']."</option>
									<option value='lastname'";
		if(array_key_exists("lastname", $required_fields))
		{
			echo " selected";
		}
		echo ">".$lang['lastname']."</option>
									<option value='email'";
		if(array_key_exists("email", $required_fields))
		{
			echo " selected";
		}
		echo ">".$lang['settings_email']."</option>
									<option value='bday'";
		if(array_key_exists("bday", $required_fields))
		{
			echo " selected";
		}
		echo ">".$lang['bday']."</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['system_settings_search_engine']."</td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='search_show_limit' style='font-weight:200; color:#036;'>".$lang['system_search_show_limit'].":</label></td>
						<td><input type='text' name='search_show_limit' id='search_show_limit' style='width:360px;' value='".$user->sys_settings['search_show_limit']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
					</tr>
					<tr>
						<td colspan='2' class='personDetails_firsttd personDetails_lasttd'>".$lang['system_um_system_settings']."</td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='um_users_limit' style='font-weight:200; color:#036;'>".$lang['system_um_system_settings_users_limit'].":</label></td>
						<td><input type='text' name='um_users_limit' id='um_users_limit' style='width:360px;' value='".$user->sys_settings['um_users_limit']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
					</tr>
					<tr>
						<td class='personDetails_firsttd' nowrap><label for='news_limit' style='font-weight:200; color:#036;'>".$lang['system_news_limit'].":</label></td>
						<td><input type='text' name='news_limit' id='news_limit' style='width:360px;' value='".$user->sys_settings['news_limit']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
					</tr>
					<tr>
						<td colspan='2' align='center'><span class='personLink' onClick=\"loadContentPage('sorting');\">".$lang['system_sorting']."</span></td>
					</tr>
					<tr>
						<td colspan='2' class='personDetails_firsttd personDetails_lasttd'>".$lang['system_addon_api']."</td>
					</tr>
					<tr class='google_maps'>
						<td class='personDetails_firsttd' nowrap><label for='google_maps' style='font-weight:200; color:#036;'>".$lang['system_gmaps_addon'].":</label></td>
						<td><input type='checkbox' id='google_maps' name='google_maps' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html(''); $('#google_maps_toggle').toggle('blind');\"";
		if($user->sys_settings['google_maps'])
		{
			echo " checked";
		}
		echo "></td>
					</tr>
					<tr>
						<td colspan='2' width='100%'>
							<table id='google_maps_toggle' width='100%' style='padding:0; margin:0; margin-left:-10px;";
		if(!$user->sys_settings['google_maps'])
		{
			echo " display:none;";
		}
		echo "'>
								<tr>
									<td class='personDetails_firsttd' nowrap><label for='google_maps_key' style='font-weight:200; color:#036;'>".$lang['system_gmaps_key'].":</label></td>
									<td><textarea name='google_maps_key' id='google_maps_key' style='width:350px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">".$user->sys_settings['google_maps_key']."</textarea></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr class='google_maps'>
						<td class='personDetails_firsttd' nowrap><label for='facebook' style='font-weight:200; color:#036;'>".$lang['system_facebook_addon'].":</label><br><span style='font-size:10px; color:red; font-weight:100;'>(".$lang['system_curl'].")</span></td>
						<td><input type='checkbox' id='facebook' name='facebook' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html(''); $('#facebook_toggle').toggle('blind');\"";
		if($user->sys_settings['facebook'])
		{
			echo " checked";
		}
		if(!in_array('curl', get_loaded_extensions()))
		{
			echo " disabled";
		}
		echo "></td>
					</tr>
					<tr>
						<td colspan='2' width='100%'>
							<table id='facebook_toggle' width='100%' style='padding:0; margin:0; margin-left:-10px;";
		if(!$user->sys_settings['facebook'])
		{
			echo " display:none;";
		}
		echo "'>
								<tr>
									<td class='personDetails_firsttd' nowrap><label for='fb_app_id' style='font-weight:200; color:#036;'>".$lang['system_fb_app_id'].":</label></td>
									<td><textarea name='fb_app_id' id='fb_app_id' style='width:350px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">".$user->sys_settings['fb_app_id']."</textarea></td>
								</tr>
								<tr>
									<td class='personDetails_firsttd' nowrap><label for='fb_secret' style='font-weight:200; color:#036;'>".$lang['system_fb_secret'].":</label></td>
									<td><textarea name='fb_secret' id='fb_secret' style='width:350px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">".$user->sys_settings['fb_secret']."</textarea></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan='2' align='center'><input type='submit' id='save' disabled value='".$lang['save']."'></td>
					</tr>
				</table>
			</form>
		</div>";
	
	
	//Schließe MySQL
	mysql_close();
?>
<script type="text/javascript">
	$(function() {
		$('.update_notification :checkbox').iphoneStyle();
		$('.news :checkbox').iphoneStyle();
		$('.google_maps :checkbox').iphoneStyle();
		$('.facebook :checkbox').iphoneStyle();
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