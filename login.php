<div class="loginform">
<?php
	//Hole Version
	$zeile=file("config/version.txt");
	foreach($zeile as $z)
	{
		$version=$z;
	}
	
	echo "<form action=\"javascript:loginRequest('login');\" method='post'>
			<table style='border-collapse:collapse; border:1px solid #033;'>
				<tr>
            		<td colspan='2' align='center'><a href='http://www.muehlbachler.org' target='_blank'><img border='0' src='images/favecon.png' height='128px;' alt='FaveCon Logo' style='border-bottom:1px solid #999;'></a></td>
            	</tr>
            	<tr>
            		<td colspan='2' align='center' style='font-size:10px; border-bottom:1px dotted #033;'>('<a href='http://www.muehlbachler.org' target='_blank' style='font-size:10px;'>FaveCon AddressBook</a>' v<span style='font-size:11px;'>".$version."</span>)</td>
            	</tr>";
	echo "		<tr>
					<td colspan='2' align='center' style='color:red; font-size:14px;' id='login_errors'>&nbsp;</td>
				</tr>";
	echo "		<tr class='logintd'>
					<td><label for='login_user'>Username: </label></td>
					<td><input id='login_user' class='loginuser' type='text' name='user' size='35' tabindex='1'  onKeyPress=\"$('#login_errors').html('&nbsp;');\"></td>
				</tr>
				<tr class='logintd'>
					<td><label for='login_pw'>Password: </label></td>
					<td><input id='login_pw' class='loginpw' type='password' name='passwd' size='35' tabindex='2' onKeyPress=\"$('#login_errors').html('&nbsp;');\"></td>
				</tr>
				<tr>
					<td colspan='2' align='center' style='padding:13px 0;'><input type='submit' value='Login' tabindex='3'></td>
				</tr>
			</table>
		</form>";
	//Autofocus
	echo "<script type='text/javascript'>
			function autofocus_username()
			{
				document.getElementById('login_user').focus();
			}
			window.onload=autofocus_username();
		</script>";
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