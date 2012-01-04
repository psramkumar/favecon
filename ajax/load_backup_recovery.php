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
	include("../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	echo "<div class='showPersonDetails' id='backup_recovery' style='width:800px;'>
			<table class='form' width='100%'>
				<tr>
					<td colspan='2' class='first' nowrap>".$lang['titles']['backup_recovery']."<iframe id='download_iframe' width='0' height='0' style='display:none;'></iframe></td>
				</tr>
				<tr>
					<td id='error' colspan='2' align='center'></td>
				</tr>
				<tr>
					<td align='center' style='color:red;'>".$lang['b_r_deleteall']."</td>
				</tr>
				<tr>
					<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['b_r_xml']."&nbsp;&nbsp;&nbsp;<span class='edit_button' onClick=\"load_no_lang_info('backup_recovery', 'xml');\"><img src='styles/".$user->settings['style']."/images/help.png' height='17px' style='vertical-align:bottom;'></span></td>
				</tr>
				<tr>
					<td colspan=\"2\">
						<input type='checkbox' id='personal_use_xml'>&nbsp;<label for='personal_use_xml'>".$lang['b_r_export_personal']."</label>&nbsp;&nbsp;&nbsp;
						<input type='button' class='small_button' value='".$lang['b_r_download']."' onClick=\"download_backup('xml');\">
					</td>
				</tr>
				<tr>
					<td colspan=\"2\">";
	if(check_innodb())
	{
		echo "			<form method='post' enctype='multipart/form-data' id='xml_import'>
							<input type='file' accept=\"text/xml\" id='xml_file' name='xml_file' onChange=\"$('#xml_import_button').removeAttr('disabled'); $('#error').html('');\">&nbsp;&nbsp;<input type='button' class='small_button' value='".$lang['b_r_import']."' disabled onClick=\"import_backup('xml');\" id='xml_import_button'><br>
						</form>";
	}
	else
		echo "<span style='color:red;'>".$lang['no_innodb']."</span>";
	echo "			</td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['b_r_csv']."&nbsp;&nbsp;&nbsp;<span class='edit_button' onClick=\"load_no_lang_info('backup_recovery', 'csv');\"><img src='styles/".$user->settings['style']."/images/help.png' height='17px' style='vertical-align:bottom;'></span></td>
				</tr>
				<tr>
					<td colspan=\"2\"><input type='button' class='small_button' value='".$lang['b_r_download']."' onClick=\"download_backup('csv');\"></td>
				</tr>
				<tr>
					<td colspan=\"2\">";
	if(check_innodb())
	{
		echo "			<form method='post' enctype='multipart/form-data' id='csv_import'>
							<input type='file' accept=\"text/comma-separated-values\" id='csv_file' name='csv_file' onChange=\"$('#csv_import_button').removeAttr('disabled'); $('#error').html('');\">&nbsp;&nbsp;<input type='button' class='small_button' value='".$lang['b_r_import']."' onClick=\"import_backup('csv');\" disabled id='csv_import_button'>
						</form>";
	}
	else
		echo "<span style='color:red;'>".$lang['no_innodb']."</span>";
	echo "			</td>
				</tr>
			</table>
		</div>";
	
	//Schließe MySQL
	mysql_close();
?>
<script type="text/javascript">
	$(function() {
		$('.update_notification :checkbox').iphoneStyle();
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