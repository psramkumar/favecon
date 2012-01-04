<?php
	header('Content-Type:text/xml;'); // sorgt für die korrekte XML-Kodierung
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../includes/ajaxInits/includes.ajaxInit.php");
	
	//Starte Class
	$login=new login();
	
	if($_POST['what']=="login")
	{
		$user_exist=$login->check_login(array("user"=>$_POST['user'], "passwd"=>$_POST['passwd']));
		if($user_exist[0])
		{
			if($user_exist[2]=="1")
			{
				$login->perform_login($user_exist[1]);
				echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n
						<login>\n
							<done>true</done>\n
							<text></text>\n
						</login>\n";
			}
			else
			{
				echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n
						<login>\n
							<done>false</done>\n
							<text>User account deactivated!</text>\n
						</login>\n";
			}
		}
		else
		{
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n
					<login>\n
						<done>false</done>\n
						<text>Wrong login credentials!</text>\n
					</login>\n";
		}
	}
	else
	{
		$login->perform_logout();
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n
					<login>\n
						<done>true</done>\n
						<text></text>\n
					</login>\n";
	}
	
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