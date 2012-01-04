<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* * * * * * * *																								* * * * * * * *
	* * * * * * * *		   	 	   Alle benötigten Klassen-Funktionen für das News Management 					* * * * * * * *
	* * * * * * * *		   	    			 	 (Klassenname: "news_mngmnt")									* * * * * * * *
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
	class news_mngmnt
	{	
		//Hole alle User incl. Stammdaten
		function get_news($order='m_time', $order_type='DESC', $query="", $limit="")
		{
			$info=array();
			$exist=false;
			//Hole angeforderte Daten
			if(get_magic_quotes_gpc())
				$query=stripslashes($query);
			$sql="SELECT ".NEWS_TBL.".ID, m_header, m_body, m_time, for_gid, username, firstname, lastname FROM ".NEWS_TBL.", ".USERS_TBL.", ".USERS_DATA_TBL." WHERE ".USERS_TBL.".ID=".NEWS_TBL.".submitted_by AND ".USERS_TBL.".ID=".USERS_DATA_TBL.".uid";
			if($query!="")
			{
				$sql.=" AND (".NEWS_TBL.".m_header LIKE '%".mysql_real_escape_string($query)."%' OR ".NEWS_TBL.".m_time LIKE '%".mysql_real_escape_string($query)."%')";
			}
			$sql.=" ORDER BY ".NEWS_TBL.".".$order." ".$order_type;
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
			$sql="SELECT COUNT(ID) AS counting FROM ".NEWS_TBL;
			if($query!="")
			{
				$sql.=" WHERE (".NEWS_TBL.".m_header LIKE '%".mysql_real_escape_string($query)."%' OR ".NEWS_TBL.".m_time LIKE '%".mysql_real_escape_string($query)."%')";
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
		
		//Hole eine news
		function get_news_id($id)
		{
			$entry=array();
			$sql="SELECT m_header, m_body, for_gid FROM ".NEWS_TBL." WHERE ID='".$id."'";
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
		
		//Adde News
		function addNews($data)
		{
			$done=false;
			
			if(get_magic_quotes_gpc())
				for($i=0; $i<count($data); $i++)
					$data[$i]=stripslashes($data[$i]);
			$sql="INSERT INTO ".NEWS_TBL."(m_header, m_body, m_time, for_gid, submitted_by) VALUES('".mysql_real_escape_string($data['m_header'])."', '".mysql_real_escape_string($data['m_body'])."', '".time()."', '".$data['for_gid']."', '".$_SESSION['uid']."')";
			$insert=mysql_query($sql);echo $sql;
			
			if($insert)
			{
				$done=true;
			}
			return $done;
		}
		
		//Lösche News
		function delNews($id)
		{
			$done=false;
			$sql="DELETE FROM ".NEWS_TBL." WHERE ID='".$id."'";
			$data=mysql_query($sql);
			if($data)
			{
				$done=true;
			}
			return $done;
		}
		
		//Update News
		function updateNews($id, $data)
		{
			$done=false;
			
			if(get_magic_quotes_gpc())
				for($i=0; $i<count($data); $i++)
					$data[$i]=stripslashes($data[$i]);
			$sql="UPDATE ".NEWS_TBL." SET m_header='".mysql_real_escape_string($data['m_header'])."', m_body='".mysql_real_escape_string($data['m_body'])."', for_gid='".$data['for_gid']."' WHERE ID='".$id."'";
			$update=mysql_query($sql);
			
			if($update)
			{
				$done=true;
			}
			return $done;
		}
		
	}
	//Ende Klassendefinition
?>