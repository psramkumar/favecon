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
	//Neue Person anlegen
	function create_new_person() {
		showOverlays();
		var dataSend=$('form').serialize();
		$.ajax({
			type: "POST",
			url: "ajax/person/create_new_person.php",
			data: dataSend,
			error: function(data){
				hideOverlays();
				$("#error").html("AJAX-Request failed!");
			},
			success: create_new_person1
		  });
	}
	function create_new_person1(xml)
	{
		if($(xml).find("done").text()=="true")
		{
			$('#list_persons').load('ajax/load_show_persons_list.php');
			load_edit_person($(xml).find("id").text(), "addresses_numbers", true);
		}
		else
		{
			var error=$(xml).find("error").text();
			hideOverlays();
			$("#error").html(error);
		}
	}
</script>