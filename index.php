<?php
	//Session-Start
	session_start();
	
	//Config laden
	include("config/config.db.php");
	include("config/config.db.tables.php");
	
	//Lade functions
	include("includes/include.functions.php");
	
	//Lade Class-Files
	include("includes/include.classes.php");
	
	//Setze "action"
	if(!isset($_GET['action']))
	{
		$_GET['action']="";
	}
	$action=$_GET['action'];
	
	//Hole Server_Prog_Path
	$spp=explode("index.php", $_SERVER['SCRIPT_NAME']);
	$spp=$spp[0];
	
	//Starte MySQL & Reporting
	error_reporting(E_ALL);
	@mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWD) OR die("Keine Verbindung zur Datenbank. Fehlermeldung: ".mysql_error());
	mysql_select_db(MYSQL_DB) OR die("Konnte Datenbank nicht benutzen. Fehlermeldung: ".mysql_error());
	
	$sql="SELECT val FROM ".SETTINGS_TBL." WHERE var='favecon_title'";
	$data=mysql_query($sql);
	while($row=mysql_fetch_assoc($data))
	{
		$favecon_title=$row['val'];
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    	<title><?=$favecon_title;?></title>
<?php
	//Include HTML-Headers
	include("includes/includes.html_header.php");
?>
    </head>
    <body>
<?php
	//Starte Sessions
	$login=new login();
	
	//Wenn kein Login
	if(!$login->logged_in)
	{
		include("login.php");
	}
	//Wenn eingeloggt, dürfen alle anderen Aktionen durchgeführt werden
	else
	{
		include("index1.php");
	}
?>
        
<?php
	
?>
			
    </body>
</html>

<?php
	//Schließe MySQL-Connection
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