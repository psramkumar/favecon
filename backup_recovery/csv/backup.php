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
	header('Content-disposition: attachment; filename=csv_backup_'.date("Ymd").'.csv');
	header('Content-type: text/comma-separated-value; charset=UTF-8');
	//Content
	$sql="SELECT ID FROM ".PERSONS_TBL." WHERE uid='".$_SESSION['uid']."' ORDER BY ID ASC";
	$data=mysql_query($sql);
	$i=1;
	if(mysql_num_rows($data))
		while($row=mysql_fetch_assoc($data))
		{
			$id=$row['ID'];
			
			$gi=$person->get_details_general_info($id);
			echo "\"_person_\";".$i.";\"".replace_semicolon(false, $gi['firstname'])."\";\"".replace_semicolon(false, $gi['lastname'])."\";\"".replace_semicolon(false, $gi['title'])."\";\"".$gi['bday']."\"\n";
			
			$n=$person->get_numbers($id);
			if($n[0])
				foreach($n[1] as $number)
					echo "\"_number_\";".$i.";".$number['ntid'].";\"".replace_semicolon(false, $number['number'])."\"\n";
			
			$a=$person->get_addresses($id);
			if($a[0])
				foreach($a[1] as $address)
					echo "\"_address_\";".$i.";\"".replace_semicolon(false, $address['street'])."\";\"".replace_semicolon(false, $address['plz'])."\";\"".replace_semicolon(false, $address['city'])."\";".$address['state_code']."\n";
			
			$www=$person->get_details_www($id);
			foreach($www['websites'] as $w)
				echo "\"_website_\";".$i.";\"".replace_semicolon(false, $w['url'])."\";\"".replace_semicolon(false, $w['infoText'])."\"\n";
			foreach($www['emails'] as $e)
				echo "\"_email_\";".$i.";\"".replace_semicolon(false, $e['email'])."\";\"".replace_semicolon(false, $e['infoText'])."\"\n";
			
			$s=$person->get_social_com($id);
			if($s[0])
				foreach($s[1] as $se)
					echo "\"_socialcom_\";".$i.";".$se['soctid'].";\"".replace_semicolon(false, $se['uname'])."\";\"".replace_semicolon(false, $se['fb_pid'])."\";\"".$se['praefixNo']."\";\"".replace_semicolon(false, $se['infoText'])."\"\n";
			
			$i++;
		}


	//Schließe MySQL-Connection
	mysql_close();
?>