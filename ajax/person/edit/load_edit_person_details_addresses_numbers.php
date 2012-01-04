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
	$ntypes=$person->get_number_types($lang['ntypes']);
	$numbers=$person->get_numbers($_POST['id']);
	$countries=$person->get_countries();
	$addresses=$person->get_addresses($_POST['id']);
	$data=$person->get_details_general_info($_POST['id']);
	echo "<div class='showPersonDetails' style='width:600px;''>
			<table width='100%' style='margin-top:-20px;'>
				<tr>
					<td align='right'><span class='edit_button' onClick=\"load_show_person1('".$_POST['id']."', 'addresses_numbers', '".$lang['editError']."');\"><img src='styles/".$user->settings['style']."/images/show.png' height='12px' align='top'>&nbsp;&nbsp;".$lang['show_button']."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='edit_button' onClick=\"delete_person('".$_POST['id']."', '".$lang['delete_msg']."');\"><img src='styles/".$user->settings['style']."/images/delete.png' height='12px' align='top'>&nbsp;&nbsp;".$lang['delete_button']."</span></td>
				</tr>
				<tr>
					<td align='center' style='font-size:14px; color:dimgrey;'>".$lang['you_edit']." <b><span style='font-size:15px; color:black;'>".$data['lastname']." ".$data['firstname']."</span></b></td>
				</tr>
			</table>
			<input type='hidden' value='0' id='changedContents'>
			<form action=\"javascript:save_personDetails_addresses_numbers('".$_POST['id']."');\">
				<table class='form' width='100%'>
					<tr>
						<td id='error' colspan='2' align='center'></td>
					</tr>
					<tr>
						<td colspan='2' align='center'>".$lang['addresses_numbers_help']."<br><br></td>
					</tr>
					<tr>
						<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['phone_numbers']."</td>
					</tr>
					<tr>
						<td>
							<table id='numbers' width='100%'>";
	$nID=1;
	if($numbers[0])
	{
		foreach($numbers[1] as $number)
		{
			echo "<tr>
					<td width='225px'><input type='text' name='number[]' style='width:315px;'";
			if($nID==1)
				echo " id='phone_number_1'";
			echo " onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\" value='".$number['number']."'></td>
					<td>
						<select name='number_type[]' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
							<optgroup>";
			foreach($ntypes as $type)
			{
				echo "<option value='".$type['ID']."'";
				if($type['ID']==$number['ntid'])
				{
					echo " selected";
				}
				echo ">".$type['ntype']."</option>";
			}
			echo "			</optgroup>
						</select>
					</td>
				</tr>";
			$nID++;
		}
	}
	echo "<tr>
			<td width='225px'><input type='text' name='number[]'";
	if($nID==1)
		echo " id='phone_number_1'";
	echo " style='width:315px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
			<td>
				<select name='number_type[]' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
					<optgroup>";
	foreach($ntypes as $type)
	{
		echo "<option value='".$type['ID']."'>".$type['ntype']."</option>";
	}
	echo "			</optgroup>
				</select>
			</td>
		</tr>";
	echo "						<tr>
									<td colspan='2' align='center'><input class='small_button' type='button' value='".$lang['add_phone_number']."' onClick=\"add_number();\"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan='2' class='personDetails_firsttd personDetails_lasttd' nowrap>".$lang['addresses']."</td>
					</tr>
					<tr>
						<td><table id='addresses' width='100%'>";
	if($addresses[0])
	{
		$i=0;
		$how_many=count($addresses[1]);
		foreach($addresses[1] as $address)
		{
			echo "<tr>
					<td class='personDetails_firsttd' style='font-weight:200; color:#036;'>".$lang['street'].":</td>
					<td><input type='text' name='street[]' style='width:400px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\" value='".$address['street']."'></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['plz'].":</td>
					<td><input type='text' name='plz[]' style='width:400px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\" value='".$address['plz']."'></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd' style='font-weight:200; color:#036;'>".$lang['city'].":</td>
					<td><input type='text' name='city[]' style='width:400px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\" value='".$address['city']."'></td>
				</tr>
				<tr>
					<td class='personDetails_firsttd";
			if(($i<($how_many-1) AND $how_many>1) OR $i==($how_many-1))
			{
				echo " personDetails_lasttd";
			}
			echo "' style='font-weight:200; color:#036;'>".$lang['country'].":</td>
					<td";
			if(($i<($how_many-1) AND $how_many>1) OR $i==($how_many-1))
			{
				echo " class='personDetails_lasttd'";
			}
			echo ">
						<select name='country[]' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
							<optgroup>";
			foreach($countries as $country)
			{
				echo "<option value='".$country['num_code']."' style=\"background-image:url('images/countries/".$country['iso2'].".gif'); background-repeat:no-repeat; background-position:center left; padding-left:20px;\"";
				if($country['num_code']==$address['state_code'])
				{
					echo " selected";
				}
				echo ">".$country['name']."</option>";
			}
			echo "			</optgroup>
						</select>
					</td>
				</tr>";
			$i=$i+1;
		}
	}
	echo "<tr>
			<td class='personDetails_firsttd' style='font-weight:200; color:#036;'>".$lang['street'].":</td>
			<td><input type='text' name='street[]' style='width:400px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
		</tr>
		<tr>
			<td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap>".$lang['plz'].":</td>
			<td><input type='text' name='plz[]' style='width:400px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
		</tr>
		<tr>
			<td class='personDetails_firsttd' style='font-weight:200; color:#036;'>".$lang['city'].":</td>
			<td><input type='text' name='city[]' style='width:400px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td>
		</tr>
		<tr>
			<td class='personDetails_firsttd' style='font-weight:200; color:#036;'>".$lang['country'].":</td>
			<td>
				<select name='country[]' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\">
					<optgroup>";
	foreach($countries as $country)
	{
		echo "<option value='".$country['num_code']."' style='background-image:url(images/countries/".$country['iso2'].".gif); background-repeat:no-repeat; background-position:center left; padding-left:20px;'";
		if($country['num_code']==$user->settings['state_std_num'])
		{
			echo " selected";
		}
		echo ">".$country['name']."</option>";
	}
	echo "			</optgroup>
				</select>
			</td>
		</tr>";
	echo "						<tr>
									<td colspan='2' align='center'><input class='small_button' type='button' value='".$lang['add_address']."' onClick=\"add_address();\"></td>
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
	function add_number()
	{
		var elements = $("#numbers tr");
		var lastElement = elements.length-2;
		$('#numbers tr:eq('+lastElement+')').after("<tr><td width='225px'><input type='text' name='number[]' style='width:315px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td><td><select name='number_type[]' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"><optgroup><?
				foreach($ntypes as $type)
				{
					echo "<option value='".$type['ID']."'>".$type['ntype']."</option>";
				}
			?></optgroup></select></td></tr>");
	}
	
	function add_address()
	{
		var elements = $("#addresses tr");
		var lastElement = elements.length-2;
		$('#addresses tr:eq('+lastElement+') td').addClass('personDetails_lasttd');
		$('#addresses tr:eq('+lastElement+')').after("<tr><td class='personDetails_firsttd' style='font-weight:200; color:#036;'><?=$lang['street']?>:</td><td><input type='text' name='street[]' style='width:400px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td></tr><tr><td class='personDetails_firsttd' style='font-weight:200; color:#036;' nowrap><?=$lang['plz']?>:</td><td><input type='text' name='plz[]' style='width:400px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td></tr><tr><td class='personDetails_firsttd' style='font-weight:200; color:#036;'><?=$lang['city']?>:</td><td><input type='text' name='city[]' style='width:400px;' onKeyPress=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"></td></tr><tr><td class='personDetails_firsttd' style='font-weight:200; color:#036;'><?=$lang['country']?>:</td><td><select name='country[]' onChange=\"document.getElementById('changedContents').value='1'; $('#save').removeAttr('disabled'); $('#error').html('');\"><optgroup><?
			foreach($countries as $country)
			{
				echo "<option value='".$country['num_code']."' style='background-image:url(images/countries/".$country['iso2'].".gif); background-repeat:no-repeat; background-position:center left; padding-left:20px;'";
				if($country['num_code']==$user->settings['state_std_num'])
				{
					echo " selected";
				}
				echo ">".$country['name']."</option>";
			}
		?></optgroup></select></td></tr>");
	}
	$(function()
	{
		$('#phone_number_1').focus();
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