<?php
	header('Content-Type:text/html;'); // sorgt für die korrekte XML-Kodierung
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../includes/ajaxInits/includes.ajaxInit.ebene1.php");
	
	//Starte Klassen
	$user=new user();
	
	//Sprache laden
	include("../../translations/lang.".$user->settings['lang'].".php");
	
	
	//Prüfe order
	if(!isset($_POST['order']))
	{
		$_POST['order']="m_time";
		$_POST['order_type']="DESC";
	}
	
	//Ausgabe
	echo "<div class='showPersonDetails' style='width:700px;''>
			<table width='100%' class='form'>
				<tr>
					<td align='center'><label for='news_search_query'><b>".$lang['news_live_search'].":</b></label>&nbsp;&nbsp;&nbsp;<input type='text' id='news_search_query' style='width:300px;' onKeyUp=\"load_news_table('m_time', 'DESC', '');\"></td>
				</tr>
				<tr>
					<td>
						<table id='news_news' width='100%' class='tablehead'>
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
		load_news_table("m_time", "DESC", "");
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