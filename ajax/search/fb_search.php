<?php
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../includes/ajaxInits/includes.ajaxInit.ebene1.php");
	
	//Starte Klassen
	$user=new user();
	
	//Sprache laden
	include("../../translations/lang.".$user->settings['lang'].".php");
	
	require '../../includes/facebook.php';
	
	if($_POST['limit']=="")
	{
		$_POST['limit']="0,".$user->settings['search_show_limit'];
	}
	$limit=explode(",", $_POST['limit']);
	
	include("../../includes/facebook_connect.php");
	
	//Ausgabe
	echo "<tr class='tablehead'>
			<td nowrap colspan='2'>".$lang['fb_friends_header']."</td>
		</tr>";
	
	$me = $facebook->api('/me/friends');
	$data=array();
	
	if($_POST['query']!="")
	{
		foreach($me['data'] as $friend)
		{
			$friend=str_ireplace($_POST['query'], "<span class='highlighted_search_string'>".$_POST['query']."</span>", $friend, $count);
			if($count>0)
			{
				$data[]=$friend;
			}
		}
		$me['data']=$data;
	}
	
	$x=$_POST['x'];
	
	if(count($me['data'])>0)
	{
		$all_entries=count($me['data']);
		$show_to=$limit[0]+$limit[1];
		if($show_to>=$all_entries)
		{
			$show_to=$all_entries;
		}
		for($i=$limit[0]; $i<$show_to; $i++)
		{
			echo "<tr class='fb_search personLink' onClick=\"window.opener.$('#fb_pid_".$x."').val('".$me['data'][$i]['id']."'); window.close();\">
					<td nowrap style='padding-right:20px; width:50px;'><fb:profile-pic size=\"square\" uid=\"".$me['data'][$i]['id']."\"></fb:profile-pic></td>
					<td>".$me['data'][$i]['name']."</td>
				</tr>";
		}
		echo "<tr class='tablehead' style='border-top:1px solid #999;'>";
		$i=1;
		$now=0;
		while($now<$all_entries)
		{
			if($i==1 OR $i%20==0)
			{
				if($i==1) echo "</td></tr>";
				echo "<tr class='tablehead'><td colspan='5' align='center' nowrap>";
			}
			if(!($limit[0]>=$now AND $limit[0]<($now+$limit[1])))
			{
				echo "<span class='personLink' onClick=\"fb_search('".$now.",".$limit[1]."', '".$x."');\">";
			}
			echo $i;
			if(!($limit[0]>=$now AND $limit[0]<($now+$limit[1])))
			{
				echo "</span>";
			}
			if(($i+1)%20!=0) echo "&nbsp;&nbsp;&nbsp;";
			$i++;
			$now=$now+$limit[1];
		}
		echo " (".$all_entries."&nbsp;".$lang['fb_how_many_found'].")</td>
			</tr>";
	}
	else
	{
		echo "<tr>
				<td colspan='5' align='center'>".$lang['fb_search_no_data']."</td>
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