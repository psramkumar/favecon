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
	
	
	//Prüfe limit
	if($_POST['limit']=="")
	{
		$_POST['limit']="0,".$user->settings['um_users_limit'];
	}
	
	//Ausgabe
	$users=$um->get_users($_POST['order'], $_POST['order_type'], $_POST['query'], $_POST['limit']);
	$groups=$um->get_groups();
	echo "<tr class='tablehead'>
			<td>".$lang['um_username']."</td>
			<td>".$lang['um_group']."</td>
			<td nowrap>".$lang['um_firstname']." ".$lang['um_lastname']."</td>
			<td>".$lang['um_email']."</td>
			<td>".$lang['um_enabled']."</td>
			<td style=\"max-width:200px;\">".$lang['um_comment']."</td>
			<td>".$lang['um_delete']."</td>
		</tr>";
	if($users[0])
	{
		foreach($users[1] as $user)
		{
			echo "<tr>
					<td valign='top'><span class='personLink' onClick=\"load_edit_user('".$user['ID']."');\">".$user['username']."</span></td>
					<td valign='top'>".$groups[$user['gid']]['gname']."</td>
					<td valign='top'>".$user['firstname']." ".$user['lastname']."</td>
					<td valign='top'>".$user['email']."</td>
					<td align='center' valign='top'>";
			$enabled_text="FALSE";
			if($user['enabled'])
			{
				$enabled_text="True";
			}
			echo $enabled_text."</td>
					<td style=\"word-wrap:break-word; max-width:150px;\">".nl2br($user['comment'])."</td>
					<td align='center' onClick=\"delete_user('".$user['ID']."', '".$lang['um_delete_msg']."');\" valign='top'><span class='personLink'>X</span></td>
				</tr>";
		}
		echo "<tr class='tablehead' style='border-top:1px solid #999;'>
				<td colspan='7' align='center''>";
		$i=1;
		foreach($users[2] as $limit)
		{
			if(!$limit[1])
			{
				echo "<span class='personLink' onClick=\"load_users_table('".$_POST['order']."', '".$_POST['order_type']."', '".$limit[0]."');\">";
			}
			echo $i;
			if(!$limit[1])
			{
				echo "</span>";
			}
			echo "&nbsp;&nbsp;&nbsp;";
			$i++;
		}
		echo "(".$users[3]." ".$lang['um_how_many_found'].")</td>
			</tr>";
	}
	else
	{
		echo "<tr>
				<td colspan='2' align='center'>".$lang['no_users']."</td>
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