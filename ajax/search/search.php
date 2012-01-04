<?php
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../includes/ajaxInits/includes.ajaxInit.ebene1.php");
	
	//Starte Klassen
	$user=new user();
	$person=new person();
	
	//Sprache laden
	include("../../translations/lang.".$user->settings['lang'].".php");
	
	if($_POST['limit']=="")
	{
		$_POST['limit']="0,".$user->settings['search_show_limit'];
	}
	$limit=explode(",", $_POST['limit']);

	$search_rows=array();
	$search_rows['persons']=array();
	$search_rows['addresses']=array();
	$search_rows['emails']=array();
	$search_rows['numbers']=array();
	$search_rows['social']=array();
	$search_rows['www']=array();
	
	if(isset($_POST['search_rows']))
	{
		$search_rows=array_merge($search_rows, $_POST['search_rows']);
	}
		
	//Ausgabe
	if($_POST['query']!="")
	{
		echo "<tr class='tablehead'>
				<td nowrap width='10px'>".$lang['search_contact']."</td>
				<td>".$lang['search_found']."</td>
			</tr>";
		$results=$person->search(false, $_POST['query'], $search_rows);
		if(count($results[0])>0)
		{
			$all_entries=count($results[0]);
			$show_to=$limit[0]+$limit[1];
			if($show_to>=$all_entries)
			{
				$show_to=$all_entries;
			}
			for($i=$limit[0]; $i<$show_to; $i++)
			{
				$result=$results[0][$i];
				$output1=$result['firstname']." <b>".$result['lastname']."</b>";
				$output2="";
				if(isset($result['string']))
				{
					$output2=$result['string'];
				}
				else
				{
					$output2=$result['lastname'];
					$search1=explode("</span>", $result['firstname']);
					$search2=explode("</span>", $result['lastname']);
					if(count($search1)>1)
					{
						$output2=$result['firstname'];
						if(count($search2)>1)
						{
							$output2.=" ".$result['lastname'];
						}
					}
				}
				echo "<tr>
						<td nowrap style='padding-right:30px;'><span class='personLink' onClick=\"load_show_person('".$result['ID']."', '".$result['found_in']."');\">".$output1."</span></td>
						<td>".$output2."</td>
					</tr>";
			}
			echo "<tr class='tablehead' style='border-top:1px solid #999;'>
					<td colspan='5' align='center''>";
			$i=1;
			$now=0;
			while($now<$all_entries)
			{
				if(!($limit[0]>=$now AND $limit[0]<($now+$limit[1])))
				{
					echo "<span class='personLink' onClick=\"ext_search('".$now.",".$limit[1]."');\">";
				}
				echo $i;
				if(!($limit[0]>=$now AND $limit[0]<($now+$limit[1])))
				{
					echo "</span>";
				}
				echo "&nbsp;&nbsp;&nbsp;";
				$i++;
				$now=$now+$limit[1];
			}
			echo "(".$all_entries." ".$lang['how_many_found'].")</td>
				</tr>";
		}
		else
		{
			echo "<tr>
					<td colspan='5' align='center'>".$lang['search_no_data']."</td>
				</tr>";
		}
	}
	else
	{
		echo "<tr>
				<td colspan='5' align='center'>".$lang['search_no_query']."</td>
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