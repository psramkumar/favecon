<?php
	header('Content-Type:text/html;'); // sorgt für die korrekte XML-Kodierung
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../includes/ajaxInits/includes.ajaxInit.ebene1.php");
	
	//Starte Klassen
	$user=new user();
	$person=new person();
	$um=new user_mngmnt();
	
	//Sprache laden
	include("../../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	$data=$um->get_user_details($_POST['id']);
	$groups=$um->get_groups();
	echo "<div class='showPersonDetails' style='width:500px;'>
			<input type='hidden' value='0' id='changedContents'>
			<form action=\"javascript:save_user_details('".$_POST['id']."');\">
			<table class='form'>
				<tr>
					<td id='error' colspan='2' align='center'></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='username'>".$lang['um_username'].": </label></td>
					<td><input type='text' name='username' id='username' style='width:360px;' value='".$data['username']."' onChange=\"document.getElementById('changedContents').value='1';\"></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='gid'>".$lang['um_group'].": </label></td>
					<td>
						<select name='gid' id='gid' onChange=\"document.getElementById('changedContents').value='1';\">";
	foreach($groups as $group)
	{
		echo "<option value='".$group['gid']."'";
		if($group['gid']==$data['gid'])
		{
			echo " selected";
		}
		echo ">".$group['gname']."</option>";
	}
	echo "				</select>
					</td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='title'>".$lang['um_title'].": </label></td>
					<td><input type='text' name='title' id='title' style='width:360px;' value='".$data['title']."' onChange=\"document.getElementById('changedContents').value='1';\"></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='firstname'>".$lang['um_firstname'].": </label></td>
					<td><input type='text' name='firstname' id='firstname' style='width:360px;' value='".$data['firstname']."' onChange=\"document.getElementById('changedContents').value='1';\"></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='lastname'>".$lang['um_lastname'].": </label></td>
					<td><input type='text' name='lastname' id='lastname' style='width:360px;' value='".$data['lastname']."' onChange=\"document.getElementById('changedContents').value='1';\"></td>
				</tr>
				<tr class='enabled'>
					<td class='personDetails_firsttd' nowrap><label for='enabled'>".$lang['um_enabled'].": </label></td>
					<td><input type='checkbox' id='enabled' name='enabled' onChange=\"document.getElementById('changedContents').value='1';\"";
	if($data['enabled'])
	{
		echo " checked";
	}
	echo "></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='email'>".$lang['um_email'].": </label></td>
					<td><input type='text' name='email' id='email' style='width:360px;' value='".$data['email']."' onChange=\"document.getElementById('changedContents').value='1';\"></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd nowrap'><label for='bday'>".$lang['um_bday'].": </label></td>
					<td><input type='text' name='bday' id='bday' style='width:360px;' readonly value='".$data['bday']."' onChange=\"document.getElementById('changedContents').value='1';\" onFocus='blue();'></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd nowrap'><label for='comment'>".$lang['um_comment'].": </label></td>
					<td><textarea name='comment' id='comment' style='width:360px; height:100px;' onChange=\"document.getElementById('changedContents').value='1';\">".$data['comment']."</textarea></td>
				</tr>
				<tr>
					<td colspan='2' align='center'><input type='submit' value='".$lang['save']."'></td>
				</tr>
			</table>
			</form>
		</div>";
		
	//Schließe MySQL
	mysql_close();
?>
<script type="text/javascript">
	$(function() {
		$('#bday').datepicker({
			changeMonth:true,
			changeYear:true,
			dateFormat:"yy-mm-dd",
			maxDate:"-1d",
			minDate:"-120y",
			yearRange:"-120y",
			showAnim:"fadeIn"
		});
		$('.enabled :checkbox').iphoneStyle();
		$("#username").focus();
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