<?php
	/********************
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
	
	session_start();
	
	//Config laden
	include("../../config/config.db.php");
	include("../../config/config.db.tables.php");
	
	//Starte MySQL & Reporting
	error_reporting(E_ALL);
	@mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWD) OR die("Keine Verbindung zur Datenbank. Fehlermeldung: ".mysql_error());
	mysql_select_db(MYSQL_DB) OR die("Konnte Datenbank nicht benutzen. Fehlermeldung: ".mysql_error());
	
	//Classes
	include("../../includes/classes/php.classes.user.php");
	include("../../includes/classes/php.classes.person.php");
	include("../../includes/classes/php.classes.backup_recovery.php");
	$user=new user();
	$person=new person();
	$br=new backupRecovery();
	
	//Functions
	include("../../includes/include.functions.php");
	
	//Language
	include("../../translations/lang.".$user->settings['lang'].".php");
	
	//Ausgabe
	//Header
	header('Content-disposition: attachment; filename=xml_backup_'.date("Ymd").'.xml');
	header('Content-type: text/xml; charset=UTF-8');
	//Content
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>
	<data>\n";
	$sql="SELECT ID FROM ".PERSONS_TBL." WHERE uid='".$_SESSION['uid']."' ORDER BY ID ASC";
	$data=mysql_query($sql);
	if(mysql_num_rows($data))
		while($row=mysql_fetch_assoc($data))
		{
			$id=$row['ID'];
			
			$gi=$person->get_details_general_info($id);
			echo "		<person>
			<firstname>".$gi['firstname']."</firstname>
			<lastname>".$gi['lastname']."</lastname>
			<title>".$gi['title']."</title>
			<birthday>".$gi['bday']."</birthday>\n";
			
			$n=$person->get_numbers($id);
			$numberID=1;
			if($n[0])
				foreach($n[1] as $number)
				{
					echo "			<number id='".$numberID."'>
				<typeID>".$number['ntid']."</typeID>
				<phoneNumber>".$number['number']."</phoneNumber>
			</number>\n";
					$numberID++;
				}
			
			$a=$person->get_addresses($id);
			$addressID=1;
			if($a[0])
				foreach($a[1] as $address)
					{
						echo "			<address id='".$addressID."'>
				<street>".$address['street']."</street>
				<plz>".$address['plz']."</plz>
				<city>".$address['city']."</city>
				<countryCode>".$address['state_code']."</countryCode>
			</address>\n";
						$addressID++;
					}
			
			$www=$person->get_details_www($id);
			$wwwID=1;
			$emailID=1;
			foreach($www['websites'] as $w)
				{
					echo "			<website id='".$wwwID."'>
				<url>".$w['url']."</url>
				<infoText>".$w['infoText']."</infoText>
			</website>\n";
					$wwwID++;
				}
			foreach($www['emails'] as $e)
				{
					echo "			<email id='".$emailID."'>
				<mail>".$e['email']."</mail>
				<infoText>".$e['infoText']."</infoText>
			</email>\n";
					$emailID++;
				}
			
			$s=$person->get_social_com($id);
			$sID=1;
			if($s[0])
				foreach($s[1] as $se)
					{
						echo "			<socialCommunication id='".$sID."'>
				<typeID>".$se['soctid']."</typeID>
				<username>".$se['uname']."</username>
				<fbID>".$se['fb_pid']."</fbID>
				<praefixNo>".$se['praefixNo']."</praefixNo>
				<infoText>".$se['infoText']."</infoText>
			</socialCommunication>\n";
						$sID++;
					}
			
			echo "		</person>\n";
		}


	//Schließe MySQL-Connection
	mysql_close();
?>
	</data>
