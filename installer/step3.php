<?php
	function install_system_config($title, $lang, $country)
	{
		if(get_magic_quotes_gpc())
			$title=stripslashes($title);
		$data['favecon_title']=utf8_encode($title);
		$data['lang']=$lang;
		$data['state_std_num']=$country;
		$data['update_notification']=1;
		$data['news']=0;
		$data['style']="default";
		$data['order']="lastname";
		$data['order_type']="ASC";
		$data['show_persons']="/*lastname/#/firstname/";
		$data['show_persons1']="/*firstname/";
		$data['passwd_length']=5;
		$data['required_user_fields']="firstname,lastname,email";
		$data['search_show_limit']=10;
		$data['um_users_limit']=10;
		$data['news_limit']=10;
		$data['google_maps']=0;
		$data['google_maps_key']="";
		$data['facebook']=0;
		$data['fb_app_id']="";
		$data['fb_secret']="";
		$data['fb_id']="";
		
		$sql="DELETE FROM ".SETTINGS_TBL;
		$del=mysql_query($sql);
		
		foreach(array_keys($data) as $key)
		{
			$sql="INSERT INTO ".SETTINGS_TBL."(var, val) VALUES('".$key."', '".$data[$key]."')";
			$ins=mysql_query($sql);
		}
	}
	
	function install_admin_user($uname, $firstname, $lastname, $email, $pw)
	{				
		$sql="DELETE FROM ".USERS_TBL;
		$del=mysql_query($sql);
		
		$sql="DELETE FROM ".USERS_DATA_TBL;
		$del=mysql_query($sql);
		
		$sql="ALTER TABLE ".USERS_TBL." AUTO_INCREMENT=1";
		$inc=mysql_query($sql);
		
		if(get_magic_quotes_gpc())
		{
			$uname=stripslashes($uname);
			$firstname=stripslashes($firstname);
			$lastname=stripslashes($lastname);
			$email=stripslashes($email);
		}
		$sql="INSERT INTO ".USERS_TBL."(username, passwd, user_hash, gid, created_at, last_login, enabled) VALUES('".mysql_real_escape_string($uname)."', '".md5($pw)."', '".create_hash($uname)."', '1', '".time()."', '".time()."', '1')";
		$insert=mysql_query($sql);
		
		$sql1="SELECT ID FROM ".USERS_TBL." WHERE username='".mysql_real_escape_string($uname)."' AND passwd='".md5($pw)."' AND gid='1'";
		$exist=mysql_query($sql1);
		if(mysql_num_rows($exist))
		{
			while($row=mysql_fetch_assoc($exist))
			{
				$id=$row['ID'];
			}
			$sql2="INSERT INTO ".USERS_DATA_TBL."(uid, firstname, lastname, title, email, bday) VALUES('".$id."', '".utf8_encode(mysql_real_escape_string($firstname))."', '".utf8_encode(mysql_real_escape_string($lastname))."', '', '".utf8_encode(mysql_real_escape_string($email))."', '')";
			$insert1=mysql_query($sql2);
		}
	}
	
	$done=true;
	if(isset($_GET['install']))
	{
		if($_POST['system_username']=="" OR $_POST['system_firstname']=="" OR $_POST['system_lastname']=="" OR $_POST['system_email']=="" OR $_POST['system_passwd']=="")
		{
			$done=false;
		}
	}
?>
<div id='head'>Simple system &amp; user configuration</div>
<br><br>
<div align='center'>
<?php
	if(!isset($_GET['install']) OR !$done)
	{
?>
	<form action='?step=3&install=true' method="POST">
    <table border='0' class='user'>
<?php
	if(!$done)
	{
		echo "<tr>
				<td colspan='2' align='center' style='color:black; font-size:13px; font-weight:100;'><span style='color:red;'>You must fill in your system admin information!</span></td>
			</tr>";
	}
?>
    	<tr>
        	<td>FaveCon AddressBook title:</td>
            <td><input type='text' name='favecon_title' value='FaveCon AddressBook' style='width:300px;'></td>
        </tr>
        <tr>
        	<td>Language:</td>
            <td>
            	<select name='lang'>
<?php
	$file=file("../translations/translations.txt");
	foreach($file as $z)
	{
		$z=explode(";", trim($z));
		$entry['abbr']=$z[0];
		$entry['language']=$z[1];
		$entry['iso2']=$z[2];
		echo "<option value='".$z[0]."' style='background-image:url(../images/countries/".strtolower($z[2]).".gif); background-repeat:no-repeat; background-position:center left; padding-left:20px;'>".$z[1]."</option>";
	}
?>
				</select>
			</td>
        </tr>
        <tr>
        	<td>Standard country:</td>
            <td>
            	<select name='state_std_num'>
<?php
	$sql="SELECT num_code, name, iso2 FROM ".STATES_TBL." ORDER BY name ASC";
	$data=mysql_query($sql);
	while($row=mysql_fetch_assoc($data))
	{
		echo "<option value='".$row['num_code']."' style='background-image:url(../images/countries/".strtolower($row['iso2']).".gif); background-repeat:no-repeat; background-position:center left; padding-left:20px;'>".$row['name']."</option>";
	}
?>
				</select>
			</td>
        </tr>
        <tr>
        	<td style='border-bottom:1px solid #333;' colspan='2'></td>
        </tr>
        <tr>
        	<td>System admin username:</td>
            <td><input type='text' name='system_username' value='admin' style='width:300px;'></td>
        </tr>
        <tr>
        	<td>Firstname:</td>
            <td><input type='text' name='system_firstname' style='width:300px;'></td>
        </tr>
        <tr>
        	<td>Lastname:</td>
            <td><input type='text' name='system_lastname' style='width:300px;'></td>
        </tr>
        <tr>
        	<td>E-Mail:</td>
            <td><input type='text' name='system_email' style='width:300px;'></td>
        </tr>
        <tr>
        	<td>Password:</td>
            <td><input type='text' name='system_passwd' style='width:300px;'></td>
        </tr>
        <tr>
        	<td colspan='2' align='center' style='color:black; font-size:12px; font-weight:100;'><span style='color:red;'><b>Note:</b></span> You can change all these values later too, but you must fill in these fields now!</td>
        </tr>
	</table><br><br>
    <input type='submit' value='Perform installation'>
    </form><br><br>
<?php
	}
	else
	{
		if($done)
		{
?>
	System configuration gets installed...<br><br>
<?php
			//Install system config
			install_system_config($_POST['favecon_title'], $_POST['lang'], $_POST['state_std_num']);
			
			//Install user
			install_admin_user($_POST['system_username'], $_POST['system_firstname'], $_POST['system_lastname'], $_POST['system_email'], $_POST['system_passwd']);
			
			echo "<script type='text/javascript'>
					location.href='?step=4';
				</script>";
		}
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