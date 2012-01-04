<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* * * * * * * *																								* * * * * * * *
	* * * * * * * *		   	 	   Alle benötigten Klassen-Funktionen für die user-Daten	 					* * * * * * * *
	* * * * * * * *		   	    			 	 (Klassenname: "user")											* * * * * * * *
	* * * * * * * *													       		 								* * * * * * * *
	* * * * * * * *						   Written 2010-2011 by Daniel Mühlbachler  							* * * * * * * *
	* * * * * * * *			    	    Copyright (C) 2010-2011 by Daniel Mühlbachler  							* * * * * * * *
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
	class user
	{	
		//Vars
		var $data;
		var $gid;
		var $username;
		var $settings;
		var $sys_settings;
		
		//Speichere Userdaten
		function user()
		{
			$this->get_userdata();
			$this->get_settings();
			$this->get_usersettings();
		}
		
		//Hole Userdaten
		function get_userdata()
		{
			$sql="SELECT ".USERS_DATA_TBL.".firstname, ".USERS_DATA_TBL.".lastname, ".USERS_DATA_TBL.".title, ".USERS_DATA_TBL.".email, ".USERS_DATA_TBL.".bday, ".USERS_TBL.".gid, ".USERS_TBL.".username FROM ".USERS_DATA_TBL.", ".USERS_TBL." WHERE ".USERS_TBL.".ID='".$_SESSION['uid']."' AND ".USERS_DATA_TBL.".uid=".USERS_TBL.".ID";
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data))
			{
				if(get_magic_quotes_gpc())
					foreach(array_keys($row) as $key)
						$row[$key]=stripslashes($row[$key]);
				
				$this->data['firstname']=$row['firstname'];
				$this->data['lastname']=$row['lastname'];
				$this->data['title']=$row['title'];
				$this->data['email']=$row['email'];
				$this->data['bday']=$row['bday'];
				$this->gid=$row['gid'];
				$this->username=$row['username'];
			}
		}
		
		//Hole generelle Settings -> werden durch Usersettings ev. überschrieben
		function get_settings()
		{
			$sql="SELECT var, val FROM ".SETTINGS_TBL;
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data))
			{
				$this->settings[$row['var']]=$row['val'];
				$this->sys_settings[$row['var']]=$row['val'];
			}
		}
		
		//Hole Settings des Users
		function get_usersettings()
		{
			$sql="SELECT var, val FROM ".USERS_SETTINGS_TBL." WHERE uid='".$_SESSION['uid']."'";
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data))
			{
				$this->settings[$row['var']]=$row['val'];
			}
		}
		
		//Hole Languages, die verfügbar sind
		function get_langs($pre)
		{
			$info=array();
			$file=file($pre."translations/translations.txt");
			foreach($file as $z)
			{
				$z=explode(";", trim($z));
				$entry['abbr']=$z[0];
				$entry['language']=$z[1];
				$entry['iso2']=$z[2];
				$info[]=$entry;
			}
			return $info;
		}
		
		//Update User Infos
		function updateUserInfos($data)
		{
			$done=false;
			
			if(get_magic_quotes_gpc())
				foreach(array_keys($data) as $key)
					$data[$key]=stripslashes($data[$key]);
			
			$sql="UPDATE ".USERS_DATA_TBL." SET firstname='".mysql_real_escape_string($data['firstname'])."', lastname='".mysql_real_escape_string($data['lastname'])."', title='".mysql_real_escape_string($data['title'])."', email='".mysql_real_escape_string($data['email'])."', bday='".mysql_real_escape_string($data['bday'])."' WHERE uid='".$_SESSION['uid']."'";
			$update=mysql_query($sql);
			
			$sql1="SELECT uid FROM ".USERS_DATA_TBL." WHERE uid='".$_SESSION['uid']."' AND firstname='".mysql_real_escape_string($data['firstname'])."' AND lastname='".mysql_real_escape_string($data['lastname'])."' AND title='".mysql_real_escape_string($data['title'])."' AND email='".mysql_real_escape_string($data['email'])."' AND bday='".mysql_real_escape_string($data['bday'])."'";
			$data1=mysql_query($sql1);
			
			if(mysql_num_rows($data1))
			{
				$done=true;
			}
			return $done;
		}
		
		//Update Settings
		function updateSettings($data)
		{
			$done=true;
			//Delete all
			$sql="DELETE FROM ".USERS_SETTINGS_TBL." WHERE uid='".$_SESSION['uid']."'";
			$del=mysql_query($sql);
			//Füge ein
			foreach(array_keys($data) as $key)
			{
				if(get_magic_quotes_gpc())
					$data[$key]=stripslashes($data[$key]);
				$sql="INSERT INTO ".USERS_SETTINGS_TBL."(uid, var, val) VALUES('".$_SESSION['uid']."', '".$key."', '".$data[$key]."')";
				$ins=mysql_query($sql);
				
				if(!$ins)
				{
					$done=false;
				}
			}
			return $done;
		}
		
		//Statistik
		function get_statistics($id="")
		{
			if($id=="")
			{
				$id=$_SESSION['uid'];
			}
			
			$info=array();
			$info['logins']=array();
			$info['persons']=0;
			$info['addresses']=0;
			$info['emails']=0;
			$info['numbers']=0;
			$info['socialcom']=0;
			$info['websites']=0;
			
			$tables=array();
			$tables[0]['table']=PERSONS_ADDRESSES_TBL;
			$tables[0]['index']="addresses";
			$tables[1]['table']=PERSONS_EMAILS_TBL;
			$tables[1]['index']="emails";
			$tables[2]['table']=PERSONS_NUMBERS_TBL;
			$tables[2]['index']="numbers";
			$tables[3]['table']=PERSONS_SOCIALCOM_TBL;
			$tables[3]['index']="socialcom";
			$tables[4]['table']=PERSONS_WEBSITES_TBL;
			$tables[4]['index']="websites";
			
			//Hole Login-infos
			$sql="SELECT created_at, last_old_login, last_login, logins FROM ".USERS_TBL." WHERE ID='".$id."'";
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data))
			{
				$info['logins']['created_at']=$row['created_at'];
				$info['logins']['last_old_login']=$row['last_old_login'];
				$info['logins']['last_login']=$row['last_login'];
				$info['logins']['logins']=$row['logins'];
			}
			
			//Hole alle Kontakte
			$sql="SELECT ID FROM ".PERSONS_TBL." WHERE uid='".$id."'";
			$data=mysql_query($sql);
			$info['persons']=mysql_num_rows($data);
			if(mysql_num_rows($data))
			{	
				while($row=mysql_fetch_assoc($data))
				{
					foreach($tables as $table)
					{
						$sql1="SELECT COUNT(ID) AS counting FROM ".$table['table']." WHERE pid='".$row['ID']."'";
						$data1=mysql_query($sql1);
						$count=0;
						while($row1=mysql_fetch_assoc($data1))
						{
							$count=$row1['counting'];
						}
						$info[$table['index']]=$info[$table['index']]+$count;
					}
				}
			}
			return $info;
		}
		
		//Hole related news
		function get_news($limit="", $id="")
		{
			$news=array();
			$exist=false;
			
			if($id="")
			{
				$id=$_SESSION['uid'];
			}
			
			$sql="SELECT ".NEWS_TBL.".ID, m_header, m_body, m_time, username, firstname, lastname FROM ".NEWS_TBL.", ".USERS_TBL.", ".USERS_DATA_TBL." WHERE ".USERS_TBL.".ID=".NEWS_TBL.".submitted_by AND ".USERS_TBL.".ID=".USERS_DATA_TBL.".uid AND for_gid>='".$this->gid."' ORDER BY m_time DESC";
			if($limit!="")
			{
				$sql.=" LIMIT 0,".$limit;
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
					$news[]=$entry;
				}
			}
			return array($exist, $news);
		}
		
		//Hole eine News
		function get_news_id($id)
		{
			$sql="SELECT m_header, m_body, m_time, username, firstname, lastname FROM ".NEWS_TBL.", ".USERS_TBL.", ".USERS_DATA_TBL." WHERE ".NEWS_TBL.".ID='".$id."' AND ".USERS_TBL.".ID=".NEWS_TBL.".submitted_by AND ".USERS_TBL.".ID=".USERS_DATA_TBL.".uid";
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data))
			{
				if(get_magic_quotes_gpc())
					foreach(array_keys($row) as $key)
						$row[$key]=stripslashes($row[$key]);
				return $row;
			}
		}
		
	}
	//Ende Klassendefinition
?>