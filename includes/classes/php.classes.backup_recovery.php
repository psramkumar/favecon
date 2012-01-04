<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* * * * * * * *																								* * * * * * * *
	* * * * * * * *		   	 	   Alle benötigten Klassen-Funktionen für das Import & Export 					* * * * * * * *
	* * * * * * * *		   	    			 	 (Klassenname: "backupRecovery")								* * * * * * * *
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
	class backupRecovery
	{	
		//Adde Telefonnummer
		function addPhoneNumber($id, $data)
		{
			if($data['number']!="")
			{
				$number['number']=encode($data['number'], $_SESSION['uhash']);
				if(get_magic_quotes_gpc())
					$number['number']=stripslashes($number['number']);
				$number['type']=$data['number_type'];
			}
			//Füge neue Nummer ein
			$number_done=true;
			$sql="INSERT INTO ".PERSONS_NUMBERS_TBL."(pid, ntid, number) VALUES('".$id."', '".$number['type']."', '".mysql_real_escape_string($number['number'])."')";
			$ins=mysql_query($sql);
			
			if(!$ins)
			{
				$number_done=false;
			}
			return $number_done;
		}
		
		//Add Adress
		function addAddress($id, $data)
		{
			if($data['street']!="")
			{
				$address['street']=encode($data['street'], $_SESSION['uhash']);
				$address['plz']="";
				if($data['plz'][$i]!="")
				{
					$address['plz']=encode($data['plz'], $_SESSION['uhash']);
				}
				$address['city']="";
				if($data['city']!="")
				{
					$address['city']=encode($data['city'], $_SESSION['uhash']);
				}
				if(get_magic_quotes_gpc())
					foreach(array_keys($address) as $key)
						$address[$key]=stripslashes($address[$key]);
				$address['state_code']=$data['country'];
			}
			//Füge neue Adresse ein
			$address_done=true;
			$sql="INSERT INTO ".PERSONS_ADDRESSES_TBL."(pid, street, plz, city, state_code) VALUES('".$id."', '".mysql_real_escape_string($address['street'])."', '".mysql_real_escape_string($address['plz'])."', '".mysql_real_escape_string($address['city'])."', '".$address['state_code']."')";
			$ins=mysql_query($sql);
			
			if(!$ins)
			{
				$address_done=false;
			}
			return $address_done;
		}
		
		//Add Website
		function addWebsite($id, $data)
		{
			if($data['website_url']!="")
			{
				$url1=explode("http://", $data['website_url']);
				$url=$url1[0];
				if(isset($url1[1]))
				{
					$url=$url1[1];
				}
				$website['url']=encode($url, $_SESSION['uhash']);
				$website['info']="";
				if($data['website_info']!="")
				{
					$website['info']=encode($data['website_info'], $_SESSION['uhash']);
				}
				if(get_magic_quotes_gpc())
					foreach(array_keys($website) as $key)
						$website[$key]=stripslashes($website[$key]);
			}
			//Füge neue Website ein
			$website_done=true;
			$sql="INSERT INTO ".PERSONS_WEBSITES_TBL."(pid, url, infoText) VALUES('".$id."', '".mysql_real_escape_string($website['url'])."', '".mysql_real_escape_string($website['info'])."')";
			$ins=mysql_query($sql);
			
			if(!$ins)
			{
				$website_done=false;
			}
			return $website_done;
		}
		
		//Add E-Mail
		function addEmail($id, $data)
		{
			if($data['email_url']!="")
			{
				$email['url']=encode($data['email_url'], $_SESSION['uhash']);
				$email['info']="";
				if($data['email_info']!="")
				{
					$email['info']=encode($data['email_info'], $_SESSION['uhash']);
				}
				if(get_magic_quotes_gpc())
					foreach(array_keys($email) as $key)
						$email[$key]=stripslashes($email[$key]);
			}
			//Füge neue E-Mails ein
			$email_done=true;
			$email_ids=array();
			$sql="INSERT INTO ".PERSONS_EMAILS_TBL."(pid, email, infoText) VALUES('".$id."', '".mysql_real_escape_string($email['url'])."', '".mysql_real_escape_string($email['info'])."')";
			$ins=mysql_query($sql);
			
			if(!$ins)
			{
				$email_done=false;
			}
			return $email_done;
		}
		
		//Add Social Networking
		function addSocialCom($id, $data)
		{
			$ok=false;
			if($data['type']!="")
			{
				$socialcom['type']=$data['type'];
				$socialcom['uname']="";
				if($data['uname']!="")
				{
					$socialcom['uname']=encode($data['uname'], $_SESSION['uhash']);
				}
				$socialcom['fb_pid']="";
				if($data['fb_pid']!="")
				{
					$socialcom['fb_pid']=encode($data['fb_pid'], $_SESSION['uhash']);
				}
				$socialcom['praefix']=$data['praefix'];
				$socialcom['info']="";
				if($data['info']!="")
				{
					$socialcom['info']=encode($data['info'], $_SESSION['uhash']);
				}
				if($data['uname']!="" OR $data['fb_pid']!="")
				{
					$ok=true;
					if(get_magic_quotes_gpc())
						foreach(array_keys($socialcom) as $key)
							$socialcom[$key]=stripslashes($socialcom[$key]);
				}
			}
			//Füge neue Social Coms ein
			$socialcom_done=true;
			if($ok)
			{
				$sql="INSERT INTO ".PERSONS_SOCIALCOM_TBL."(pid, soctid, uname, fb_pid, praefixNo, infoText) VALUES('".$id."', '".$socialcom['type']."', '".mysql_real_escape_string($socialcom['uname'])."', '".mysql_real_escape_string($socialcom['fb_pid'])."', '".mysql_real_escape_string($socialcom['praefix'])."', '".mysql_real_escape_string($socialcom['info'])."')";
				$ins=mysql_query($sql);
				
				if(!$ins)
				{
					$socialcom_done=false;
				}
			}
			return $socialcom_done;
		}
		
	}
	//Ende Klassendefinition
?>