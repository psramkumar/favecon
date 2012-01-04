<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* * * * * * * *																								* * * * * * * *
	* * * * * * * *		   	 Alle benötigten Klassen-Funktionen für die Analyse der Login-Infos					* * * * * * * *
	* * * * * * * *		   	    			 	 (Klassenname: "login")											* * * * * * * *
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
	class login
	{	
		//Vars
		var $logged_in;
		
		//Wenn Infos bestehen -> Check; false oder keine Infos -> Login
		function login()
		{
			$logged_in=false;
			if(isset($_SESSION['uid']) AND isset($_SESSION['uhash']))
			{
				$sql="SELECT username FROM ".USERS_TBL." WHERE ID='".$_SESSION['uid']."' AND user_hash='".$_SESSION['uhash']."' AND enabled='1'";
				$check=mysql_query($sql);
				if(mysql_num_rows($check))
				{
					$logged_in=true;
				}
				else
				{
					unset($_SESSION['uid']);
					unset($_SESSION['uhash']);
				}
			}
			
			$this->logged_in=$logged_in;
		}
		
		//Checke login-Daten
		function check_login($vars)
		{
			$exist=false;
			$uid=0;
			$enabled=0;
			
			if(get_magic_quotes_gpc())
				foreach(array_keys($vars) as $key)
					$vars[$key]=stripslashes($vars[$key]);
			
			$sql="SELECT ID, enabled FROM ".USERS_TBL." WHERE username='".mysql_real_escape_string($vars['user'])."' AND passwd='".md5($vars['passwd'])."'";
			$data=mysql_query($sql);
			//Wenn Daten da, hole uid
			if(mysql_num_rows($data))
			{
				$exist=true;
				while($row=mysql_fetch_assoc($data))
				{
					$uid=$row['ID'];
					$enabled=$row['enabled'];
				}
			}
			return array($exist, $uid, $enabled);
		}
		
		//Update login times & logins
		function update_login_data($uid)
		{
			$sql="UPDATE ".USERS_TBL." SET last_old_login=last_login, last_login='".time()."', logins=(logins+1) WHERE ID='".$uid."'";
			$upd=mysql_query($sql);
		}
		
		//Führe Login durch
		function perform_login($uid)
		{
			$this->update_login_data($uid);
			$uhash=get_userhash($uid);
			$_SESSION['uid']=$uid;
			$_SESSION['uhash']=$uhash;
		}
		
		//Führe Logout durch
		function perform_logout()
		{
			unset($_SESSION['uid']);
			unset($_SESSION['uhash']);
			$this->logged_in=false;
		}
		
	}
	//Ende Klassendefinition
?>