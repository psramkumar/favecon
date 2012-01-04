<?php
	header('Content-Type: text/html; charset=utf-8'); // sorgt für die korrekte HTML-Kodierung
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../includes/ajaxInits/includes.ajaxInit.ebene1.php");
	
	//Starte Klassen
	$user=new user();
	
	//Sprache laden
	include("../../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	echo "<div class='showPersonDetails' style='width:600px;'>
			<input type='hidden' value='0' id='changedContents'>
			<form action='javascript:save_settings_passwd_change();'>
			<table class='form'>
				<tr>
					<td id='error' colspan='2' align='center'></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='old_passwd'>".$lang['old_passwd'].": </label></td>
					<td><input type='password' name='old_passwd' id='old_passwd' style='width:360px;' onKeyPress=\"$('#save').removeAttr('disabled'); $('#error').html('');\"></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='new_passwd'>".$lang['new_passwd'].": </label></td>
					<td><input type='password' name='new_passwd' id='new_passwd' style='width:360px;' onKeyPress=\"$('#save').removeAttr('disabled'); $('#error').html('');\"></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='new_passwd_confirm'>".$lang['new_passwd_confirm'].": </label></td>
					<td><input type='password' name='new_passwd_confirm' id='new_passwd_confirm' style='width:360px;' onKeyPress=\"$('#save').removeAttr('disabled'); $('#error').html('');\"></td>
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
		$("#old_passwd").focus();
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