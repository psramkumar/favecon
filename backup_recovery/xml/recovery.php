<?php
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../includes/ajaxInits/includes.ajaxInit.ebene1.php");
	
	//Starte Klassen
	include("../../includes/classes/php.classes.backup_recovery.php");
	include("../../includes/classes/php.classes.XMLParser.php");
	$user=new user();
	$person=new person();
	$br=new backupRecovery();
	
	//Sprache laden
	include("../../translations/lang.".$user->settings['lang'].".php");
	
	//Ausgabe
	$done="false";
	$error=$lang['no_file'];
	$error1=false;
	if(!isset($_FILES['xml_file']) OR !is_file($_FILES['xml_file']['tmp_name']))
		$error1=true;
	if(!$error1 AND $_FILES['xml_file']['type']!="text/xml")
	{
		$error1=true;
		$error=$lang['wrong_file_type'];
	}
	if(!$error1)
	{
		$file=file_get_contents($_FILES['xml_file']['tmp_name']);
		$error=$lang['wrong_data'];
		mysql_query("BEGIN");
		//Delete old entries
		$sql="SELECT ID FROM ".PERSONS_TBL." WHERE uid='".$_SESSION['uid']."'";
		$data=mysql_query($sql);
		while($row=mysql_fetch_assoc($data))
		{
			$person->deletePerson($row['ID']);
		}
		$parser=new XMLParser($file);
		$parser->Parse();
		foreach($parser->document->person as $contact)
		{
			$data=XML2Array($contact);
			//Error -> not enough fields
			if(count($data)<4)
			{
				$error1=true;
				break;
			}
			
			//General Info
			if($data['firstname']!="")
			{
				$data['firstname']=encode($data['firstname'], $_SESSION['uhash']);
			}
			if($data['lastname']!="")
			{
				$data['lastname']=encode($data['lastname'], $_SESSION['uhash']);
			}
			if($data['title']!="")
			{
				$data['title']=encode($data['title'], $_SESSION['uhash']);
			}
			if($data['firstname']!="" OR $data['lastname']!="")
			{
				$uid=$person->addPerson(array("firstname"=>$data['firstname'], "lastname"=>$data['lastname'], "title"=>$data['title'], "bday"=>$data['birthday']));
				if(!$uid[0])
				{
					$error1=true;
					break;
				}
				$id=$uid[1];		
			}
			
			//phone numbers, addresses, ...
			foreach(array_keys($data) as $key)
			{
				if(is_array($data[$key]))
				{
					foreach($data[$key] as $vals)
					{
						switch($key)
						{
							case "number":
								if(count($vals)!=2 OR !is_numeric($vals['typeid']))
								{
									$error1=true;
									break;
								}
								if(!$br->addPhoneNumber($id, array("number"=>$vals['phonenumber'], "number_type"=>$vals['typeid'])))
									$error1=true;
							break;
							case "address":
								if(count($vals)!=4 OR !is_numeric($vals['countrycode']))
								{
									$error1=true;
									break;
								}
								if(!$br->addAddress($id, array("street"=>$vals['street'], "plz"=>$vals['plz'], "city"=>$vals['city'], "country"=>$vals['countrycode'])))
									$error1=true;
							break;
							case "website":
								if(count($vals)!=2)
								{
									$error1=true;
									break;
								}
								if(!$br->addWebsite($id, array("website_url"=>$vals['url'], "website_info"=>$vals['infotext'])))
									$error1=true;
							break;
							case "email":
								if(count($vals)!=2)
								{
									$error1=true;
									break;
								}
								if(!$br->addEmail($id, array("email_url"=>$vals['mail'], "email_info"=>$vals['infotext'])))
									$error1=true;
							break;
							case "socialCommunication": case "socialcommunication":
								if(count($vals)!=5 OR !is_numeric($vals['praefixno']) OR !is_numeric($vals['typeid']))
								{
									$error1=true;
									break;
								}
								if(!$br->addSocialCom($id, array("type"=>$vals['typeid'], "uname"=>$vals['username'], "fb_pid"=>$vals['fbid'], "praefix"=>$vals['praefixno'], "info"=>$vals['infotext'])))
									$error1=true;
							break;
						}
						//if failure exit foreach (data fetching)
						if($error1)
							break;
					}
				}
				//if failure exit foreach (numbers, addresses, ...)
				if($error1)
					break;
			}
			//if failure exit foreach (person)
			if($error1)
				break;
		}
		
		//if success commit changes, otherwise roll them back!
		if(!$error1)
		{
			$done="true";
			$error=$lang['import_success'];
			mysql_query("COMMIT");
		}
		else
			mysql_query("ROLLBACK");
	}
	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n
			<import>\n
				<done>".$done."</done>\n
				<error>".$error."</error>\n
			</import>\n";
	
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