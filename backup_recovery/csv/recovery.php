<?php
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../includes/ajaxInits/includes.ajaxInit.ebene1.php");
	
	//Starte Klassen
	include("../../includes/classes/php.classes.backup_recovery.php");
	$user=new user();
	$person=new person();
	$br=new backupRecovery();
	
	//Sprache laden
	include("../../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	$done="false";
	$error=$lang['no_file'];
	$error1=false;
	if(!isset($_FILES['csv_file']) OR !is_file($_FILES['csv_file']['tmp_name']))
		$error1=true;
	if(!$error1 AND ($_FILES['csv_file']['type']!="text/comma-separated-value" OR $_FILES['csv_file']['type']!="text/csv"))
	{
		$error1=true;
		$error=$lang['wrong_file_type'];
	}
	if(!$error1)
	{
		$file=file($_FILES['csv_file']['tmp_name']);
		$error=$lang['wrong_data'];
		mysql_query("BEGIN");
		//Delete old entries
		$sql="SELECT ID FROM ".PERSONS_TBL." WHERE uid='".$_SESSION['uid']."'";
		$data=mysql_query($sql);
		while($row=mysql_fetch_assoc($data))
		{
			$person->deletePerson($row['ID']);
		}
		$i=0;
		$id=0;
		foreach($file as $z)
		{
			$z=explode(";", trim($z));
			if(count($z)>2)
			{
				for($j=0; $j<count($z); $j++)
				{
					if(get_magic_quotes_gpc())
						$z[$j]=stripslashes($z[$j]);
					$z[$j]=replace_semicolon(true, $z[$j]);
				}
				switch($z[0])
				{
					case "_person_": case "\"_person_\"":
						$i=$z[1];
						if(count($z)!=6)
						{
							$error1=true;
							break;
						}
						if($z[2]!="")
						{
							$z[2]=encode(substr($z[2], 1, -1), $_SESSION['uhash']);
						}
						if($z[3]!="")
						{
							$z[3]=encode(substr($z[3], 1, -1), $_SESSION['uhash']);
						}
						if($z[4]!="")
						{
							$z[4]=encode(substr($z[4], 1, -1), $_SESSION['uhash']);
						}
						if($z[2]!="" OR $z[3]!="")
						{
							$uid=$person->addPerson(array("firstname"=>$z[2], "lastname"=>$z[3], "title"=>$z[4], "bday"=>substr($z[5], 1, -1)));
							if(!$uid[0])
							{
								$error1=true;
								break;
							}
							$id=$uid[1];
						}
					break;
					case "_number_": case "\"_number_\"":
						if($z[1]!=$i OR count($z)!=4)
						{
							$error1=true;
							break;
						}
						if(!$br->addPhoneNumber($id, array("number"=>substr($z[3], 1, -1), "number_type"=>$z[2])))
						{
							$error1=true;
							break;
						}
					break;
					case "_address_": case "\"_address_\"":
						if($z[1]!=$i OR count($z)!=6)
						{
							$error1=true;
							break;
						}
						if(!$br->addAddress($id, array("street"=>substr($z[2], 1, -1), "plz"=>substr($z[3], 1, -1), "city"=>substr($z[4], 1, -1), "country"=>$z[5])))
						{
							$error1=true;
							break;
						}
					break;
					case "_website_": case "\"_website_\"":
						if($z[1]!=$i OR count($z)!=4)
						{
							$error1=true;
							break;
						}
						if(!$br->addWebsite($id, array("website_url"=>substr($z[2], 1, -1), "website_info"=>substr($z[3], 1, -1))))
						{
							$error1=true;
							break;
						}
					break;
					case "_email_": case "\"_email_\"":
						if($z[1]!=$i OR count($z)!=4)
						{
							$error1=true;
							break;
						}
						if(!$br->addEmail($id, array("email_url"=>substr($z[2], 1, -1), "email_info"=>substr($z[3], 1, -1))))
						{
							$error1=true;
							break;
						}
					break;
					case "_socialcom_": case "\"_socialcom_\"":
						if($z[1]!=$i OR count($z)!=7)
						{
							$error1=true;
							break;
						}
						if(!$br->addSocialCom($id, array("type"=>$z[2], "uname"=>substr($z[3], 1, -1), "fb_pid"=>substr($z[4], 1, -1), "praefix"=>substr($z[5], 1, -1), "info"=>substr($z[6], 1, -1))))
						{
							$error1=true;
							break;
						}
					break;
				}
				if($error1)
					break;
			}
			else
			{
				$error1=true;
				break;
			}
		}
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