<?php
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../includes/ajaxInits/includes.ajaxInit.ebene1.php");
	
	//Starte Klassen
	$user=new user();
	$um=new user_mngmnt();
	
	//Sprache laden
	include("../../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	if(isset($_POST['enabled']))
	{
		$_POST['enabled']="1";
	}
	else
	{
		$_POST['enabled']="0";
	}
	$required=explode(",", $user->settings['required_user_fields']);
	$done="false";
	$error=$lang['pers_info_null_err'];
	for($i=0; $i<(count($required)-1); $i++)
	{
		$error.=$required[$i].", ";
	}
	$error.=$required[$i]."!";
	$do=true;
	foreach($required as $field)
	{
		if($_POST[$field]=="")
		{
			$do=false;
		}
	}
	if($do)
	{
		$error=$lang['edit_failed'];
		if($um->updateUserInfos($_POST['id'], $_POST))
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