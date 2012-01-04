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
	//Show User Management Details
	function load_um(detail, errorMsg)
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
				url: "ajax/user_mngmnt/load_user_mngmnt_"+detail+".php",
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
	//Lade Users
	function load_users_table(order, order_type, limit)
	{
		var query=$("#um_search_query").val();
		var dataSend="order="+order+"&order_type="+order_type+"&limit="+limit+"&query="+query;
		$.ajax({
			type: "POST",
			url: "ajax/user_mngmnt/load_user_mngmnt_users_table.php",
			data: dataSend,
			error: function(){
				$('#um_users').html("AJAX-Request failed!");
			},
			success: function(data){
				$('#um_users').html(data);
			}
		});
	}
	//Edit user laden
	function load_edit_user(id)
	{
		showOverlays_showPerson();
		$('.selectedDetails').removeClass();
		var dataSend="id="+id;
		//AJAX-Request
		$.ajax({
			type: "POST",
			url: "ajax/user_mngmnt/load_edit_user.php",
			data: dataSend,
			error: function(){
				hideOverlays_showPerson();
				$('#personDetails').html("AJAX-Request failed!");
			},
			success: function(data){
				hideOverlays_showPerson();
				$('#personDetails').html(data);
			}
		  });
	}
	//Speichere geänderte Userdaten
	function save_user_details(id)
	{
		if($('#changedContents').val()=="1")
		{
			showOverlays_showPerson();
			var formData=$('form').serialize();
			var dataSend="id="+id+"&"+formData;
			$.ajax({
				type: "POST",
				url: "ajax/user_mngmnt/save_user_details.php",
				data: dataSend,
				error: function(){
					hideOverlays_showPerson();
					$("#error").html("<span style='color:red;'>AJAX-Request failed!</span>");
				},
				success: interpretSavedUserDetails
			});
		}
	}
	//Schau ob wirklich gespeichert wurde...
	function interpretSavedUserDetails(xml)
	{
		if($(xml).find("done").text()=="true")
		{
			$('#changedContents').val("0");
			var error=$(xml).find("error").text();
			hideOverlays_showPerson();
			$("#error").html("<span style='color:green;'>"+error+"</span>");
		}
		else
		{
			var error=$(xml).find("error").text();
			hideOverlays_showPerson();
			$("#error").html("<span style='color:red;'>"+error+"</span>");
		}
	}
	//Add new user...
	function add_user()
	{
		if($('#changedContents').val()=="1")
		{
			showOverlays_showPerson();
			var dataSend=$('form').serialize();
			$.ajax({
				type: "POST",
				url: "ajax/user_mngmnt/add_user.php",
				data: dataSend,
				error: function(){
					hideOverlays_showPerson();
					$("#error").html("<span style='color:red;'>AJAX-Request failed!</span>");
				},
				success: interpretAddedUser
			});
		}
	}
	//Schau ob wirklich gespeichert wurde...
	function interpretAddedUser(xml)
	{
		if($(xml).find("done").text()=="true")
		{
			hideOverlays_showPerson();
			$('#persons_content').load('ajax/load_user_mngmnt.php');
		}
		else
		{
			var error=$(xml).find("error").text();
			hideOverlays_showPerson();
			$("#error").html("<span style='color:red;'>"+error+"</span>");
		}
	}
	//Delete User
	function delete_user(id, errorMsg)
	{
		var dothat=true;
		reallydel=confirm(errorMsg);
		if(reallydel==false)
		{
			dothat=false;
		}
		if(dothat)
		{
			showOverlays_showPerson();
			var dataSend="id="+id;
			$.ajax({
				type: "POST",
				url: "ajax/user_mngmnt/delete_user.php",
				data: dataSend,
				error: function(){
					hideOverlays_showPerson();
				},
				success: interpretDeletedUser
			});
		}
	}
	//gelöscht?
	function interpretDeletedUser(xml)
	{
		if($(xml).find("done").text()=="true")
		{
			hideOverlays_showPerson();
			$('#persons_content').load('ajax/load_user_mngmnt.php');
		}
	}
</script>