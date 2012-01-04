<?php
	/********************
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
	
	*/
?>

<script type='text/javascript'>
	//Save System Settings
	function save_system_settings()
	{
		if($('#changedContents').val()=="1")
		{
			showOverlays_showPerson();
			var dataSend=$('form').serialize();
			$.ajax({
				type: "POST",
				url: "ajax/save_system_settings.php",
				data: dataSend,
				error: function(){
					hideOverlays_showPerson();
					$("#error").html("<span style='color:red;'>AJAX-Request failed!</span>");
				},
				success: interpretSavedSystemSettings
			});
		}
	}
	//Schau ob wirklich gespeichert wurde...
	function interpretSavedSystemSettings(xml)
	{
		if($(xml).find("done").text()=="true")
		{
			$('#changedContents').val("0");
			var error=$(xml).find("error").text();
			hideOverlays_showPerson();
			$('#save').attr("disabled", "true");
			$("#error").html("<span style='color:green;'>"+error+"</span>");
		}
		else
		{
			var error=$(xml).find("error").text();
			hideOverlays_showPerson();
			$("#error").html("<span style='color:red;'>"+error+"</span>");
		}
		$('#list_persons').load('ajax/load_show_persons_list.php');
	}
</script>