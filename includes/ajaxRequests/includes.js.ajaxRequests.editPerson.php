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
	//Edit Person
	function load_edit_person(id, begin, overlay)
	{
		if(overlay==false)
		{
			showOverlays();
		}
		
		//Wenn Overlay existiert -> kommt von Create Person
		if(overlay==true)
		{
			//Lade Show Persons
			$('#list_persons').load('ajax/load_show_persons_list.php');
		}
		
		var dataSend="id="+id+"&begin="+begin;
		//AJAX-Request
		$.ajax({
			type: "POST",
			url: "ajax/load_edit_person.php",
			data: dataSend,
			error: function(){
				hideOverlays();
				$("#error").html("AJAX-Request failed!");
			},
			success: function(data){
				hideOverlays();
				$('#persons_content').html(data);
			}
		  });
	}
	//Edit Person Panel...
	function load_edit_person_panel(id)
	{
		var dataSend="id="+id;
		//AJAX-Request
		$.ajax({
			type: "POST",
			url: "ajax/load_edit_person_panel.php",
			data: dataSend,
			error: function(){
				$('#personDetail_links').html("AJAX-Request failed!");
			},
			success: function(data){
				$('#personDetail_links').html(data);
			}
		});
	}
	function load_edit_person_panel_save(id, what)
	{
		var dataSend="id="+id;
		//AJAX-Request
		$.ajax({
			type: "POST",
			url: "ajax/load_edit_person_panel.php",
			data: dataSend,
			error: function(){
				$('#personDetail_links').html("AJAX-Request failed!");
			},
			success: function(data){
				$('#personDetail_links').html(data);
				$('#DetailLink_'+what).addClass('selectedDetails');
			}
		});
	}
	//Edit Person Details
	function load_edit_person_details(id, detail, errorMsg)
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
			var dataSend="id="+id;
			//AJAX-Request
			$.ajax({
				type: "POST",
				url: "ajax/person/edit/load_edit_person_details_"+detail+".php",
				data: dataSend,
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
	//General Info speichern
	function save_personDetails_general_info(id)
	{
		if($('#changedContents').val()=="1")
		{
			showOverlays_showPerson();
			var formData=$('form').serialize();
			var dataSend="id="+id+"&"+formData;
			$.ajax({
				type: "POST",
				url: "ajax/person/edit/save_personDetails_general_info.php",
				data: dataSend,
				error: function(){
					hideOverlays_showPerson();
					$("#error").html("<span style='color:red;'>AJAX-Request failed!</span>");
				},
				success: interpretSavedInformation,
				complete: function(){
					load_edit_person_panel_save(id, "general_info");
				}
			  });
		}
	}
	//WWW Info speichern
	function save_personDetails_www(id)
	{
		if($('#changedContents').val()=="1")
		{
			showOverlays_showPerson();
			var formData=$('form').serialize();
			var dataSend="id="+id+"&"+formData;
			$.ajax({
				type: "POST",
				url: "ajax/person/edit/save_personDetails_www.php",
				data: dataSend,
				error: function(){
					hideOverlays_showPerson();
					$("#error").html("<span style='color:red;'>AJAX-Request failed!</span>");
				},
				success: interpretSavedInformation,
				complete: function(){
					load_edit_person_panel_save(id, "www");
				}
			});
		}
	}
	//Addresses and Numbers speichern
	function save_personDetails_addresses_numbers(id)
	{
		if($('#changedContents').val()=="1")
		{
			showOverlays_showPerson();
			var formData=$('form').serialize();
			var dataSend="id="+id+"&"+formData;
			$.ajax({
				type: "POST",
				url: "ajax/person/edit/save_personDetails_addresses_numbers.php",
				data: dataSend,
				error: function(){
					hideOverlays_showPerson();
					$("#error").html("<span style='color:red;'>AJAX-Request failed!</span>");
				},
				success: interpretSavedInformation,
				complete: function(){
					load_edit_person_panel_save(id, "addresses_numbers");
				}
			});
		}
	}
	//Social Com Type specific laden
	function view_details(what, id)
	{
		var what=$(what).val();
		var dataSend="id="+what+"&i="+id;
		//AJAX-Request
		$.ajax({
			type: "POST",
			url: "ajax/person/edit/load_edit_person_details_social_com_type.php",
			data: dataSend,
			error: function(){
				$('#error').html("<span style='color:red;'>AJAX-Request failed!</span>");
			},
			success: function(data){
				$('#social_com_'+id).html(data);
			}
		});
	}
	//Social Coms speichern
	function save_personDetails_social_com(id)
	{
		if($('#changedContents').val()=="1")
		{
			showOverlays_showPerson();
			var formData=$('form').serialize();
			var dataSend="id="+id+"&"+formData;
			$.ajax({
				type: "POST",
				url: "ajax/person/edit/save_personDetails_social_com.php",
				data: dataSend,
				error: function(){
					hideOverlays_showPerson();
					$("#error").html("<span style='color:red;'>AJAX-Request failed!</span>");
				},
				success: interpretSavedInformation,
				complete: function(){
					load_edit_person_panel_save(id, "social_com");
				}
			});
		}
	}
	//Schau ob wirklich gespeichert wurde...
	function interpretSavedInformation(xml)
	{
		if($(xml).find("done").text()=="true")
		{
			$('#changedContents').val("0");
			$('#save').attr("disabled", "true");
			var error=$(xml).find("error").text();
			hideOverlays_showPerson();
			$("#error").html("<span style='color:green;'>"+error+"</span>");
			$('#list_persons').load('ajax/load_show_persons_list.php');
		}
		else
		{
			var error=$(xml).find("error").text();
			hideOverlays_showPerson();
			$("#error").html("<span style='color:red;'>"+error+"</span>");
		}
	}
</script>