<div id='head'>Finish</div>
<br><br>
<div align='center'>
<?php
	if(in_array("curl", get_loaded_extensions()) AND isset($_GET['install']) AND $_GET['install'])
	{
		$sql="SELECT firstname, lastname, email FROM ".USERS_DATA_TBL." WHERE uid='1'";
		$data=mysql_query($sql);
		while($row=mysql_fetch_assoc($data))
		{
			$name=$row['firstname'].",".$row['lastname'];
			$email=$row['email'];
		}
		if(!isset($_POST['name']))
		{
			$name="";
		}
		if(!isset($_POST['email']))
		{
			$email="";
		}
		$addr=$_SERVER['SERVER_ADDR'];
		if(!isset($_POST['server_addr']))
		{
			$addr="";
		}
		
		$curl_handler=curl_init();
		curl_setopt($curl_handler, CURLOPT_URL, CURL_UPDATE_URL.CURL_UPDATE_SCRIPT."?task=register&server_addr=".$addr."&name=".$name."&email=".$email);
		curl_setopt($curl_handler, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, 1);
		$buffer=curl_exec($curl_handler);
		curl_close($curl_handler);
	}
	if(isset($_GET['install']))
	{
		echo "Installation has been finished!<br><br>
				<span style='color:red;'>Please remove the installation directory!</span><br><br>";
	}
	
	if(!isset($_GET['install']))
	{
?>
	Do you want to send your system information for evaluation purposes?<br>
    If so, what information do you want to send to <a href='http://www.muehlbachler.org' target='_blank'>http://www.muehlbachler.org</a>?<br>
    <form action='?step=4&install=true' method='POST'>
    <input type='checkbox' name='server_addr' checked>Server IP<br>
    <input type='checkbox' name='name' checked>Your name<br>
    <input type='checkbox' name='email' checked>Your email<br><br><br>
    <input type='submit' value='Yes, I want to send my information'>&nbsp;&nbsp;&nbsp;
    <input type='button' value='No, I just want to use FaveCon AddressBook right now' onClick="location.href='?step=4&install=false';">
    </form><br><br>
<?php
	}
?>
</div>

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