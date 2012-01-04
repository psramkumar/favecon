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
	$types=$person->get_social_com_types();
	echo "<div class='showPersonDetails' style='width:500px;'>
			<input type='hidden' value='0' id='changedContents'>
			<form action=\"javascript:save_sortable('social_type');\">
			<input type='hidden' name='sorted' id='sorted'>
			<table class='form' width='100%'>
				<tr>
					<td id='error' colspan='2' align='center'></td>
				</tr>
				<tr>
					<td colspan='2' align='center'>
						<ul id='sortable'>";
	foreach($types as $type)
	{
		echo "<li class='ui-state-default' id='".$type['ID']."'>".$type['socialtype']."</li>";
	}
	echo "				</ul>
					</td>
				</tr>
				<tr>
					<td colspan='2' align='center'><input type='submit' value='".$lang['save']."'></td>
				</tr>
			</table>
		</div>";
	
	
	//Schließe MySQL
	mysql_close();
?>
<script type="text/javascript">
	$(function() {
		$("#sortable").sortable({
			placeholder: 'ui-state-highlight',
			change:function() {
				$('#changedContents').val("1");
			}
		});
		$("#sortable").disableSelection();
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