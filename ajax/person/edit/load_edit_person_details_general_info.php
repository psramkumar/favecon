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
					<td align='right'><span class='edit_button' onClick=\"load_show_person1('".$_POST['id']."', 'general_info', '".$lang['editError']."');\"><img src='styles/".$user->settings['style']."/images/show.png' height='12px' align='top'>&nbsp;&nbsp;".$lang['show_button']."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='edit_button' onClick=\"delete_person('".$_POST['id']."', '".$lang['delete_msg']."');\"><img src='styles/".$user->settings['style']."/images/delete.png' height='12px' align='top'>&nbsp;&nbsp;".$lang['delete_button']."</span></td>
				</tr>
			</table>
			<input type='hidden' value='0' id='changedContents'>
			<form action=\"javascript:save_personDetails_general_info('".$_POST['id']."');\">
			<table class='form'>
				<tr>
					<td id='error' colspan='2' align='center'></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='title'>".$lang['title'].": </label></td>
					<td><input type='text' name='title' id='title' style='width:360px;' value='".$data['title']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='firstname'>".$lang['firstname'].": </label></td>
					<td><input type='text' name='firstname' id='firstname' style='width:360px;' value='".$data['firstname']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='lastname'>".$lang['lastname'].": </label></td>
					<td><input type='text' name='lastname' id='lastname' style='width:360px;' value='".$data['lastname']."' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='bday'>".$lang['bday'].": </label></td>
					<td><input type='text' name='bday' readonly id='bday' style='width:335px;' value='".$data['bday']."' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\" onFocus='blur();'>&nbsp;
							<span class='edit_button' onClick=\"$('#bday').val(''); document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\" onmouseover=\"this.title='".$lang['clear_input']."';\"><img src='styles/".$user->settings['style']."/images/clear_input.png' height='16px' style='vertical-align:text-bottom;'></span></td>
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
		$('#bday').datepicker({
			changeMonth:true,
			changeYear:true,
			dateFormat:"yy-mm-dd",
			maxDate:"+1y",
			minDate:"-120y",
			yearRange:"-120y",
			showAnim:"fadeIn"
		});
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