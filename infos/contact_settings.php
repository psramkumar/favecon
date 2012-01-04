<?php
	session_start();
	
	//Config laden
	include("../config/config.db.php");
	include("../config/config.db.tables.php");
	
	//Starte MySQL & Reporting
	error_reporting(E_ALL);
	@mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWD) OR die("Keine Verbindung zur Datenbank. Fehlermeldung: ".mysql_error());
	mysql_select_db(MYSQL_DB) OR die("Konnte Datenbank nicht benutzen. Fehlermeldung: ".mysql_error());
	
	//Classes
	include("../includes/classes/php.classes.user.php");
	$user=new user();
	
	//Language
	include("../translations/lang.".$user->settings['lang'].".php");
	
	//Hole infos
	$text="echo \"".$lang['infos']['contact_settings']['text']."\";";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<script type="text/javascript" src="../jquery-ui/jquery-1.4.2.js"></script>
		<script type="text/javascript" src="../jquery-ui/jquery-ui-1.8.custom.js"></script>
    	<title><?=$lang['infos']['contact_settings']['header']?> - <?=$user->settings['favecon_title']?></title>
        <style type="text/css">
			body, body * {
				font-family:Georgia, "Times New Roman", Times, serif;
				font-size:12px;
			}
			h1 {
				color:#036;
				font-weight:bold;
				font-style:italic;
				text-align:center;
				font-size:30px;
			}
			.close {
				color:#960;
				font-size:17px;
			}
			.close:hover, .close:focus {
				color:#C00;
				text-decoration:underline;
				cursor:pointer;
			}
		</style>
    </head>
    <body>
		<h1><?=$lang['infos']['contact_settings']['header']?></h1><br>
        <?=eval($text)?><br><br>
        <div align='center'>
        	<span onClick='window.close();' class='close'>Close</span>
        </div>
        <br><br>
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