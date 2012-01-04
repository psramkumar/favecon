<?php
	header('Content-Type:text/html;'); // sorgt für die korrekte XML-Kodierung
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../includes/ajaxInits/includes.ajaxInit.ebene1.php");
	
	//Starte Klassen
	$user=new user();
	$news=new news_mngmnt();
	$um=new user_mngmnt();
	
	//Sprache laden
	include("../../translations/lang.".$user->settings['lang'].".php");
	
	
	//Prüfe limit
	if($_POST['limit']=="")
	{
		$_POST['limit']="0,".$user->settings['news_limit'];
	}
	
	//Ausgabe
	$entries=$news->get_news($_POST['order'], $_POST['order_type'], $_POST['query'], $_POST['limit']);
	$groups=$um->get_groups();
	echo "<tr class='tablehead'>
			<td nowrap>".$lang['news_header']."</td>
			<td nowrap>".$lang['news_time']."</td>
			<td nowrap>".$lang['news_from']."</td>
			<td nowrap>".$lang['news_for_gid']."</td>
			<td nowrap>".$lang['news_delete']."</td>
		</tr>";
	if($entries[0])
	{
		foreach($entries[1] as $entry)
		{
			echo "<tr>
					<td><span class='personLink' onClick=\"load_edit_news('".$entry['ID']."');\">".$entry['m_header']."</span></td>
					<td>".date("Y-m-d h:i a", $entry['m_time'])."</td>
					<td>".$entry['firstname']."&nbsp;<b>".$entry['lastname']."</b>&nbsp;(".$entry['username'].")</td>
					<td>".$groups[$entry['for_gid']]['gname']."</td>
					<td align='center' onClick=\"delete_news('".$entry['ID']."', '".$lang['news_delete_msg']."');\"><span class='personLink'>X</span></td>
				</tr>";
		}
		echo "<tr class='tablehead' style='border-top:1px solid #999;'>
				<td colspan='5' align='center''>";
		$i=1;
		foreach($entries[2] as $limit)
		{
			if(!$limit[1])
			{
				echo "<span class='personLink' onClick=\"load_news_table('".$_POST['order']."', '".$_POST['order_type']."', '".$limit[0]."');\">";
			}
			echo $i;
			if(!$limit[1])
			{
				echo "</span>";
			}
			echo "&nbsp;&nbsp;&nbsp;";
			$i++;
		}
		echo "(".$entries[3]." ".$lang['news_how_many_found'].")</td>
			</tr>";
	}
	else
	{
		echo "<tr>
				<td colspan='2' align='center'>".$lang['no_news']."</td>
			</tr>";
	}
		
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