<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* * * * * * * *																								* * * * * * * *
	* * * * * * * *		   	 	   Alle benötigten Klassen-Funktionen für das User Management 					* * * * * * * *
	* * * * * * * *		   	    			 	 (Klassenname: "user_mngmnt")									* * * * * * * *
	* * * * * * * *													       		 								* * * * * * * *
	* * * * * * * *							Written 2010-2011 by Daniel Mühlbachler  							* * * * * * * *
	* * * * * * * *			    	     Copyright (C) 2010-2011 by Daniel Mühlbachler  						* * * * * * * *
	* * * * * * * *											   		    										* * * * * * * *
	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

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
	
	*/


	//Beginn Klassendefinition
	class user_mngmnt
	{	
		//Hole alle User incl. Stammdaten
		function get_users($order='username', $order_type='ASC', $query="", $limit="")
		{
			$info=array();
			$exist=false;
			if(get_magic_quotes_gpc())
				$query=stripslashes($query);
			//Hole angeforderte Daten
			$sql="SELECT ".USERS_TBL.".ID, ".USERS_TBL.".username, ".USERS_TBL.".gid, ".USERS_TBL.".enabled, ".USERS_TBL.".comment, ".USERS_DATA_TBL.".firstname, ".USERS_DATA_TBL.".lastname, ".USERS_DATA_TBL.".email, ".USERS_DATA_TBL.".bday, ".USERS_DATA_TBL.".title FROM ".USERS_TBL.", ".USERS_DATA_TBL." WHERE ".USERS_TBL.".ID=".USERS_DATA_TBL.".uid AND ".USERS_TBL.".ID!='1'";
			if($query!="")
			{
				$sql.=" AND (".USERS_TBL.".username LIKE '%".mysql_real_escape_string($query)."%' OR ".USERS_DATA_TBL.".firstname LIKE '%".mysql_real_escape_string($query)."%' OR ".USERS_DATA_TBL.".lastname LIKE '%".mysql_real_escape_string($query)."%' OR ".USERS_DATA_TBL.".email LIKE '%".mysql_real_escape_string($query)."%')";
			}
			$sql.=" ORDER BY ".USERS_TBL.".".$order." ".$order_type;
			if($limit!="")
			{
				$sql.=" LIMIT ".$limit;
			}
			$data=mysql_query($sql);
			if(mysql_num_rows($data))
			{
				$exist=true;
				while($row=mysql_fetch_assoc($data))
				{
					foreach(array_keys($row) as $key)
					{
						$entry[$key]=$row[$key];
						if(get_magic_quotes_gpc())
							$entry[$key]=stripslashes($entry[$key]);
					}
					$info[]=$entry;
				}
			}
			//Count Seiten
			$sql="SELECT COUNT(ID) AS counting FROM ".USERS_TBL.", ".USERS_DATA_TBL." WHERE ".USERS_TBL.".ID=".USERS_DATA_TBL.".uid AND ".USERS_TBL.".ID!='1'";
			if($query!="")
			{
				$sql.=" AND (".USERS_TBL.".username LIKE '%".mysql_real_escape_string($query)."%' OR ".USERS_DATA_TBL.".firstname LIKE '%".mysql_real_escape_string($query)."%' OR ".USERS_DATA_TBL.".lastname LIKE '%".mysql_real_escape_string($query)."%' OR ".USERS_DATA_TBL.".email LIKE '%".mysql_real_escape_string($query)."%')";
			}
			$sql.=" ORDER BY ".$order." ".$order_type;
			$data=mysql_query($sql);
			$limit=explode(",", $limit);
			$now=$limit[0];
			$limit=$limit[1];
			while($row=mysql_fetch_assoc($data))
			{
				$howmany=$row['counting'];
			}
			$limits=array();
			$start=0;
			while($start<$howmany)
			{
				$newlimit[0]=$start.",".$limit;
				$newlimit[1]=false;
				//Wenn aktuelle Seite, markiere diese
				if($now>=$start AND $now<($start+$limit))
				{
					$newlimit[1]=true;
				}
				$limits[]=$newlimit;
				$start=$start+$limit;
			}
			return array($exist, $info, $limits, $howmany);
		}
		
		//Hole Gruppen
		function get_groups()
		{
			$info=array();
			$sql="SELECT ID, name FROM ".USERS_GROUPS_TBL." ORDER BY ID ASC";
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data))
			{
				$entry['gid']=$row['ID'];
				$entry['gname']=$row['name'];
				$info[$row['ID']]=$entry;
			}
			return $info;
		}
		
		//User-Infos
		function get_user_details($id)
		{
			$entry=array();
			$sql="SELECT ".USERS_TBL.".ID, ".USERS_TBL.".username, ".USERS_TBL.".gid, ".USERS_TBL.".enabled, ".USERS_TBL.".comment, ".USERS_DATA_TBL.".firstname, ".USERS_DATA_TBL.".lastname, ".USERS_DATA_TBL.".email, ".USERS_DATA_TBL.".bday, ".USERS_DATA_TBL.".title FROM ".USERS_TBL.", ".USERS_DATA_TBL." WHERE ".USERS_TBL.".ID=".USERS_DATA_TBL.".uid AND ".USERS_TBL.".ID='".$id."'";
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data))
			{
				foreach(array_keys($row) as $key)
				{
					$entry[$key]=$row[$key];
					if(get_magic_quotes_gpc())
						$entry[$key]=stripslashes($entry[$key]);
				}
			}
			return $entry;
		}
		
		//Adde User
		function addUser($data)
		{
			$done=false;
			
			if(get_magic_quotes_gpc())
				foreach(array_keys($data) as $key)
					$data[$key]=stripslashes($data[$key]);
			
			$sql="INSERT INTO ".USERS_TBL."(username, passwd, user_hash, gid, created_at, enabled, comment) VALUES('".mysql_real_escape_string($data['username'])."', '".md5($data['passwd'])."', '".create_hash(mysql_real_escape_string($data['username']))."', '".$data['gid']."', '".time()."', '".$data['enabled']."', '".mysql_real_escape_string($data['comment'])."')";
			$insert=mysql_query($sql);
			
			$sql1="SELECT ID FROM ".USERS_TBL." WHERE username='".mysql_real_escape_string($data['username'])."' AND passwd='".md5($data['passwd'])."' AND gid='".$data['gid']."'";
			$exist=mysql_query($sql1);
			if(mysql_num_rows($exist))
			{
				while($row=mysql_fetch_assoc($exist))
				{
					$id=$row['ID'];
				}
				$sql2="INSERT INTO ".USERS_DATA_TBL."(uid, firstname, lastname, title, email, bday) VALUES('".$id."', '".mysql_real_escape_string($data['firstname'])."', '".mysql_real_escape_string($data['lastname'])."', '".mysql_real_escape_string($data['title'])."', '".mysql_real_escape_string($data['email'])."', '".mysql_real_escape_string($data['bday'])."')";
				$insert1=mysql_query($sql2);
				
				$sql3="SELECT uid FROM ".USERS_DATA_TBL." WHERE uid='".$id."' AND firstname='".mysql_real_escape_string($data['firstname'])."' AND lastname='".mysql_real_escape_string($data['lastname'])."' AND title='".mysql_real_escape_string($data['title'])."' AND email='".mysql_real_escape_string($data['email'])."' AND bday='".mysql_real_escape_string($data['bday'])."'";
				$exist2=mysql_query($sql3);
				
				if($exist2)
				{
					$done=true;
				}
			}
			return $done;
		}
		
		//Lösche User
		function delUser($id)
		{
			$done=false;
			$sql="SELECT ID FROM ".PERSONS_TBL." WHERE uid='".$id."'";
			$data=mysql_query($sql);
			$done1=true;
			if(mysql_num_rows($data))
			{
				while($row=mysql_fetch_assoc($data))
				{
					$done1=false;
					$id=$row['ID'];
					$sql="DELETE FROM ".PERSONS_WEBSITES_TBL." WHERE pid='".$id."'";
					$del=mysql_query($sql);
					if($del)
					{
						$sql1="DELETE FROM ".PERSONS_SOCIALCOM_TBL." WHERE pid='".$id."'";
						$del1=mysql_query($sql1);
						if($del1)
						{
							$sql2="DELETE FROM ".PERSONS_NUMBERS_TBL." WHERE pid='".$id."'";
							$del2=mysql_query($sql2);
							if($del2)
							{
								$sql3="DELETE FROM ".PERSONS_EMAILS_TBL." WHERE pid='".$id."'";
								$del3=mysql_query($sql3);
								if($del3)
								{
									$sql4="DELETE FROM ".PERSONS_ADDRESSES_TBL." WHERE pid='".$id."'";
									$del4=mysql_query($sql4);
									if($del4)
									{
										$sql5="DELETE FROM ".PERSONS_TBL." WHERE ID='".$id."'";
										$delete=mysql_query($sql5);
										if($delete)
										{
											$done1=true;
										}
									}
								}
							}
						}
					}
				}
			}
			
			if($done1)
			{
				$sql="DELETE FROM ".USERS_DATA_TBL." WHERE uid='".$id."'";
				$del1=mysql_query($sql);
				
				$sql1="DELETE FROM ".USERS_SETTINGS_TBL." WHERE uid='".$id."'";
				$del2=mysql_query($sql1);
				
				$sql2="DELETE FROM ".USERS_TBL." WHERE ID='".$id."'";
				$del3=mysql_query($sql2);
				
				if($del1 AND $del2 AND $del3)
				{
					$done=true;
				}
			}
			return $done;
		}
		
		//Update User Infos
		function updateUserInfos($id, $data)
		{
			$done=false;
			
			if(get_magic_quotes_gpc())
				foreach(array_keys($data) as $key)
					$data[$key]=stripslashes($data[$key]);
			
			$sql="UPDATE ".USERS_DATA_TBL." SET firstname='".mysql_real_escape_string($data['firstname'])."', lastname='".mysql_real_escape_string($data['lastname'])."', title='".mysql_real_escape_string($data['title'])."', email='".mysql_real_escape_string($data['email'])."', bday='".mysql_real_escape_string($data['bday'])."' WHERE uid='".$id."'";
			$update=mysql_query($sql);
			
			$sql="UPDATE ".USERS_TBL." SET username='".mysql_real_escape_string($data['username'])."', gid='".$data['gid']."', enabled='".$data['enabled']."', comment='".mysql_real_escape_string($data['comment'])."' WHERE ID='".$id."'";
			$update=mysql_query($sql);
			
			$sql1="SELECT uid FROM ".USERS_DATA_TBL." WHERE uid='".$id."' AND firstname='".mysql_real_escape_string($data['firstname'])."' AND lastname='".mysql_real_escape_string($data['lastname'])."' AND title='".mysql_real_escape_string($data['title'])."' AND email='".mysql_real_escape_string($data['email'])."' AND bday='".mysql_real_escape_string($data['bday'])."'";
			$data1=mysql_query($sql1);
			
			$sql2="SELECT ID FROM ".USERS_TBL." WHERE ID='".$id."' AND username='".mysql_real_escape_string($data['username'])."' AND gid='".$data['gid']."'";
			$data2=mysql_query($sql2);
			
			if(mysql_num_rows($data1) AND mysql_num_rows($data2))
			{
				$done=true;
			}
			return $done;
		}
		
	}
	//Ende Klassendefinition
?>