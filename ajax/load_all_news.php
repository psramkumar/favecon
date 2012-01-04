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
	$stats=$user->get_statistics();
?>
<div style='margin:0px 20px; margin-top:25px; padding-right:20px; overflow:auto; height:100%; width:800px;'>
<?php
	if($user->settings['news'])
	{
		$news=$user->get_news();
?>
    <table class='news_table' width='100%'>
<?php
	if(!$news[0])
	{
		echo "<tr>
				<td colspan='3' align='center'>".$lang['no_news']."</td>
			</tr>";
	}
	else
	{
		foreach($news[1] as $entry)
		{
			echo "<tr>
					<td class='td1'><span class='personLink' onClick=\"open_news('".$entry['ID']."', 'all_news');\">".$entry['m_header']."</span></td>
					<td nowrap class='td3'>".date("Y-m-d h:i a", $entry['m_time'])."</td>
					<td nowrap class='td3'>".$entry['firstname']."&nbsp;<b>".$entry['lastname']."</b>&nbsp;(".$entry['username'].")
				</tr>
				<tr>
					<td colspan='3'>".trim(substr(nl2br($entry['m_body']), 0, 200))."&nbsp;...</td>
				</tr>";
		}
	}
?>
    </table>
<?php
	}
?>
</div>
<?php
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