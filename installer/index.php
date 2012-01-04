<?php
	//Session-Start
	session_start();
	
	//Config laden
	include("../config/config.db.php");
	include("../config/config.db.tables.php");
	
	//Lade functions
	include("../includes/include.functions.php");
	
	//Setze "step"
	if(!isset($_GET['step']))
	{
		$_GET['step']="1";
	}
	$step=$_GET['step'];
	
	//Starte error Reporting
	error_reporting(E_ALL);
	if($step>2)
	{
		@mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWD) OR die("Keine Verbindung zur Datenbank. Fehlermeldung: ".mysql_error());
		mysql_select_db(MYSQL_DB) OR die("Konnte Datenbank nicht benutzen. Fehlermeldung: ".mysql_error());
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    	<title>Installation - FaveCon AddressBook - Step <?=$step;?></title>
		<link rel="stylesheet" href="style.css"/>
        <!-- METAs -->
        <meta name="author" content="Daniel Muehlbachler" />
        <meta name="copyright" content="Copyright 2009-2011, Daniel Muehlbachler" />
        <meta name="description" content="FaveCon AddressBook" />
        <meta name="keywords" content="FaveCon, Address Book, AddressBook, Daniel Muehlbachler, Daniel Mühlbachler" />
		<!-- FavIcon -->
		<link rel="shortcut icon" type="image/x-icon" href="../images/favecon.png">
    </head>
    <body>
    	<div id='status' align='center'>
            <del>
            	<ul align='center'>
                	<li <?php if($step==1) echo "class='selected'";?>>Step 1: License agreement</li>
                	<li <?php if($step==2) echo "class='selected'";?>>Step 2: Database installation</li>
                    <li <?php if($step==3) echo "class='selected'";?>>Step 3: Simple system &amp; user configuration</li>
                    <li <?php if($step==4) echo "class='selected'";?>>Step 4: Finish</li>
            	</ul>
            </del>
		</div>
        <div id='content'>
        	<div id='steps'>
<?php
	//SERVER_ADDR, SERVER_NAME
	include("step".$step.".php");
?>
			</div>
		</div>
    </body>
</html>

<?php
	//Schließe MySQL-Connection
	if($step>2)
	{
		mysql_close();
	}
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