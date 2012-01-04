<?php
	$user=new user();
	
	//Translation laden
	include("translations/lang.".$user->settings['lang'].".php");

	if($user->settings['google_maps']==1)
	{
		echo "<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;key=".$user->settings['google_maps_key']."&sensor=false\" type='text/javascript'></script>";
	}
?>
<!-- Menubar and Content -->
<div id='top_bar'>
    <div id='menu'>
        <ul>
            <li onClick="loadContentPage('show_persons_welcome');"><img alt='FaveCon Logo' src="images/favecon.png" height='47px'  style='margin-right:3px; margin-top:-11px;'/></li>
            <li onClick="loadContentPage('new_person');"><?=$lang['new_person']?></li>
            <li onClick="loadContentPage('settings');"><?=$lang['settings']?></li>
<?php
	if($user->gid=="1" OR $user->gid=="2")
	{
		echo "<li onClick=\"loadContentPage('user_mngmnt');\">".$lang['user_mngmnt']."</li>";
		if($user->settings['news'])
		{
			echo "<li onClick=\"loadContentPage('news_mngmnt');\">".$lang['news_mngmnt']."</li>";
		}
	}
	if($user->gid=="1")
	{
		echo "<li onClick=\"loadContentPage('system_settings');\">".$lang['system_settings']."</li>";
	}
?>
            <li onClick="loadContentPage('backup_recovery');"><?=$lang['backup_recovery']?></li>
            <li onClick="loginRequest('logout');"><?=$lang['logout']?></li>
        </ul>
    </div>
    <div id='search' class='live_search'>
    	<input type='text' name='query' id='search_query' size='34' style='width:256px;' autocomplete="off" onKeyUp="live_search($(this).val());"/>
        <div id='live_search_results'>
			<div id='ls_results'>
            	
            </div>
           	<div id='extended_search_button' onClick="loadContentPage('search'); $('#live_search_results').toggle('blind', {}, 300);">
           		<div><?=$lang['ext_search']?></div>
            </div>
        </div>
    </div>
</div>
<div id='content'>
	<div id='pageContent'>
<?php
//Personen anzeigen
	echo "<div id='list_persons'></div>";
	
	//"Anzeigefenster"
	echo "<div id='persons_content'></div>";
?>
    </div>
</div>
<div id='footer'>
<?php
	include("copyright.php");
?>
</div>
<script type="text/javascript">
	$(function() {
		$('#list_persons').load('ajax/load_show_persons_list.php');
		$('#persons_content').load('ajax/load_show_persons_welcome.php');
	});
	
	$("#search_query").click(function() {
		if($('#live_search_results').css("display")=="none")
		{
			$("#live_search_results").toggle("blind", {}, 400);
			live_search($('#search_query').val());
		}
	});
	
	$(document).bind('click', function(e) {
		var $clicked = $(e.target);
		if (! $clicked.parents().hasClass("live_search"))
			$("#live_search_results").hide();
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