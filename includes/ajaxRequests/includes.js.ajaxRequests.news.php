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
	//Open News
	function open_news(id, backlink)
	{
		showOverlays();
		$('#persons_content').load('ajax/news/show.php?id='+id+'&backlink='+backlink);
		hideOverlays();
	}
	
	//Show News Details
	function load_news(detail, errorMsg)
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
				url: "ajax/news/load_news_"+detail+".php",
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
	//Lade News
	function load_news_table(order, order_type, limit)
	{
		var query=$("#news_search_query").val();
		var dataSend="order="+order+"&order_type="+order_type+"&limit="+limit+"&query="+query;
		$.ajax({
			type: "POST",
			url: "ajax/news/load_news_news_table.php",
			data: dataSend,
			error: function(){
				$('#news_news').html("AJAX-Request failed!");
			},
			success: function(data){
				$('#news_news').html(data);
			}
		});
	}
	//Edit news laden
	function load_edit_news(id)
	{
		showOverlays_showPerson();
		$('.selectedDetails').removeClass();
		var dataSend="id="+id;
		//AJAX-Request
		$.ajax({
			type: "POST",
			url: "ajax/news/load_edit_news.php",
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
	//Speichere geänderte Newsdaten
	function save_news(id)
	{
		if($('#changedContents').val()=="1")
		{
			showOverlays_showPerson();
			var formData=$('form').serialize();
			var dataSend="id="+id+"&"+formData;
			$.ajax({
				type: "POST",
				url: "ajax/news/save_news.php",
				data: dataSend,
				error: function(){
					hideOverlays_showPerson();
					$("#error").html("<span style='color:red;'>AJAX-Request failed!</span>");
				},
				success: interpretSavedNewsDetails
			});
		}
	}
	//Schau ob wirklich gespeichert wurde...
	function interpretSavedNewsDetails(xml)
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
	//Add new news...
	function add_news()
	{
		if($('#changedContents').val()=="1")
		{
			showOverlays_showPerson();
			var dataSend=$('form').serialize();
			$.ajax({
				type: "POST",
				url: "ajax/news/add_news.php",
				data: dataSend,
				error: function(){
					hideOverlays_showPerson();
					$("#error").html("<span style='color:red;'>AJAX-Request failed!</span>");
				},
				success: interpretAddedNews
			});
		}
	}
	//Schau ob wirklich gespeichert wurde...
	function interpretAddedNews(xml)
	{
		if($(xml).find("done").text()=="true")
		{
			hideOverlays_showPerson();
			$('#persons_content').load('ajax/load_news_mngmnt.php');
		}
		else
		{
			var error=$(xml).find("error").text();
			hideOverlays_showPerson();
			$("#error").html("<span style='color:red;'>"+error+"</span>");
		}
	}
	//Delete User
	function delete_news(id, errorMsg)
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
				url: "ajax/news/delete_news.php",
				data: dataSend,
				error: function(){
					hideOverlays_showPerson();
				},
				success: interpretDeletedNews
			});
		}
	}
	//gelöscht?
	function interpretDeletedNews(xml)
	{
		if($(xml).find("done").text()=="true")
		{
			hideOverlays_showPerson();
			$('#persons_content').load('ajax/load_news_mngmnt.php');
		}
	}
</script>