<?php
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../includes/ajaxInits/includes.ajaxInit.ebene1.php");
	
	//Starte Klassen
	$user=new user();
	
	//Sprache laden
	include("../../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	$done="false";
	$error=$lang['passwd_err'];
	if($_POST['new_passwd']!="" AND $_POST['new_passwd_confirm']!="" AND $_POST['new_passwd']==$_POST['new_passwd_confirm'])
	{
		if(strlen($_POST['new_passwd'])>=$user->settings['passwd_length'])
		{
			$sql="SELECT ID FROM ".USERS_TBL." WHERE passwd='".md5($_POST['old_passwd'])."' AND ID='".$_SESSION['uid']."'";
			$data=mysql_query($sql);
			if(mysql_num_rows($data))
			{
				$sql1="UPDATE ".USERS_TBL." SET passwd='".md5($_POST['new_passwd'])."' WHERE ID='".$_SESSION['uid']."'";
				$update=mysql_query($sql1);
				
				$sql1="SELECT ID FROM ".USERS_TBL." WHERE ID='".$_SESSION['uid']."' AND passwd='".md5($_POST['new_passwd'])."'";
				$data1=mysql_query($sql1);
				
				if(mysql_num_rows($data1))
				{
					$done="true";
					$error=$lang['passwd_changed'];
				}
			}
		}
		else
		{
			$error=$lang['short_passwd']." ".$user->settings['passwd_length'];
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