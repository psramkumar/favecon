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
	// Request senden
	function live_search(query)
	{
		var dataSend="query="+query;
		$.ajax({
			type: "POST",
			url: "ajax/search/live_search.php",
			data: dataSend,
			error: function(){
				$('#ls_results').html("AJAX-Request failed!");
			},
			success: function(data){
				$('#ls_results').html(data);
			}
		});
	}
	
	function ext_search(limit)
	{
		var query=$('#ssearch_query').val();
		var formData=$('form#search_rows').serialize();
		var dataSend=formData+"&limit="+limit+"&query="+query;
		$.ajax({
			type: "POST",
			url: "ajax/search/search.php",
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