<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* * * * * * * *																								* * * * * * * *
	* * * * * * * *		   	 	   Alle benötigten Klassen-Funktionen für die person-Daten	 					* * * * * * * *
	* * * * * * * *		   	    			 	 (Klassenname: "person")										* * * * * * * *
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
	class person
	{	
		//Lade Personen zur Ausgabe
		function load_show_persons($settings, $order="", $order_type="")
		{
			//Wenn kein order
			if($order=="")
			{
				$order=$settings['order'];
			}
			//Wenn kein order_type
			if($order_type=="")
			{
				$order_type=$settings['order_type'];
			}
			//2.Order
			$order1="firstname";
			if($order==$order1)
			{
				$order1="lastname";
			}
			//Setze Std-Vars zum "Sortieren" und "Einteilen"
			$exist=false;
			$persons=array();
			$buchstaben=str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
			$ids_set=array();
			foreach($buchstaben as $b)
			{
				$persons[$b]=array();
			}
			//Hole alle Daten - ORDER
			$sql="SELECT ID, firstname, lastname, title FROM ".PERSONS_TBL." WHERE uid='".$_SESSION['uid']."' AND ".$order."!='' ORDER BY ".$order." ".$order_type;
			$data=mysql_query($sql);
			//Wenn Daten existieren...
			if(mysql_num_rows($data))
			{
				$exist=true;
				//Hole nun jeden Buchstaben einzeln und erzeuge Array (mit oder ohne Daten)...
				foreach($buchstaben as $b)
				{
					$sql1="SELECT ID, firstname, lastname, title FROM ".PERSONS_TBL." WHERE uid='".$_SESSION['uid']."' AND ".$order." LIKE '".encode($b, $_SESSION['uhash'])."%' ORDER BY ".$order." ".$order_type;
					$data1=mysql_query($sql1);
					if(mysql_num_rows($data1))
					{
						while($row=mysql_fetch_assoc($data1))
						{
							$ids_set[]=$row['ID'];
							$persons[$b][]=$this->get_show_persons_type($settings['show_persons'], $row);
						}
					}
				}
				//Nun alle restlichen mit Sonderzeichen
				$persons['#']=array();
				while($row=mysql_fetch_assoc($data))
				{
					if(!in_array($row['ID'], $ids_set))
					{
						$persons['#'][]=$this->get_show_persons_type($settings['show_persons'], $row);
					}
				}
			}
			//Hole alle Daten ORDER1
			$sql="SELECT ID, firstname, lastname, title FROM ".PERSONS_TBL." WHERE uid='".$_SESSION['uid']."' AND ".$order."='' ORDER BY ".$order1." ".$order_type;
			$data=mysql_query($sql);
			//Wenn Daten existieren...
			if(mysql_num_rows($data))
			{
				$exist=true;
				//Hole nun jeden Buchstaben einzeln und erzeuge Array (mit oder ohne Daten)...
				foreach($buchstaben as $b)
				{
					$sql1="SELECT ID, firstname, lastname, title FROM ".PERSONS_TBL." WHERE uid='".$_SESSION['uid']."' AND ".$order."='' AND ".$order1." LIKE '".encode($b, $_SESSION['uhash'])."%' ORDER BY ".$order." ".$order_type;
					$data1=mysql_query($sql1);
					if(mysql_num_rows($data1))
					{
						while($row=mysql_fetch_assoc($data1))
						{
							$ids_set[]=$row['ID'];
							$persons[$b][]=$this->get_show_persons_type($settings['show_persons1'], $row);
						}
					}
				}
				//Nun alle restlichen mit Sonderzeichen
				$persons['#']=array();
				while($row=mysql_fetch_assoc($data))
				{
					if(!in_array($row['ID'], $ids_set))
					{
						$persons['#'][]=$this->get_show_persons_type($settings['show_persons1'], $row);
					}
				}
			}
			return array($exist, $persons);
		}
		
		//Wandle Ausgabe der Personen in Settings-spezifischen Type um
		function get_show_persons_type($type, $vars)
		{
			//explode in auszugebende Teile
			$type=explode("/", $type);
			$newtype="";
			foreach($type as $part)
			{
				//Wenn keine Zusatzoptionen -> fertig mit dem Part, else...
				if(array_key_exists($part, $vars))
				{
					$add=$vars[$part];
					if($vars[$part]!="")
					{
						$add=decode($vars[$part], $_SESSION['uhash']);
						if(get_magic_quotes_gpc())
							$add=stripslashes($add);
					}
					$newtype.=$add;
				}
				else
				{
					//Fett
					$part1=explode("*", $part);
					//Kursiv
					$part2=explode("+", $part);
					$done=false;
					//Analyse
					if(count($part1)==2 AND !$done)
					{
						if(array_key_exists($part1[1], $vars))
						{
							if(get_magic_quotes_gpc())
								$vars[$part1[1]]=stripslashes($vars[$part1[1]]);
							if($vars[$part1[1]]!="")
								$newtype.="<b>".decode($vars[$part1[1]], $_SESSION['uhash'])."</b>";
							$done=true;
						}
					}
					if(count($part2)==2 AND !$done)
					{
						if(array_key_exists($part2[1], $vars))
						{
							if(get_magic_quotes_gpc())
								$vars[$part2[1]]=stripslashes($vars[$part2[1]]);
							if($vars[$part2[1]]!="")
								$newtype.="<i>".decode($vars[$part2[1]], $_SESSION['uhash'])."</i>";
							$done=true;
						}
					}
					if($part=="#" AND !$done)
					{
						$newtype.="<br>";
						$done=true;
					}
					if(!$done)
					{
						$newtype.=$part;
					}
				}
			}
			return array("id"=>$vars['ID'], "print"=>$newtype);
		}
		
		//Anfang: Hole Daten-Funktionen
		//Count alle details
		function count_details($id)
		{
			$sql[1]="SELECT COUNT(*) AS anzahl FROM ".PERSONS_ADDRESSES_TBL." WHERE pid='".$id."'";
			$sql[2]="SELECT COUNT(*) AS anzahl FROM ".PERSONS_NUMBERS_TBL." WHERE pid='".$id."'";
			$sql[3]="SELECT COUNT(*) AS anzahl FROM ".PERSONS_EMAILS_TBL." WHERE pid='".$id."'";
			$sql[4]="SELECT COUNT(*) AS anzahl FROM ".PERSONS_WEBSITES_TBL." WHERE pid='".$id."'";
			$sql[5]="SELECT COUNT(*) AS anzahl FROM ".PERSONS_SOCIALCOM_TBL." WHERE pid='".$id."'";
			$count=array();
			for($i=1; $i<=5; $i++)
			{
				$data=mysql_query($sql[$i]);
				while($row=mysql_fetch_assoc($data))
					$count[$i]=$row['anzahl'];
			}
			return array("addresses"=>$count[1], "numbers"=>$count[2], "emails"=>$count[3], "websites"=>$count[4], "socialcom"=>$count[5]);
		}
		
		//General Information
		function get_details_general_info($id)
		{
			$sql="SELECT firstname, lastname, title, bday FROM ".PERSONS_TBL." WHERE ID='".$id."' AND uid='".$_SESSION['uid']."'";
			$data=mysql_query($sql);
			$info=array();
			while($row=mysql_fetch_assoc($data))
			{
				foreach(array_keys($row) as $key)
				{
					$info[$key]=$row[$key];
					if(get_magic_quotes_gpc())
						$info[$key]=stripslashes($info[$key]);
					if($key!="bday" AND $row[$key]!="")
					{
						$info[$key]=decode($row[$key], $_SESSION['uhash']);
					}
				}
			}
			return $info;
		}
		
		//WWW: Websites & E-Mails
		function get_details_www($id)
		{
			$info=array();
			$info['websites']=array();
			$info['emails']=array();
			//Websites
			$sql="SELECT ID, url, infoText FROM ".PERSONS_WEBSITES_TBL." WHERE pid='".$id."'";
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data))
			{
				$url=decode($row['url'], $_SESSION['uhash']);
				$infoText=$row["infoText"];
				if($infoText!="")
				{
					$infoText=decode($infoText, $_SESSION['uhash']);
				}
				if(get_magic_quotes_gpc())
				{
					$url=stripslashes($url);
					$infoText=stripslashes($infoText);
				}
				$entry=array("ID"=>$row['ID'], "url"=>$url, "infoText"=>$infoText);
				$info['websites'][]=$entry;
			}
			//E-Mails
			$sql="SELECT ID, email, infoText FROM ".PERSONS_EMAILS_TBL." WHERE pid='".$id."'";
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data))
			{
				$email=decode($row['email'], $_SESSION['uhash']);
				$infoText=$row["infoText"];
				if($infoText!="")
				{
					$infoText=decode($infoText, $_SESSION['uhash']);
				}
				if(get_magic_quotes_gpc())
				{
					$email=stripslashes($email);
					$infoText=stripslashes($infoText);
				}
				$entry=array("ID"=>$row['ID'], "email"=>$email, "infoText"=>$infoText);
				$info['emails'][]=$entry;
			}
			return $info;
		}
		
		//Social Networking
		function get_details_social_com($id)
		{
			$info=array();
			$data_exists=false;
			//Hole "offizielle" SocialType Daten
			$sql1="SELECT ID, socialtype, weight, link, praefixUsage, prefix1, prefix2, praefix1, praefix2 FROM ".SOCIALTYPES_TBL." ORDER BY weight ASC";
			$stypes=mysql_query($sql1);
			while($row1=mysql_fetch_assoc($stypes))
			{
				//Setze alle Felder als "temporäre" Vars
				foreach(array_keys($row1) as $key)
				{
					$socialtype[$key]=$row1[$key];
				}
				//Hole gespeicherte Social-Coms
				$sql="SELECT ID, uname, fb_pid, praefixNo, infoText FROM ".PERSONS_SOCIALCOM_TBL." WHERE pid='".$id."' AND soctid='".$socialtype['ID']."'";
				$data=mysql_query($sql);
				if(mysql_num_rows($data))
				{
					$data_exists=true;
					$info[$socialtype['socialtype']]=array();
					while($row=mysql_fetch_assoc($data))
					{
						//Setze alle Felder als "temporäre" Vars
						foreach(array_keys($row) as $key)
						{
							$entry[$key]=$row[$key];
						}
						//Entschlüssle alle verschlüsselten Daten
						if($entry['uname']!="")
						{
							$entry['uname']=decode($entry['uname'], $_SESSION['uhash']);
						}
						if($entry['fb_pid']!="")
						{
							$entry['fb_pid']=decode($entry['fb_pid'], $_SESSION['uhash']);
						}
						if($entry['infoText']!="")
						{
							$entry['infoText']=decode($entry['infoText'], $_SESSION['uhash']);
						}
						if(get_magic_quotes_gpc())
							foreach(array_keys($row) as $key)
								$entry[$key]=stripslashes($entry[$key]);
						$entity['infoText']=$entry['infoText'];
						$entity['link_creation']=$socialtype['link'];
						//Wenn zu 100% feststeht, dass es FB ist...
						if($entry['fb_pid']!="")
						{
							$entity['link']=$socialtype['prefix2'].$entry['fb_pid'];
							$entity['uname']="Profile ID: ".$entry['fb_pid'];
							if($entry['uname']!="")
							{
								$entity['uname']=$entry['uname'];
							}
						}
						else
						{
							$entity['link']=$socialtype['prefix1'].$entry['uname'];
							if($socialtype['praefixUsage']==1)
							{
								$entity['link'].=$socialtype['praefix'.$entry['praefixNo']];
							}
							$entity['uname']=$entry['uname'];
						}
						$info[$socialtype['socialtype']][]=$entity;
					}
				}
			}
			return array($data_exists, $info);
		}
		
		//Addresses & Numbers
		function get_details_addresses_numbers($id, $lang)
		{
			$info=array();
			$data_exists=false;
			$data_exists1=false;
			$info['numbers']=array();
			$info['addresses']=array();
			//Hole "offizielle" NumberType Daten
			$sql1="SELECT ID, weight FROM ".NUMBERTYPES_TBL." ORDER BY weight ASC";
			$ntypes=mysql_query($sql1);
			while($row1=mysql_fetch_assoc($ntypes))
			{
				//Setze alle Felder als "temporäre" Vars
				foreach(array_keys($row1) as $key)
				{
					$numbertype[$key]=$row1[$key];
				}
				$numbertype['ntype']=$lang[$row1['ID']];
				//Hole gespeicherte Social-Coms
				$sql="SELECT ID, number FROM ".PERSONS_NUMBERS_TBL." WHERE pid='".$id."' AND ntid='".$numbertype['ID']."'";
				$data=mysql_query($sql);
				if(mysql_num_rows($data))
				{
					$data_exists=true;
					$info['numbers'][$numbertype['ntype']]=array();
					while($row=mysql_fetch_assoc($data))
					{
						//Setze alle Felder als "temporäre" Vars
						foreach(array_keys($row) as $key)
						{
							$entry[$key]=$row[$key];
						}
						//Entschlüssle alle verschlüsselten Daten
						$entity['number']=decode($entry['number'], $_SESSION['uhash']);
						if(get_magic_quotes_gpc())
							$entry['number']=stripslashes($entry['number']);
						$info['numbers'][$numbertype['ntype']][]=$entity;
					}
				}
			}
			//Hole Addresses
			$sql="SELECT ".PERSONS_ADDRESSES_TBL.".ID, ".PERSONS_ADDRESSES_TBL.".street, ".PERSONS_ADDRESSES_TBL.".plz, ".PERSONS_ADDRESSES_TBL.".city, ".PERSONS_ADDRESSES_TBL.".state_code, ".STATES_TBL.".name, ".STATES_TBL.".iso2, ".STATES_TBL.".iso3 FROM ".PERSONS_ADDRESSES_TBL.", ".STATES_TBL." WHERE ".PERSONS_ADDRESSES_TBL.".pid='".$id."' AND ".PERSONS_ADDRESSES_TBL.".state_code=".STATES_TBL.".num_code ORDER BY ".PERSONS_ADDRESSES_TBL.".state_code ASC";
			$data=mysql_query($sql);
			if(mysql_num_rows($data))
			{
				$data_exists1=true;
				while($row=mysql_fetch_assoc($data))
				{
					foreach(array_keys($row) as $key)
					{
						$address[$key]=$row[$key];
					}
					$address['iso2']=strtolower($address['iso2']);
					if($address['street']!="")
					{
						$address['street']=decode($address['street'], $_SESSION['uhash']);
					}
					if($address['plz']!="")
					{
						$address['plz']=decode($address['plz'], $_SESSION['uhash']);
					}
					if($address['city']!="")
					{
						$address['city']=decode($address['city'], $_SESSION['uhash']);
					}
					if(get_magic_quotes_gpc())
					foreach(array_keys($address) as $key)
						$address[$key]=stripslashes($address[$key]);
					$info['addresses'][]=$address;
				}
			}
			return array($data_exists, $data_exists1, $info);
		}
		
		//Social Com Typen
		function get_social_com_types()
		{
			$types=array();
			$sql="SELECT ID, socialtype, fb_pid, praefixUsage, praefix1, praefix2, praefix1Text, praefix2Text, weight FROM ".SOCIALTYPES_TBL." ORDER BY weight ASC";
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data))
			{
				foreach(array_keys($row) as $key)
				{
					$type[$key]=$row[$key];
				}
				$types[$row['ID']]=$type;
			}
			return $types;
		}
		
		//Social Com zum editen
		function get_social_com($id)
		{
			$data_exist=false;
			$info=array();
			$sql="SELECT ".PERSONS_SOCIALCOM_TBL.".soctid, ".PERSONS_SOCIALCOM_TBL.".uname, ".PERSONS_SOCIALCOM_TBL.".fb_pid, ".PERSONS_SOCIALCOM_TBL.".praefixNo, ".PERSONS_SOCIALCOM_TBL.".infoText FROM ".PERSONS_SOCIALCOM_TBL.", ".SOCIALTYPES_TBL." WHERE ".PERSONS_SOCIALCOM_TBL.".pid='".$id."' AND ".PERSONS_SOCIALCOM_TBL.".soctid=".SOCIALTYPES_TBL.".ID ORDER BY ".SOCIALTYPES_TBL.".weight ASC";
			$data=mysql_query($sql);
			if(mysql_num_rows($data))
			{
				$data_exist=true;
				while($row=mysql_fetch_assoc($data))
				{
					$entry['soctid']=$row['soctid'];
					$entry['uname']="";
					if($row['uname']!="")
					{
						$entry['uname']=decode($row['uname'], $_SESSION['uhash']);
						if(get_magic_quotes_gpc())
							$entry['uname']=stripslashes($entry['uname']);
					}
					$entry['fb_pid']="";
					if($row['fb_pid']!="")
					{
						$entry['fb_pid']=decode($row['fb_pid'], $_SESSION['uhash']);
						if(get_magic_quotes_gpc())
							$entry['fb_pid']=stripslashes($entry['fb_pid']);
					}
					$entry['praefixNo']=$row['praefixNo'];
					$entry['infoText']="";
					if($row['infoText']!="")
					{
						$entry['infoText']=decode($row['infoText'], $_SESSION['uhash']);
						if(get_magic_quotes_gpc())
							$entry['infoText']=stripslashes($entry['infoText']);
					}
					$info[]=$entry;
				}
			}
			return array($data_exist, $info);
		}
		
		//Address for GoogleMaps
		function getGoogleMapsAddress($id)
		{
			$sql="SELECT ".PERSONS_ADDRESSES_TBL.".street, ".PERSONS_ADDRESSES_TBL.".plz, ".PERSONS_ADDRESSES_TBL.".city, ".STATES_TBL.".name, ".STATES_TBL.".iso2, ".STATES_TBL.".iso3 FROM ".PERSONS_ADDRESSES_TBL.", ".STATES_TBL." WHERE ".PERSONS_ADDRESSES_TBL.".ID='".$id."' AND ".PERSONS_ADDRESSES_TBL.".state_code=".STATES_TBL.".num_code";
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data))
			{
				if($row['street']!="")
				{
					$row['street']=decode($row['street'], $_SESSION['uhash']);
				}
				if($row['plz']!="")
				{
					$row['plz']=decode($row['plz'], $_SESSION['uhash']);
				}
				if($row['city']!="")
				{
					$row['city']=decode($row['city'], $_SESSION['uhash']);
				}
				if(get_magic_quotes_gpc())
					foreach(array_keys($row) as $key)
						$row[$key]=stripslashes($row[$key]);
				$address['geolocator']=$row['street'].", ".$row['plz']." ".$row['city'].", ".$row['name'];
				$address['mark']="<span style='font-size:14px;'>".$row['street']."<br>".$row['iso3']."-".$row['plz']." ".$row['city']."<br><img src='images/countries/".strtolower($row['iso2']).".gif' alt=''/>&nbsp;".$row['name']."</span>";
			}
			return $address;
		}
		
		//Number types
		function get_number_types($lang)
		{
			$types=array();
			$sql="SELECT ID, weight FROM ".NUMBERTYPES_TBL." ORDER BY weight ASC";
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data))
			{
				$types[$row['ID']]['ID']=$row['ID'];
				$types[$row['ID']]['ntype']=$lang[$row['ID']];
				$types[$row['ID']]['weight']=$row['weight'];
			}
			return $types;
		}
		
		//Numbers to edit
		function get_numbers($id)
		{
			$info=array();
			$data_exists=false;
			//Hole Nummern
			$sql="SELECT ID, ntid, number FROM ".PERSONS_NUMBERS_TBL." WHERE pid='".$id."'";
			$data=mysql_query($sql);
			if(mysql_num_rows($data))
			{
				$data_exists=true;
				while($row=mysql_fetch_assoc($data))
				{
					//Setze alle Felder als "temporäre" Vars
					foreach(array_keys($row) as $key)
					{
						$entry[$key]=$row[$key];
					}
					$entry['number']=decode($entry['number'], $_SESSION['uhash']);
					if(get_magic_quotes_gpc())
						$entry['number']=stripslashes($entry['number']);
					$info[]=$entry;
				}
			}
			return array($data_exists, $info);
		}
		
		//Alle Countries
		function get_countries()
		{
			$countries=array();
			$sql="SELECT num_code, name, iso2, iso3 FROM ".STATES_TBL." ORDER BY name ASC";
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data))
			{
				$countries[$row['num_code']]['num_code']=$row['num_code'];
				$countries[$row['num_code']]['name']=$row['name'];
				$countries[$row['num_code']]['iso2']=strtolower($row['iso2']);
				$countries[$row['num_code']]['iso3']=$row['iso3'];
			}
			return $countries;
		}
		
		//Addresses to edit
		function get_addresses($id)
		{
			$info=array();
			$data_exists=false;
			//Hole Addresses
			$sql="SELECT ".PERSONS_ADDRESSES_TBL.".ID, ".PERSONS_ADDRESSES_TBL.".street, ".PERSONS_ADDRESSES_TBL.".plz, ".PERSONS_ADDRESSES_TBL.".city, ".PERSONS_ADDRESSES_TBL.".state_code FROM ".PERSONS_ADDRESSES_TBL." WHERE ".PERSONS_ADDRESSES_TBL.".pid='".$id."' ORDER BY ".PERSONS_ADDRESSES_TBL.".state_code ASC";
			$data=mysql_query($sql);
			if(mysql_num_rows($data))
			{
				$data_exists=true;
				while($row=mysql_fetch_assoc($data))
				{
					foreach(array_keys($row) as $key)
					{
						$address[$key]=$row[$key];
					}
					if($address['street']!="")
					{
						$address['street']=decode($address['street'], $_SESSION['uhash']);
					}
					if($address['plz']!="")
					{
						$address['plz']=decode($address['plz'], $_SESSION['uhash']);
					}
					if($address['city']!="")
					{
						$address['city']=decode($address['city'], $_SESSION['uhash']);
					}
					if(get_magic_quotes_gpc())
						foreach(array_keys($address) as $key)
							$address[$key]=stripslashes($address[$key]);
					$info[]=$address;
				}
			}
			return array($data_exists, $info);
		}
		//Ende: Hole Daten-Funktionen
		
		//Adde Kontakt
		function addPerson($data)
		{
			$sql="INSERT INTO ".PERSONS_TBL."(uid, firstname, lastname, title, bday) VALUES('".$_SESSION['uid']."', '".mysql_real_escape_string($data['firstname'])."', '".mysql_real_escape_string($data['lastname'])."', '".mysql_real_escape_string($data['title'])."', '".mysql_real_escape_string($data['bday'])."')";
			$ins=mysql_query($sql);
			
			$sql1="SELECT ID FROM ".PERSONS_TBL." WHERE uid='".$_SESSION['uid']."' AND firstname='".mysql_real_escape_string($data['firstname'])."' AND lastname='".mysql_real_escape_string($data['lastname'])."' AND title='".mysql_real_escape_string($data['title'])."' AND bday='".mysql_real_escape_string($data['bday'])."'";
			$data=mysql_query($sql1);
			
			$done=false;
			$uid=0;
			if(mysql_num_rows($data))
			{
				$done=true;
				while($row=mysql_fetch_assoc($data))
				{
					$uid=$row['ID'];
				}
			}
			return array($done, $uid);
		}
		
		//Lösche einen Kontakt
		function deletePerson($id)
		{
			$done=false;
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
									$done=true;
								}
							}
						}
					}
				}
			}
			return $done;
		}
		
		//Adde Telefonnummern
		function savePhoneNumbers($id, $data)
		{
			$numbers=array();
			for($i=0; $i<count($data['number']); $i++)
			{
				if($data['number'][$i]!="")
				{
					$number['number']=encode($data['number'][$i], $_SESSION['uhash']);
					if(get_magic_quotes_gpc())
						$number['number']=stripslashes($number['number']);
					$number['type']=$data['number_type'][$i];
					$numbers[]=$number;
				}
			}
			//Lösche alte Nummern
			$sql="DELETE FROM ".PERSONS_NUMBERS_TBL." WHERE pid='".$id."'";
			$del=mysql_query($sql);
			//Füge neue Nummern ein
			$number_done=true;
			foreach($numbers as $number)
			{
				$sql="INSERT INTO ".PERSONS_NUMBERS_TBL."(pid, ntid, number) VALUES('".$id."', '".$number['type']."', '".mysql_real_escape_string($number['number'])."')";
				$ins=mysql_query($sql);
				
				if(!$ins)
				{
					$number_done=false;
				}
			}
			return $number_done;
		}
		
		//Adde Adressen
		function saveAddresses($id, $data)
		{
			$addresses=array();
			for($i=0; $i<count($data['street']); $i++)
			{
				if($data['street'][$i]!="")
				{
					$address['street']=encode($data['street'][$i], $_SESSION['uhash']);
					$address['plz']="";
					if($data['plz'][$i]!="")
					{
						$address['plz']=encode($data['plz'][$i], $_SESSION['uhash']);
					}
					$address['city']="";
					if($data['city'][$i]!="")
					{
						$address['city']=encode($data['city'][$i], $_SESSION['uhash']);
					}
					if(get_magic_quotes_gpc())
						foreach(array_keys($address) as $key)
							$address[$key]=stripslashes($address[$key]);
					$address['state_code']=$data['country'][$i];
					$addresses[]=$address;
				}
			}
			//Lösche alte Adressen
			$sql="DELETE FROM ".PERSONS_ADDRESSES_TBL." WHERE pid='".$id."'";
			$del=mysql_query($sql);
			//Füge neue Adressen ein
			$address_done=true;
			foreach($addresses as $address)
			{
				$sql="INSERT INTO ".PERSONS_ADDRESSES_TBL."(pid, street, plz, city, state_code) VALUES('".$id."', '".mysql_real_escape_string($address['street'])."', '".mysql_real_escape_string($address['plz'])."', '".mysql_real_escape_string($address['city'])."', '".$address['state_code']."')";
				$ins=mysql_query($sql);
				
				if(!$ins)
				{
					$address_done=false;
				}
			}
			return $address_done;
		}
		
		//Speichere geänderte Daten
		function saveGeneralInfo($id, $data)
		{
			$sql="UPDATE ".PERSONS_TBL." SET firstname='".mysql_real_escape_string($data['firstname'])."', lastname='".mysql_real_escape_string($data['lastname'])."', title='".mysql_real_escape_string($data['title'])."', bday='".mysql_real_escape_string($data['bday'])."' WHERE ID='".$id."'";
			$update=mysql_query($sql);
			
			$sql1="SELECT ID FROM ".PERSONS_TBL." WHERE uid='".$_SESSION['uid']."' AND firstname='".mysql_real_escape_string($data['firstname'])."' AND lastname='".mysql_real_escape_string($data['lastname'])."' AND title='".mysql_real_escape_string($data['title'])."' AND bday='".mysql_real_escape_string($data['bday'])."'";
			$data=mysql_query($sql1);
			
			$done=false;
			if(mysql_num_rows($data))
			{
				$done=true;
			}
			
			return $done;
		}
		
		//Speicher Social Networking
		function saveSocialCom($id, $data)
		{
			$socialcoms=array();
			for($i=0; $i<count($data['type']); $i++)
			{
				if($data['type'][$i]!="")
				{
					$socialcom['type']=$data['type'][$i];
					$socialcom['uname']="";
					if($data['uname'][$i]!="")
					{
						$socialcom['uname']=encode($data['uname'][$i], $_SESSION['uhash']);
					}
					$socialcom['fb_pid']="";
					if($data['fb_pid'][$i]!="")
					{
						$socialcom['fb_pid']=encode($data['fb_pid'][$i], $_SESSION['uhash']);
					}
					$socialcom['praefix']=$data['praefix'][$i];
					$socialcom['info']="";
					if($data['info'][$i]!="")
					{
						$socialcom['info']=encode($data['info'][$i], $_SESSION['uhash']);
					}
					if($data['uname'][$i]!="" OR $data['fb_pid'][$i]!="")
					{
						if(get_magic_quotes_gpc())
							foreach(array_keys($socialcom) as $key)
								$socialcom[$key]=stripslashes($socialcom[$key]);
						$socialcoms[]=$socialcom;
					}
				}
			}
			//Lösche alte Social Coms
			$sql="DELETE FROM ".PERSONS_SOCIALCOM_TBL." WHERE pid='".$id."'";
			$del=mysql_query($sql);
			//Füge neue Social Coms ein
			$socialcom_done=true;
			foreach($socialcoms as $socialcom)
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
		
		//Save Websites
		function saveWebsites($id, $data)
		{
			$websites=array();
			for($i=0; $i<count($data['website_url']); $i++)
			{
				if($data['website_url'][$i]!="")
				{
					$url1=explode("http://", $data['website_url'][$i]);
					$url=$url1[0];
					if(isset($url1[1]))
					{
						$url=$url1[1];
					}
					$website['url']=encode($url, $_SESSION['uhash']);
					$website['info']="";
					if($data['website_info'][$i]!="")
					{
						$website['info']=encode($data['website_info'][$i], $_SESSION['uhash']);
					}
					if(get_magic_quotes_gpc())
						foreach(array_keys($website) as $key)
							$website[$key]=stripslashes($website[$key]);
					$websites[]=$website;
				}
			}
			//Lösche alte Websites
			$sql="DELETE FROM ".PERSONS_WEBSITES_TBL." WHERE pid='".$id."'";
			$del=mysql_query($sql);
			//Füge neue Websites ein
			$website_done=true;
			foreach($websites as $website)
			{
				$sql="INSERT INTO ".PERSONS_WEBSITES_TBL."(pid, url, infoText) VALUES('".$id."', '".mysql_real_escape_string($website['url'])."', '".mysql_real_escape_string($website['info'])."')";
				$ins=mysql_query($sql);
				
				if(!$ins)
				{
					$website_done=false;
				}
			}
			return $website_done;
		}
		
		//Save E-Mails
		function saveEmails($id, $data)
		{
			$emails=array();
			for($i=0; $i<count($data['email_url']); $i++)
			{
				if($data['email_url'][$i]!="")
				{
					$email['url']=encode($data['email_url'][$i], $_SESSION['uhash']);
					$email['info']="";
					if($data['email_info'][$i]!="")
					{
						$email['info']=encode($data['email_info'][$i], $_SESSION['uhash']);
					}
					if(get_magic_quotes_gpc())
						foreach(array_keys($email) as $key)
							$email[$key]=stripslashes($email[$key]);
					$emails[]=$email;
				}
			}
			//Lösche alte E-Mails
			$sql="DELETE FROM ".PERSONS_EMAILS_TBL." WHERE pid='".$id."'";
			$del=mysql_query($sql);
			//Füge neue E-Mails ein
			$email_done=true;
			$email_ids=array();
			foreach($emails as $email)
			{
				$sql="INSERT INTO ".PERSONS_EMAILS_TBL."(pid, email, infoText) VALUES('".$id."', '".mysql_real_escape_string($email['url'])."', '".mysql_real_escape_string($email['info'])."')";
				$ins=mysql_query($sql);
				
				if(!$ins)
				{
					$email_done=false;
				}
			}
			return $email_done;
		}
		
		//Suchen...
		function search($live_search, $query, $search_rows="")
		{
			if(get_magic_quotes_gpc())
				$query=stripslashes($query);
			
			//Wenn Live Search, dann suche in allen
			if($live_search)
			{
				$search_rows=array();
				$search_rows['persons'][]=PERSONS_TBL.".firstname";
				$search_rows['persons'][]=PERSONS_TBL.".lastname";
				$search_rows['persons'][]=PERSONS_TBL.".title";
				$search_rows['persons'][]=PERSONS_TBL.".bday";
				$search_rows['addresses'][]=PERSONS_ADDRESSES_TBL.".street";
				$search_rows['addresses'][]=PERSONS_ADDRESSES_TBL.".plz";
				$search_rows['addresses'][]=PERSONS_ADDRESSES_TBL.".city";
				$search_rows['emails'][]=PERSONS_EMAILS_TBL.".email";
				$search_rows['numbers'][]=PERSONS_NUMBERS_TBL.".number";
				$search_rows['social'][]=PERSONS_SOCIALCOM_TBL.".uname";
				$search_rows['social'][]=PERSONS_SOCIALCOM_TBL.".fb_pid";
				$search_rows['www'][]=PERSONS_WEBSITES_TBL.".url";
			}
			
			//Wo darf kein verschlüsselter Query zum Suchen verwendet werden
			$not_enc_query['persons']=array();
			$not_enc_query['persons'][]=PERSONS_TBL.".firstname";
			$not_enc_query['persons'][]=PERSONS_TBL.".lastname";
			$not_enc_query['persons'][]=PERSONS_TBL.".bday";
			$not_enc_query['addresses']=array();
			$not_enc_query['emails']=array();
			$not_enc_query['numbers']=array();
			$not_enc_query['social']=array();
			$not_enc_query['www']=array();
			
			//Alle Tabllen, in den gesucht wird
			$search_tables=array();
			$search_tables[0]['row']="numbers";
			$search_tables[0]['table']=PERSONS_NUMBERS_TBL;
			$search_tables[0]['fwd']="addresses_numbers";
			$search_tables[1]['row']="addresses";
			$search_tables[1]['table']=PERSONS_ADDRESSES_TBL;
			$search_tables[1]['fwd']="addresses_numbers";
			$search_tables[2]['row']="emails";
			$search_tables[2]['table']=PERSONS_EMAILS_TBL;
			$search_tables[2]['fwd']="www";
			$search_tables[3]['row']="social";
			$search_tables[3]['table']=PERSONS_SOCIALCOM_TBL;
			$search_tables[3]['fwd']="social_com";
			$search_tables[4]['row']="www";
			$search_tables[4]['table']=PERSONS_WEBSITES_TBL;
			$search_tables[4]['fwd']="www";
			
			//Wieviele und welche schon gefunden?
			$i=0;
			$result=array();
			$result[0]=array();
			
			$enc_query=encode($query, $_SESSION['uhash']);
			$enc_query=explode(str_rot13($_SESSION['uhash']), $enc_query);
			$enc_query=str_rot13($_SESSION['uhash']).substr($enc_query[1], 0, 5)."%".substr($enc_query[1], 5);
			$replace="<span class='highlighted_search_string'>".$query."</span>";
			
			//Hole alle Kontakte
			$sql="SELECT ID, firstname, lastname, title, bday FROM ".PERSONS_TBL." WHERE uid='".$_SESSION['uid']."' ORDER BY ID ASC";
			$data=mysql_query($sql);
			while($row=mysql_fetch_assoc($data) AND ($i<6 OR !$live_search))
			{
				if($row['firstname']!="")
				{
					$row['firstname']=decode($row['firstname'], $_SESSION['uhash']);
					if(get_magic_quotes_gpc())
						$row['firstname']=stripslashes($row['firstname']);
				}
				if($row['lastname']!="")
				{
					$row['lastname']=decode($row['lastname'], $_SESSION['uhash']);
					if(get_magic_quotes_gpc())
						$row['lastname']=stripslashes($row['lastname']);
				}
				//Lösche Daten vorhergegangener Suchen
				if(isset($entry))
				{
					unset($entry);
					unset($entry1);
				}
				
				$done=false;
				
				//Wenn schon in generalInfos gesucht wird
				if(count($search_rows['persons'])>0)
				{
					foreach($search_rows['persons'] as $searching)
					{
						//Hole Felder in denen gesucht wird & replace
						$searching1=explode(".", $searching);
						if(in_array($searching, $not_enc_query['persons']))
						{
							if(get_magic_quotes_gpc())
								$row[$searching1[1]]=stripslashes($row[$searching1[1]]);
							$e=str_ireplace($query, $replace, $row[$searching1[1]], $count);
							if($count>0)
							{
								$done=true;
								//Prüfe ob firstname oder lastname... (beide sind encrypted, daher oben ein if! (bday ist nicht encrypted)
								switch($searching1[1])
								{
									case "firstname":
										$entry['firstname']=$e;
										$entry['lastname']=$row['lastname'];
									break;
									case "lastname":
										$entry['lastname']=$e;
										$entry['firstname']=$row['firstname'];
									break;
									case "bday":
										$entry['string']=$e;
										$entry['firstname']=$row['firstname'];
										$entry['lastname']=$row['lastname'];
									break;
								}
							}
						}
						else
						{
							if($row[$searching1[1]]!="")
							{
								$row[$searching1[1]]=decode($row[$searching1[1]], $_SESSION['uhash']);
								if(get_magic_quotes_gpc())
									$row[$searching1[1]]=stripslashes($row[$searching1[1]]);
								$e=str_ireplace($query, $replace, $row[$searching1[1]], $count);
								if($count>0)
								{
									$done=true;
									$entry['string']=$e;
									$entry['firstname']=$row['firstname'];
									$entry['lastname']=$row['lastname'];
								}
							}
						}
					}
				}
				
				//Wenn oben schon gefunden, füge hinzu...
				if($done)
				{
					$entry['ID']=$row['ID'];
					$entry['found_in']="general_info";
					$entry1[]=$entry;
					$result[0]=array_merge($result[0], $entry1);
				}
				
				//Durchsuche jede Table
				foreach($search_tables as $table)
				{
					if(count($search_rows[$table['row']])!=0 AND (!$done OR !$live_search))
					{
						$entry=$this->searchFor(array($search_rows[$table['row']], $not_enc_query[$table['row']]), $row, $table['table'], array($query, $enc_query, $replace), $table['fwd'], $live_search);
						if($entry[0])
						{
							$result[0]=array_merge($result[0], $entry[1]);
							$done=true;
						}
					}
				}
				
				//Wenn ertwas gefunden, Zähler erhöhen
				if($done)
				{
					$i++;
				}
			}
			
			return $result;
		}
		
		//Suche nach ... in einer Tabelle
		function searchFor($search_rows, $row, $table, $query, $found_in, $live_search)
		{
			$result=array();
			$done=false;
			
			$sql1="SELECT ";
			foreach($search_rows[0] AS $searching)
			{
				$sql1.=$searching.", ";
			}
			$sql1=substr($sql1, 0, (strlen($sql1)-2));
			$sql1.=" FROM ".$table." WHERE pid='".$row['ID']."' AND (";
			foreach($search_rows[0] AS $searching)
			{
				$sql1.=$searching." LIKE '%";
				if(in_array($searching, $search_rows[1]))
				{
					$sql1.=$query[0];
				}
				else
				{
					$sql1.=$query[1];
				}
				$sql1.="%' OR ";
			}
			$sql1=substr($sql1, 0, (strlen($sql1)-4));
			$sql1.=") ORDER BY ID ASC";
			$data1=mysql_query($sql1);
			while($row1=mysql_fetch_assoc($data1))
			{
				$entry['firstname']=$row['firstname'];
				$entry['lastname']=$row['lastname'];
				$entry['ID']=$row['ID'];
				foreach(array_keys($row1) as $key)
				{
					if($row1[$key]!="")
					{
						$row1[$key]=decode($row1[$key], $_SESSION['uhash']);
						if(get_magic_quotes_gpc())
							$row1[$key]=stripslashes($row1[$key]);
						$row1[$key]=str_ireplace($query[0], $query[2], $row1[$key], $count);
						if($count!=0 AND ((!$done AND $live_search) OR !$live_search))
						{
							$entry['string']=$row1[$key];
							$entry['found_in']=$found_in;
							$result[]=$entry;
							$done=true;
						}
					}
				}
			}
			return array($done, $result);
		}
		
	}
	//Ende Klassendefinition
?>