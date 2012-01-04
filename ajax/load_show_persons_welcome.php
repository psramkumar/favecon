<?php
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
	
	//Session-Start
	session_start();
	
	include("../includes/ajaxInits/includes.ajaxInit.php");
	
	//Starte Klassen
	$user=new user();
	
	//Sprache laden
	include("../translations/lang.".$user->settings['lang'].".php");
	
	
	//Ausgabe
	$stats=$user->get_statistics();
?>
<div style='margin:0px 20px; padding-right:20px; overflow:auto; height:100%; width:800px;'>
	<div class='welcome_header'><?=$lang['welcome_hello']?>, <?=$user->data['firstname']?> <?=$user->data['lastname']?>!</div>
<?php
	echo $lang['help']['welcome']."<br><br><br><br>";
	
	if($user->gid<=2 AND $user->settings['update_notification'])
	{
		//Hole Version
		$zeile=file("../config/version.txt");
		foreach($zeile as $z)
		{
			$version=$z;
		}
?>
	<span class='stats_header'><?=$lang['welcome_updates']?>:</span><br><br>
    <table class='stats_table' width='100%'>
        <tr>
            <td nowrap><?=$lang['updates_your_version']?></td>
            <td nowrap><?=$version?></td>
        </tr>
        <tr>
            <td nowrap><?=$lang['updates_new_version']?></td>
            <td nowrap>
<?php
	$version1=0;
	if(!in_array('curl', get_loaded_extensions()))
	{
		echo "<span style='color:darkred;'>".$lang['updates_no_curl']."</span>";
	}
	else
	{
		$curl_handler=curl_init();
		curl_setopt($curl_handler, CURLOPT_URL, CURL_UPDATE_URL.CURL_UPDATE_SCRIPT."?task=update");
		curl_setopt($curl_handler, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, 1);
		$version1=curl_exec($curl_handler);
		curl_close($curl_handler);
		
		if(empty($version1))
		{
			echo "<span style='color:darkred;'>".$lang['updates_server_not_available']."</span>";
		}
		else
		{
			echo $version1;
		}
	}
?>
			</td>
        </tr>
        <tr>
        	<td colspan='2' nowrap align='center'>
<?php
	if($version==$version1)
	{
		echo "<span style='color:green;'>".$lang['no_update_available']."</span>";
	}
	else if($version<$version1)
	{
		echo "<span style='color:red;'>".$lang['update_available']."</span>";
	}
	else
	{
		echo "<span style='color:darkred;'>".$lang['no_update_status']."</span>";
	}
?>
			</td>
		</tr>
    </table><br><br><br>
<?php
	}
?>
	<span class='stats_header'><?=$lang['welcome_stats']?>:</span><br><br>
    <table class='stats_table' width='100%'>
        <tr>
            <td nowrap><?=$lang['created_at']?></td>
            <td nowrap><?=date("Y-m-d h:i a", $stats['logins']['created_at'])?></td>
        </tr>
        <tr>
            <td nowrap><?=$lang['last_login']?></td>
            <td nowrap><?=date("Y-m-d h:i a", $stats['logins']['last_old_login'])?></td>
        </tr>
        <tr>
            <td nowrap><?=$lang['logins']?></td>
            <td nowrap><?=$stats['logins']['logins']?></td>
        </tr>
        <tr>
            <td nowrap><?=$lang['no_of_contacts']?></td>
            <td nowrap><?=$stats['persons']?></td>
        </tr>
        <tr>
            <td nowrap><?=$lang['no_of_numbers']?></td>
            <td nowrap><?=$stats['numbers']?></td>
        </tr>
        <tr>
            <td nowrap><?=$lang['no_of_addresses']?></td>
            <td nowrap><?=$stats['addresses']?></td>
        </tr>
        <tr>
            <td nowrap><?=$lang['no_of_emails']?></td>
            <td nowrap><?=$stats['emails']?></td>
        </tr>
        <tr>
            <td nowrap><?=$lang['no_of_websites']?></td>
            <td nowrap><?=$stats['websites']?></td>
        </tr>
        <tr>
            <td nowrap><?=$lang['no_of_socialcom']?></td>
            <td nowrap><?=$stats['socialcom']?></td>
        </tr>
    </table>
<?php
	if($user->settings['news'])
	{
		$news=$user->get_news("5");
?>
	<br><br><br>
    <span class='stats_header'><?=$lang['welcome_news']?>:</span><br><br>
    <table class='news_table' width='100%'>
<?php
	if(!$news[0])
	{
		echo "<tr>
				<td colspan='3' align='center'>".$lang['no_news']."</td>
			</tr>";
	}
	else
	{
		foreach($news[1] as $entry)
		{
			echo "<tr>
					<td class='td1'><span class='personLink' onClick=\"open_news('".$entry['ID']."', 'show_persons_welcome');\">".$entry['m_header']."</span></td>
					<td nowrap class='td3'>".date("Y-m-d h:i a", $entry['m_time'])."</td>
					<td nowrap class='td3'>".$entry['firstname']."&nbsp;<b>".$entry['lastname']."</b>&nbsp;(".$entry['username'].")
				</tr>
				<tr>
					<td colspan='3'>".trim(substr(nl2br($entry['m_body']), 0, 200))."&nbsp;...</td>
				</tr>";
		}
		echo "<tr>
				<td colspan='3'align='center'><span class='personLink' onClick=\"loadContentPage('all_news');\">".$lang['all_news']."</span></td>
			</tr>";
	}
?>
    </table>
<?php
	}
?>
</div>
<?php
	//Schließe MySQL
	mysql_close();
?>

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