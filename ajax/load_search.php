<?php
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../includes/ajaxInits/includes.ajaxInit.php");
	
	//Starte Klassen
	$user=new user();
	
	//Sprache laden
	include("../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	$search_rows[0]['persons']['firstname']=PERSONS_TBL.".firstname";
	$search_rows[0]['persons']['lastname']=PERSONS_TBL.".lastname";
	$search_rows[0]['persons']['title']=PERSONS_TBL.".title";
	$search_rows[0]['persons']['bday']=PERSONS_TBL.".bday";
	$search_rows[1]['addresses']['street']=PERSONS_ADDRESSES_TBL.".street";
	$search_rows[1]['addresses']['plz']=PERSONS_ADDRESSES_TBL.".plz";
	$search_rows[1]['addresses']['city']=PERSONS_ADDRESSES_TBL.".city";
	$search_rows[2]['numbers']['number']=PERSONS_NUMBERS_TBL.".number";
	$search_rows[2]['emails']['email']=PERSONS_EMAILS_TBL.".email";
	$search_rows[2]['www']['url']=PERSONS_WEBSITES_TBL.".url";
	$search_rows[3]['social']['uname']=PERSONS_SOCIALCOM_TBL.".uname";
	$search_rows[3]['social']['fb_pid']=PERSONS_SOCIALCOM_TBL.".fb_pid";
	
	echo "<div class='showPersonDetails' id='search' style='width:800px;'>
			<table width='100%' class='form'>
				<tr>
					<td colspan='2' class='first' nowrap>".$lang['titles']['search']."</td>
				</tr>
				<tr>
					<td align='center'><label for='ssearch_query'><b>".$lang['search'].":</b></label>&nbsp;&nbsp;&nbsp;<input type='text' id='ssearch_query' style='width:300px;' onKeyUp=\"ext_search('');\"></td>
				</tr>
				<tr>
					<td>
						<form id='search_rows'>
						<table width='100%'>";
	foreach($search_rows as $search_row)
	{
		echo "<td valign='top'>";
		foreach(array_keys($search_row) as $row)
		{
			foreach(array_keys($search_row[$row]) as $key)
			{
				echo "<input type='checkbox' name='search_rows[".$row."][]' value='".$search_row[$row][$key]."' id='search_rows_".$row."_".$key."' onChange=\"ext_search('');\"><label for='search_rows_".$row."_".$key."' style='-moz-user-select:none; -khtml-user-select:none; user-select:none;'>&nbsp;".$lang['search_'.$key]."</label><br>";
			}
		}
		echo "</td>";
	}
	echo "				</table>
						</form>
					</td>
				</tr>
				<tr>
					<td align='center'>
						<span class='personLink' onClick=\"$('#search_rows input').attr('checked', true); ext_search('');\">[".$lang['search_check_all']."]</span>&nbsp;&nbsp;&nbsp;
						<span class='personLink' onClick=\"$('#search_rows input').attr('checked', false); ext_search('');\">[".$lang['search_uncheck_all']."]</span>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<table id='search_results' width='100%' class='tablehead'>
						</table>
					</td>
				</tr>
			</table>
		</div>";
	
	//Schließe MySQL
	mysql_close();
?>
<script type="text/javascript">
	$(function() {
		$('#ssearch_query').val($('#search_query').val());
		ext_search("");
		$('#search_query').val('');
		$('#ssearch_query').focus();
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