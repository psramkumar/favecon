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
	$stypes=$person->get_social_com_types();
	$socialcoms=$person->get_social_com($_POST['id']);
	$countries=$person->get_countries();
	$addresses=$person->get_addresses($_POST['id']);
	$data=$person->get_details_general_info($_POST['id']);
	echo "<div class='showPersonDetails' style='width:650px;''>
			<table width='100%' style='margin-top:-20px;'>
				<tr>
					<td align='right'><span class='edit_button' onClick=\"load_show_person1('".$_POST['id']."', 'social_com', '".$lang['editError']."');\"><img src='styles/".$user->settings['style']."/images/show.png' height='12px' align='top'>&nbsp;&nbsp;".$lang['show_button']."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='edit_button' onClick=\"delete_person('".$_POST['id']."', '".$lang['delete_msg']."');\"><img src='styles/".$user->settings['style']."/images/delete.png' height='12px' align='top'>&nbsp;&nbsp;".$lang['delete_button']."</span></td>
				</tr>
				<tr>
					<td align='center' style='font-size:14px; color:dimgrey;'>".$lang['you_edit']." <b><span style='font-size:15px; color:black;'>".$data['lastname']." ".$data['firstname']."</span></b></td>
				</tr>
			</table>
			<input type='hidden' value='0' id='changedContents'>
			<form action=\"javascript:save_personDetails_social_com('".$_POST['id']."');\">
				<table class='form' width='100%'>
					<tr>
						<td id='error' colspan='2' align='center'></td>
					</tr>
					<tr>
						<td colspan='2' align='center'>".$lang['social_com_help']."<br><br></td>
					</tr>
					<tr>
						<td colspan='2'>
							<table id='social_com' width='100%'>";
	$i=0;
	if($socialcoms[0])
	{
		$a=0;
		$how_many=count($socialcoms[1]);
		foreach($socialcoms[1] as $socialcom)
		{
			echo "<tr>
					<td colspan='2'></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['social_com_type'].":</td>
					<td>
						<select name='type[]' onChange=\"view_details(this, '".$i."');  $('#error').html('');\">
							<option value='' selected>N/A</option>";
			foreach($stypes as $type)
			{
				echo "<option value='".$type['ID']."'";
				if($type['ID']==$socialcom['soctid'])
				{
					echo " selected";
				}
				echo ">".$type['socialtype']."</option>";
			}
			echo "		</select>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<table width='100%' id='social_com_".$i."'>";
			$stype=$stypes[$socialcom['soctid']];
			echo "<tr>
					<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['social_com_name'].":</td>
					<td><input type='text' name='uname[]' style='width:235px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\" value=\"".$socialcom['uname']."\"></td>
				</tr>";
			if($stype['fb_pid'])
			{
				echo "<tr>
						<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['social_com_fbpid']."</td>
						<td>
							<input type='text' id='fb_pid_".$i."' name='fb_pid[]' style='width:200px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\" value=\"".$socialcom['fb_pid']."\">";
			if($user->settings['fb_id']!="")
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span class='edit_button' onClick=\"load_no_lang_info('facebook_friends', '".$i."');\"><img src='styles/".$user->settings['style']."/images/facebook_icon.gif' style='vertical-align:text-bottom;'>&nbsp;".$lang['select_fb_friend']."</span>";
			}
			echo "		</td>
					</tr>";
			}
			else
			{
				echo "<input type='hidden' id='fb_pid_".$i."' name='fb_pid[]'>";
			}
			if($stype['praefixUsage'])
			{
				echo "<tr>
						<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['social_com_praefix'].":</td>
						<td>
							<select name='praefix[]' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
								<optgroup>
									<option value='1'";
				if($socialcom['praefixNo']==1)
				{
					echo " selected";
				}
				echo ">".$stype['praefix1Text']."</option>
									<option value='2'";
				if($socialcom['praefixNo']==2)
				{
					echo " selected";
				}
				echo ">".$stype['praefix2Text']."</option>
								</optgroup>
							</select>
						</td>
					</tr>";
			}
			else
			{
				echo "<input type='hidden' name='praefix[]' value='1'>";
			}
			echo "			<tr>
								<td class='personDetails_firsttd' style='font-weight:200; color:#036; vertical-align:top;' nowrap>".$lang['infoText'].":</td>
								<td><textarea name='info[]' style='width:235px; height:50px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">".$socialcom['infoText']."</textarea></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr><td colspan='2'";
			if(($a<($how_many-1) AND $how_many>1) OR $a==($how_many-1))
			{
				echo " class='personDetails_lasttd1'";
			}
			echo "></td></tr>";
			$a=$a+1;
			$i=$i+1;
		}
	}
	echo "<tr>
			<td colspan='2'></td>
		</tr>
		<tr>
			<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['social_com_type'].":</td>
			<td>
				<select name='type[]' onChange=\"view_details(this, '".$i."'); $('#error').html('');\">
					<option value='' selected>N/A</option>";
	foreach($stypes as $type)
	{
		echo "<option value='".$type['ID']."'>".$type['socialtype']."</option>";
	}
	echo "		</select>
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<table width='100%' id='social_com_".$i."'><input type='hidden' name='uname[]'><input type='hidden' id='fb_pid_".$i."' name='fb_pid[]'><input type='hidden' name='praefix[]' value='1'><input type='hidden' name='info[]'></table>
			</td>
		</tr>
		<tr><td colspan='2'></td></tr>";
	$i=$i+1;
	echo "						<tr>
									<td colspan='2' align='center'><input class='small_button' type='button' value='".$lang['add_social_com']."' onClick=\"add_social_com();\"></td>
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
			<input type='hidden' id='vari' value='".$i."'>
		</div>";
		
	//Schließe MySQL
	mysql_close();
?>
<style type="text/css">
	.personDetails_lasttd1 {
		border-bottom:1px solid #CCC;
	}
</style>
<script type="text/javascript">
	function add_social_com()
	{
		var i=parseInt($('#vari').val());
		var elements = $("#social_com tr");
		var lastElement = elements.length-2;
		$('#social_com tr:eq('+lastElement+') td').addClass('personDetails_lasttd1');
		$('#social_com tr:eq('+lastElement+')').after("<tr><td colspan='2'></td></tr><tr><td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap><?=$lang['social_com_type']?>:</td><td><select name='type[]' onChange=\"view_details(this, '"+i+"'); $('#error').html('');\"><option value='' selected>N/A</option><?
			foreach($stypes as $type)
			{
				echo "<option value='".$type['ID']."'>".$type['socialtype']."</option>";
			}
		?></select></td></tr><tr><td colspan='2'><table width='100%' id='social_com_"+i+"'><input type='hidden' name='uname[]'><input type='hidden' name='fb_pid[]'><input type='hidden' name='praefix[]' value='1'><input type='hidden' name='info[]'></table></td></tr><tr><td colspan='2'></td></tr>");
		i=i+1;
		$('#vari').val(i);
	}
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