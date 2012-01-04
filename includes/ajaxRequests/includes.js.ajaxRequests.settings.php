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
	//Show Settings Details
	function load_settings(detail, errorMsg)
	{
		var dothat=true;
		//Prüfe ob etwas verändert wurde, wenn ja -> Wirklich nicht speichern?
		if($('#changedContents').val()=="1")
		{
			loadContent=confirm(errorMsg);
			if(loadContent==false)
			{
				dothat=false;
			}
		}
		if(dothat)
		{
			showOverlays_showPerson();
			//Delinke
			$('.selectedDetails').removeClass();
			//AJAX-Request
			$.ajax({
				type: "POST",
				url: "ajax/settings/load_settings_"+detail+".php",
				error: function(){
					hideOverlays_showPerson();
					$('#DetailLink_'+detail).addClass('selectedDetails');
					$('#personDetails').html("AJAX-Request failed!");
				},
				success: function(data){
					hideOverlays_showPerson();
					$('#DetailLink_'+detail).addClass('selectedDetails');
					$('#personDetails').html(data);
				}
			});
		}
	}
	//Personal Info speichern
	function save_settings_personal_info()
	{
		if($('#changedContents').val()=="1")
		{
			showOverlays_showPerson();
			var dataSend=$('form').serialize();
			$.ajax({
				type: "POST",
				url: "ajax/settings/save_settings_personal_info.php",
				data: dataSend,
				error: function(){
					hideOverlays_showPerson();
					$("#error").html("<span style='color:red;'>AJAX-Request failed!</span>");
				},
				success: interpretSavedSettings
			  });
		}
	}
	//New passwd speichern
	function save_settings_passwd_change()
	{
		showOverlays_showPerson();
		var dataSend=$('form').serialize();
		$.ajax({
			type: "POST",
			url: "ajax/settings/save_settings_passwd_change.php",
			data: dataSend,
			error: function(){
				hideOverlays_showPerson();
				$("#error").html("<span style='color:red;'>AJAX-Request failed!</span>");
			},
			success: interpretSavedSettings
		  });
	}
	//Save Settings
	function save_settings_settings()
	{
		if($('#changedContents').val()=="1")
		{
			showOverlays_showPerson();
			var dataSend=$('form').serialize();
			$.ajax({
				type: "POST",
				url: "ajax/settings/save_settings_settings.php",
				data: dataSend,
				error: function(){
					hideOverlays_showPerson();
					$("#error").html("<span style='color:red;'>AJAX-Request failed!</span>");
				},
				success: interpretSavedSettings
			});
		}
	}
	//Schau ob wirklich gespeichert wurde...
	function interpretSavedSettings(xml)
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