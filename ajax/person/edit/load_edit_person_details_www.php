<?php
	header('Content-Type:text/html;'); // sorgt für die korrekte XML-Kodierung
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../../../includes/ajaxInits/includes.ajaxInit.ebene2.php");
	
	//Starte Klassen
	$user=new user();
	$person=new person();
	
	//Sprache laden
	include("../../../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	$data=$person->get_details_www($_POST['id']);
	$p=$person->get_details_general_info($_POST['id']);
	echo "<div class='showPersonDetails' style='width:600px;''>
			<table width='100%' style='margin-top:-20px;'>
				<tr>
					<td align='right'><span class='edit_button' onClick=\"load_show_person1('".$_POST['id']."', 'www', '".$lang['editError']."');\"><img src='styles/".$user->settings['style']."/images/show.png' height='12px' align='top'>&nbsp;&nbsp;".$lang['show_button']."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='edit_button' onClick=\"delete_person('".$_POST['id']."', '".$lang['delete_msg']."');\"><img src='styles/".$user->settings['style']."/images/delete.png' height='12px' align='top'>&nbsp;&nbsp;".$lang['delete_button']."</span></td>
				</tr>
				<tr>
					<td align='center' style='font-size:14px; color:dimgrey;'>".$lang['you_edit']." <b><span style='font-size:15px; color:black;'>".$p['lastname']." ".$p['firstname']."</span></b></td>
				</tr>
			</table>
			<input type='hidden' value='0' id='changedContents'>
			<form action=\"javascript:save_personDetails_www('".$_POST['id']."');\">
				<table class='form' width='100%'>
					<tr>
						<td id='error' colspan='2' align='center'></td>
					</tr>
					<tr>
						<td colspan='2' align='center'>".$lang['www_help']."<br><br></td>
					</tr>
					<tr>
						<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['websites']."</td>
					</tr>
					<tr>
						<td>
							<table id='website'>
								<tr>
									<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['website_url']."</td>
									<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['infoText']."</td>
								</tr>";
	$wurl=1;
	if(isset($data['websites'][0]))
	{
		foreach($data['websites'] as $website)
		{
			echo "<tr>
					<td><textarea type='text' name='website_url[]'";
			if($wurl==1)
				echo "id='website_url_1'";
			echo " style='width:275px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">".$website['url']."</textarea></td>
					<td><textarea name='website_info[]' style='width:250px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">".$website['infoText']."</textarea></td>
				</tr>";
			$wurl++;
		}
	}
	echo "<tr>
			<td><textarea type='text' name='website_url[]'";
	if($wurl==1)
		echo "id='website_url_1'";
	echo "  style='width:275px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></textarea></td>
			<td><textarea name='website_info[]' style='width:250px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></textarea></td>
		</tr>";
	echo "						<tr>
									<td colspan='2' align='center'><input class='small_button' type='button' value='".$lang['add_website']."' onClick=\"add_www('website');\"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['emails']."</td>
					</tr>
					<tr>
						<td><table id='email'>
								<tr>
									<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['email_url']."</td>
									<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['infoText']."</td>
								</tr>";
	if(isset($data['emails'][0]))
	{
		foreach($data['emails'] as $email)
		{
			echo "<tr>
					<td><textarea type='text' name='email_url[]' style='width:275px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">".$email['email']."</textarea></td>
					<td><textarea name='email_info[]' style='width:250px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">".$email['infoText']."</textarea></td>
				</tr>";
		}
	}
	echo "<tr>
			<td><textarea type='text' name='email_url[]'style='width:275px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></textarea></td>
			<td><textarea name='email_info[]' style='width:250px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></textarea></td>
		</tr>";
	echo "						<tr>
									<td colspan='2' align='center'><input class='small_button' type='button' value='".$lang['add_email']."' onClick=\"add_www('email');\"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan='2'>&nbsp;</td>
					</tr>
					<tr>
						<td colspan='2' align='center'><input type='submit' id='save' disabled value='".$lang['save']."'></td>
					</tr>
				</table>
			</form>
		</div>";
		
	//Schließe MySQL
	mysql_close();
?>
<script type="text/javascript">
	function add_www(what)
	{
		var elements = $("#"+what+" tr");
		var lastElement = elements.length-2;
		$('#'+what+' tr:eq('+lastElement+')').after("<tr><td><textarea type='text' name='"+what+"_url[]' style='width:275px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></textarea></td><td><textarea name='"+what+"_info[]' style='width:250px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></textarea></td></tr>");
	}
	$(function() {
		$('#website_url_1').focus();
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