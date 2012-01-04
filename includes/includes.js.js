/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * *																								* * * * * * * *
* * * * * * * *		   		 Alle benötigten JavaScript-Funktionen für FaveCon AddressBook					* * * * * * * *
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
	

//Select some text within span, ...
function selectText(node) {
//This is a third party function written by Martin Honnen
var selection, range, doc, win;
if ((doc = node.ownerDocument) && (win = doc.defaultView) && typeof
win.getSelection != 'undefined' && typeof doc.createRange != 'undefined'
&& (selection = window.getSelection()) && typeof
selection.removeAllRanges != 'undefined') {
range = doc.createRange();
range.selectNode(node);
selection.removeAllRanges();
selection.addRange(range);
} else if (document.body && typeof document.body.createTextRange !=
'undefined' && (range = document.body.createTextRange())) {
range.moveToElementText(node);
range.select();
}
}


function showOverlays_login()
{
	$('<div />').addClass('overlay1').appendTo('body').show();
	$('<div />').addClass('overlay2').appendTo('body').show();
}

function hideOverlays_login()
{
	$('.overlay1').remove();
	$('.overlay2').remove();
}

function showOverlays()
{
	$('<div />').addClass('overlay5').appendTo('#persons_content').show();
	$('<div />').addClass('overlay6').appendTo('#persons_content').show();
}

function hideOverlays()
{
	$('.overlay5').remove();
	$('.overlay6').remove();
}

function showOverlays_showPerson()
{
	$('<div />').addClass('overlay3').appendTo('#personDetails').show();
	$('<div />').addClass('overlay4').appendTo('#personDetails').show();
}

function hideOverlays_showPerson()
{
	$('.overlay3').remove();
	$('.overlay4').remove();
}

//Show Address in Google Maps
function gmaps_toggle(id)
{
	if($('#gmaps_tr_'+id).length > 0)
	{
		$('#gmaps_tr_'+id).remove();
		$('tr.gmaps_toggle').removeClass('gmaps_toggle_border');
	}
	else
	{
		$('#gmaps_'+id).last().append("<tr id='gmaps_tr_"+id+"'><td></td></tr>");
		$('tr.gmaps_toggle').addClass('gmaps_toggle_border');
		var dataSend="id="+id;
		//AJAX-Request
		$.ajax({
			type: "POST",
			url: "ajax/person/show/load_gmap.php",
			data: dataSend,
			error: function(){
				$("#gmaps_tr_"+id+" td").html("AJAX-Request failed!");
			},
			success: function(data){
				$("#gmaps_tr_"+id+" td").html(data);
			}
		});
	}
}

//Info laden
function load_info(what)
{
	window.open("infos/"+what+".php", what, "width=655,height=700,status=no,scrollbars=yes,toolbar=no,resizable=yes,menubar=no,location=no,dependent=yes");
}

//Facebook_friends laden
function load_no_lang_info(what, id)
{
	window.open("infos/"+what+".php?info="+id, what, "width=655,height=700,status=no,scrollbars=yes,toolbar=no,resizable=yes,menubar=no,location=no,dependent=yes");
}