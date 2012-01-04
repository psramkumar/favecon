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
	//Show Person-Layout
	function load_show_person(id, begin)
	{
		showOverlays_showPerson();
		var dataSend="id="+id+"&begin="+begin;
		//AJAX-Request
		$.ajax({
			type: "POST",
			url: "ajax/load_show_person.php",
			data: dataSend,
			error: function(){
				hideOverlays_showPerson();
				$("#error").html("AJAX-Request failed!");
			},
			success: function(data){
				hideOverlays_showPerson();
				$('#persons_content').html(data);
			}
		  });
	}
	//Show Person-Layout mit Check ob schon gespeichert
	function load_show_person1(id, begin, errorMsg)
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
			load_show_person(id, begin);
		}
	}
	//Show Person Details
	function load_show_person_details(id, detail)
	{
		showOverlays_showPerson();
		//Delinke
		$('.selectedDetails').removeClass();
		var dataSend="id="+id;
		//AJAX-Request
		$.ajax({
			type: "POST",
			url: "ajax/person/show/load_show_person_details_"+detail+".php",
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
</script>