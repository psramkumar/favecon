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
	$news=new news_mngmnt();
	
	//Sprache laden
	include("../../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	$groups=array_reverse($um->get_groups());
	$data=$news->get_news_id($_POST['id']);
	echo "<div class='showPersonDetails' style='width:600px;'>
			<input type='hidden' value='0' id='changedContents'>
			<form action=\"javascript:save_news('".$_POST['id']."');\">
			<table class='form'>
				<tr>
					<td id='error' colspan='2' align='center'></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='m_header'>".$lang['news_header'].": </label></td>
					<td><input type='text' name='m_header' id='m_header' style='width:460px;' onChange=\"document.getElementById('changedContents').value='1';\" value='".$data['m_header']."'></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='for_gid'>".$lang['news_for_gid'].": </label></td>
					<td>
						<select name='for_gid' id='for_gid' onChange=\"document.getElementById('changedContents').value='1';\">";
	foreach($groups as $group)
	{
		echo "<option value='".$group['gid']."'";
		if($data['for_gid']==$group['gid'])
		{
			echo " selected";
		}
		echo ">".$group['gname']."</option>";
	}
	echo "				</select>
					</td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' nowrap><label for='m_body'>".$lang['news_body'].": </label></td>
					<td><textarea type='text' name='m_body' id='m_body' style='width:460px; height:200px;' onChange=\"document.getElementById('changedContents').value='1';\">".$data['m_body']."</textarea></td>
				</tr>
				<tr>
					<td colspan='2' align='center'><input type='submit' value='".$lang['add_news']."'></td>
				</tr>
			</table>
			</form>
		</div>";
		
	//Schließe MySQL
	mysql_close();
?>
<script type="text/javascript">
	$(function() {
		$("#m_header").focus();
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