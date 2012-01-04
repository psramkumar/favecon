<?php
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../../includes/ajaxInits/includes.ajaxInit.ebene2.php");
	
	//Starte Klassen
	$user=new user();
	$person=new person();
	
	//Sprache laden
	include("../../../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	if(get_magic_quotes_gpc())
		foreach(array_keys($_POST) as $key)
			$_POST[$key]=stripslashes($_POST[$key]);
	if($_POST['firstname']!="")
	{
		$_POST['firstname']=encode($_POST['firstname'], $_SESSION['uhash']);
	}
	if($_POST['lastname']!="")
	{
		$_POST['lastname']=encode($_POST['lastname'], $_SESSION['uhash']);
	}
	if($_POST['title']!="")
	{
		$_POST['title']=encode($_POST['title'], $_SESSION['uhash']);
	}
	$done="false";
	$error=$lang['new_pers_null_err'];
	if($_POST['firstname']!="" OR $_POST['lastname']!="")
	{	
		$error=$lang['edit_failed'];
		if($person->saveGeneralInfo($_POST['id'], $_POST))
		{
			$done="true";
			$error=$lang['edit_finished'];
		}
	}
	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n
			<editPerson>\n
				<done>".$done."</done>\n
				<error>".$error."</error>\n
			</editPerson>\n";
	
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