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
	
	include("../translations/lang.".$user->settings['lang'].".php");
	
	$i=$_GET['info'];
	
	require '../includes/facebook.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
    	 <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
		<script type="text/javascript" src="../jquery-ui/jquery-1.4.2.js"></script>
        <script type="text/javascript" src="../jquery-ui/jquery-ui-1.8.custom.js"></script>
        <script type="text/javascript">
			function fb_search(limit, vari)
			{
				var query=$('#query').val();
				var dataSend="limit="+limit+"&query="+query+"&x="+vari;
				$.ajax({
					type: "POST",
					url: "../../ajax/search/fb_search.php",
					data: dataSend,
					error: function(){
						$('#search_results').html("AJAX-Request failed!");
					},
					success: function(data){
						$('#search_results').html(data);
					}
				});
			}
		</script>
        <link rel="stylesheet" href="../styles/default/includes.style.css"/>
    	<title>Facebook Connect...</title>
    </head>
    <body>
		
<?php
	include("../includes/facebook_connect.php");
?>
		
        <div>
          <fb:login-button autologoutlink="true"></fb:login-button>
        </div><br>

<?php
	if($me)
	{
		echo "<table width='95%' align='center' class='form'>
				<tr>
					<td align='center'><label for='query'><b>".$lang['search'].":</b></label>&nbsp;&nbsp;&nbsp;<input type='text' id='query' style='width:300px;' onKeyUp=\"fb_search('', '".$i."');\"></td>
				</tr>
				<tr>
					<td>
						<table id='search_results' width='100%' class='tablehead'>
							<tr>
								<td align='center'>".$lang['fb_wait']."</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>";
	}
?>
		
    </body>
</html>

<?php
	//Schließe MySQL-Connection
	mysql_close();
?>
<script type="text/javascript">
	$(function() {
		fb_search('', '<?=$i?>');
	});
</script>

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