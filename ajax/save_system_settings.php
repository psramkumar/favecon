<?php
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../includes/ajaxInits/includes.ajaxInit.php");
	
	//Starte Klassen
	$user=new user();
	
	//Sprache laden
	include("../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	$done="true";
	$error=$lang['settings_finished'];
	//Delete all
	$sql="DELETE FROM ".SETTINGS_TBL;
	$del=mysql_query($sql);
	if(isset($_POST['update_notification']))
	{
		$_POST['update_notification']="1";
	}
	else
	{
		$_POST['update_notification']="0";
	}
	if(isset($_POST['news']))
	{
		$_POST['news']="1";
	}
	else
	{
		$_POST['news']="0";
	}
	if(isset($_POST['google_maps']))
	{
		$_POST['google_maps']="1";
	}
	else
	{
		$_POST['google_maps']="0";
		$_POST['google_maps_key']="";
	}
	if(isset($_POST['facebook']))
	{
		$_POST['facebook']="1";
		if($_POST['fb_app_id']=="" OR $_POST['fb_secret']=="")
		{
			$done="false";
			$error=$lang['settings_fb_error'];
		}
	}
	else
	{
		$_POST['facebook']="0";
		$_POST['fb_app_id']="";
		$_POST['fb_secret']="";
	}
	$_POST['fb_id']="";
	$user_fields="";
	foreach($_POST['required_user_fields'] as $field)
	{
		$user_fields.=$field.",";
	}
	$_POST['required_user_fields']=substr($user_fields,0,-1);
	//Füge ein
	if($done=="true")
	{
		foreach(array_keys($_POST) as $key)
		{
			$sql="INSERT INTO ".SETTINGS_TBL."(var, val) VALUES('".$key."', '".$_POST[$key]."')";
			$ins=mysql_query($sql);
			
			if(!$ins)
			{
				$done="false";
				$error=$lang['settings_error'];
			}
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