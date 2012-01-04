/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * *																								* * * * * * * *
* * * * * * * *	     Alle benötigten Backup & Recovery JavaScript-Funktionen für FaveCon AddressBook		* * * * * * * *
* * * * * * * *													       		 								* * * * * * * *
* * * * * * * *							Written 2010-2011 by Daniel Mühlbachler  							* * * * * * * *
* * * * * * * *			    	     Copyright (C) 2010-2011 by Daniel Mühlbachler  						* * * * * * * *
* * * * * * * *											   		    										* * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

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

*/
	

function download_backup(what)
{
	var file="backup.php";
	if($('#personal_use_'+what).attr('checked'))
		file="backup_personal.php";
	document.getElementById('download_iframe').src="backup_recovery/"+what+"/"+file;
}

function import_backup(what)
{
	showOverlays();
	$.ajaxFileUpload({
		url: 'backup_recovery/'+what+'/recovery.php',
		secureuri: false,
		fileElementId: what+'_file',
		error: function(data){
			$("#error").html("<span style='color:red;'>AJAX-Request failed!</span>");
			hideOverlays();
		},
		success: interpretInformation
	});
}

function interpretInformation(xml)
{
	hideOverlays();
	if($(xml).find("done").text()=="true")
	{
		var error=$(xml).find("error").text();
		$("#error").html("<span style='color:green;'>"+error+"</span>");
		$('#list_persons').load('ajax/load_show_persons_list.php');
	}
	else
	{
		var error=$(xml).find("error").text();
		$("#error").html("<span style='color:red;'>"+error+"</span>");
	}
}
