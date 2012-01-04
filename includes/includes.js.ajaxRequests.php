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
	// Lade Content von Menu-Request
	function loadContentPage(what) {
		showOverlays();
		$('#persons_content').load('ajax/load_'+what+'.php');
		hideOverlays();
	}
</script>

<?php
	include("ajaxRequests/includes.js.ajaxRequests.login.php");
	include("ajaxRequests/includes.js.ajaxRequests.person.php");
	include("ajaxRequests/includes.js.ajaxRequests.settings.php");
	include("ajaxRequests/includes.js.ajaxRequests.systemSettings.php");
	include("ajaxRequests/includes.js.ajaxRequests.sorting.php");
	include("ajaxRequests/includes.js.ajaxRequests.userMngmnt.php");
	include("ajaxRequests/includes.js.ajaxRequests.search.php");
	include("ajaxRequests/includes.js.ajaxRequests.news.php");
?>