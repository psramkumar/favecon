<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* * * * * * * *																								* * * * * * * *
	* * * * * * * *		   	 	  				 Language File: en_US						 					* * * * * * * *
	* * * * * * * *						 Entry in translations.txt: en;English;us								* * * * * * * *
	* * * * * * * *													       		 								* * * * * * * *
	* * * * * * * *						  Written 2010-2011 by Daniel Mühlbachler  								* * * * * * * *
	* * * * * * * *			    	   Copyright (C) 2010-2011 by Daniel Mühlbachler  							* * * * * * * *
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

	
	//Menu
	$lang['logout']="Logout";
	$lang['new_person']="New";
	$lang['settings']="Settings";
	$lang['user_mngmnt']="User Management";
	$lang['system_settings']="System Settings";
	$lang['news_mngmnt']="News Management";
	$lang['backup_recovery']="Backup &amp; Recovery";
	
	//Titles
	$lang['titles']['new_person']="Add new contact";
	$lang['titles']['contacts']="CONTACTS";
	$lang['titles']['system_settings']="System settings";
	$lang['titles']['search']="Search engine";
	$lang['titles']['backup_recovery']="Backup &amp; Recovery";
	
	//Help
	$lang['help']['add_new']="Please fill in the general contact information first.<br>Then you can add phone numbers, addresses, emails, et cetera.";
	$lang['help']['welcome']="<b>&quot;".$lang['new_person']."&quot;</b> - <b>add</b> a new contact<br><br><b>&quot;".$lang['settings']."&quot;</b> - edit your <b>personal settings</b><br><br><b>&quot;".$lang['backup_recovery']."&quot;</b> - <b>backup or restore</b> your contacts";
	
	//Buttons
	//General
	$lang['next']="Next";
	$lang['save']="Save";
	$lang['edit_button']="Edit";
	$lang['delete_button']="Delete";
	$lang['show_button']="Show";
	//Add
	$lang['add_phone_number']="Add new number";
	$lang['add_address']="Add new address";
	$lang['add_email']="Add new email";
	$lang['add_website']="Add new website";
	$lang['add_social_com']="Add new social network";
	$lang['add_user']="Add new user";
	$lang['add_news']="Add news";
	
	//Person related
	//Grundinfos
	$lang['title']="Title";
	$lang['firstname']="Firstname";
	$lang['lastname']="Lastname";
	$lang['bday']="Birthday";
	//Phone numbers
	$lang['phone_numbers']="Phone numbers";
	//Address
	$lang['addresses']="Addresses";
	$lang['street']="Street";
	$lang['plz']="Postal code";
	$lang['city']="City";
	$lang['country']="Country";
	//WWW
	$lang['emails']="E-Mails";
	$lang['email_url']="E-Mail address";
	$lang['websites']="Websites";
	$lang['website_url']="Website URL";
	//Social Coms
	$lang['social_com_name']="Username/Name";
	$lang['social_com_type']="Social Network";
	$lang['social_com_fbpid']="Facebook Profile ID:<br>(if username not available)";
	$lang['social_com_praefix']="Action";
	//Tab names
	$lang['general_info']="General Information";
	$lang['addresses_numbers']="Addresses &amp Phone numbers";
	$lang['www']="Websites &amp; E-Mails";
	$lang['social_com']="Social Networking";
	//Others
	$lang['infoText']="Short information";
	$lang['you_edit']="You are editing:";
	//Help
	$lang['addresses_numbers_help']="To <b>delete</b> an entry just <b>remove</b> the phone number or the street!<br>If you want to <b>add multiple</b> phone numbers or addresses at once,<br>just click on the <b>&quot;".$lang['add_phone_number']."&quot;</b> or <b>&quot;".$lang['add_address']."&quot;</b> button.";
	$lang['www_help']="To <b>delete</b> an entry just <b>remove</b> the website URL or the e-mail address!<br>If you want to <b>add multiple</b> websites or email addresses at once,<br>just click on the <b>&quot;".$lang['add_website']."&quot;</b> or <b>&quot;".$lang['add_email']."&quot;</b> button.";
	$lang['social_com_help']="To <b>delete</b> an entry just <b>set</b> the 'Social Network' to 'N/A' or <b>remove</b> the 'Username/Name'!<br>If you want to <b>add multiple</b> social networks at once,<br>just click on the <b>&quot;".$lang['add_social_com']."&quot;</b> button.";
	//Show infos
	$lang['no_numbers']="No phone numbers for this contact!";
	$lang['no_addresses']="No addresses for this contact!";
	$lang['no_emails']="No email addresses for this contact!";
	$lang['no_websites']="No websites for this contact!";
	$lang['no_social_coms']="No social networking entries for this contact!";
	//Infos, Errors
	$lang['new_pers_error']="Couldn't insert new contact in database!";
	$lang['new_pers_null_err']="You must fill in either firstname or lastname!";
	$lang['edit_failed']="New contact details couldn't be stored!";
	$lang['edit_finished']="New contact details has been saved!";
	
	//Google Maps related
	$lang['gmaps_show']="Show in Google Maps";
	//System settings
	$lang['system_gmaps_addon']="Google Maps";
	$lang['system_gmaps_key']="Google Maps API Key";
	
	//Facebook related
	$lang['select_fb_friend']="Select friend with Facebook";
	//Search friends...
	$lang['fb_friends_header']="Your friends";
	$lang['fb_wait']="Please wait a few seconds...";
	$lang['fb_search_no_data']="No related friends found!";
	$lang['fb_how_many_found']="friends found";
	//Settings
	$lang['settings_facebook_addon']="Facebook Integration";
	$lang['settings_fb_id']="Your Facebook Profile ID";
	//System settings
	$lang['system_facebook_addon']=$lang['settings_facebook_addon'];
	$lang['system_curl']="PHP cURL Extension needed!";
	$lang['system_fb_app_id']="Facebook Application ID";
	$lang['system_fb_secret']="Facebook Application Secret";
	//Settings error
	$lang['settings_fb_error']="Please fill in '".$lang['system_fb_app_id']."' and '".$lang['system_fb_secret']."'!";
	
	//User Management
	//Tab names
	$lang['um_users']="Users";
	$lang['um_add']="Add user";
	//User view (table or detail)
	$lang['um_delete']="Delete";
	$lang['um_username']="Username";
	$lang['um_group']="Group";
	$lang['um_title']="Title";
	$lang['um_firstname']="Firstname";
	$lang['um_lastname']="Lastname";
	$lang['um_email']="E-Mail";
	$lang['um_bday']="Birthday";
	$lang['um_passwd']="Password";
	$lang['um_enabled']="Activated";
	$lang['um_comment']="Comment";
	//Search
	$lang['um_live_search']="Live Search";
	$lang['um_how_many_found']="users found";
	$lang['no_users']="There are no users! (Maybe yourself?)";
	//Errors
	$lang['um_user_exist']="User already exists!";
	$lang['um_error']="Couldn't create new user!";
	
	//Search engine
	//Live-Search
	$lang['live_search_no_query']="Please type in a search string<br>to find related contacts!";
	$lang['live_search_no_data']="No related contacts found!";
	$lang['ext_search']="Advanced search...";
	//Advanced search
	$lang['search_no_query']="Please type in a search string to find related contacts!";
	$lang['search_no_data']=$lang['live_search_no_data'];
	//Table Output
	$lang['search']="Search query";
	$lang['search_contact']="Contact";
	$lang['search_found']="Found in...";
	$lang['how_many_found']="contacts found";
	//Adv. search in...
	$lang['search_lastname']="Lastname";
	$lang['search_firstname']="Firstname";
	$lang['search_title']="Title";
	$lang['search_bday']="Birthday";
	$lang['search_street']="Street";
	$lang['search_plz']="Postal code";
	$lang['search_city']="City";
	$lang['search_number']="Phone number";
	$lang['search_email']="E-Mail";
	$lang['search_url']="Website";
	$lang['search_uname']="Social Networking: Username";
	$lang['search_fb_pid']="Social Networking: Facebook ID";
	$lang['search_check_all']="Check all";
	$lang['search_uncheck_all']="Uncheck all";
	
	//Settings
	//Tab names
	$lang['personal_info']="Personal Information";
	$lang['passwd_change']="Change password";
	$lang['settings_settings']="Settings";
	//General info
	$lang['settings_title']=$lang['title'];
	$lang['settings_firstname']=$lang['firstname'];
	$lang['settings_lastname']=$lang['lastname'];
	$lang['settings_email']="E-Mail";
	$lang['settings_bday']=$lang['bday'];
	//Password change
	$lang['old_passwd']="Old password";
	$lang['new_passwd']="New password";
	$lang['new_passwd_confirm']="Repeat new password";
	//Settings
	$lang['settings_lang']="Language";
	$lang['settings_std_country']="Standard country";
	$lang['settings_contact_ordering']="Contact settings";
	$lang['settings_order']="Order contacts by";
	$lang['settings_show_persons']="'".$lang['titles']['contacts']."' list view";
	$lang['settings_show_persons1']="Alternative '".$lang['titles']['contacts']."' list view";
	$lang['settings_settings_search_engine']="Search engine";
	$lang['settings_search_show_limit']="Contacts shown in search engine (per page)";
	//System settings
	$lang['favecon_title']="FaveCon system name";
	$lang['system_lang']=$lang['settings_lang'];
	$lang['system_std_country']=$lang['settings_std_country'];
	$lang['system_update_notification']="Update notification";
	$lang['system_news']="News system";
	$lang['system_contact_ordering']=$lang['settings_contact_ordering'];
	$lang['system_order']=$lang['settings_order'];
	$lang['system_show_persons']=$lang['settings_show_persons'];
	$lang['system_show_persons1']=$lang['settings_show_persons1'];
	$lang['system_user_settings']="User settings";
	$lang['system_passwd_length']="Minimal password length";
	$lang['system_required_user_fields']="Required fields of a user";
	$lang['system_settings_search_engine']=$lang['settings_settings_search_engine'];
	$lang['system_search_show_limit']=$lang['settings_search_show_limit'];
	$lang['system_um_system_settings']="System settings";
	$lang['system_um_system_settings_users_limit']="Users shown in table (per page)";
	$lang['system_news_limit']="News shown in table (per page)";
	$lang['system_sorting']="Sort 'number types' and 'social networks'";
	$lang['system_addon_api']="Add-On settings";
	//Settings & System settings
	$lang['asc']="Ascending";
	$lang['desc']="Descending";
	//Sorting
	$lang['sorting_number_type']="Number types";
	$lang['sorting_social_type']="Social networks";
	//Errors
	$lang['settings_error']="Settings couldn't be saved!";
	$lang['settings_finished']="Settings has been saved!";
	$lang['pers_info_null_err']="You must fill in your ";
	$lang['passwd_err']="Couldn't save your new password!";
	$lang['passwd_changed']="New password has been saved!";
	$lang['short_passwd']="New password too short! Minimal length:";
	$lang['sorting_failed']="Can't save new arrangement!";
	$lang['sorting_finished']="New arrangement has beend saved!";
		
	//Security messages
	$lang['editError']="You have changed some data! To discard & proceed, click OK. To go back to the screen, click Cancel.";
	$lang['delete_msg']="Do you really want to delete this contact?";
	$lang['um_delete_msg']="Do you really want to delete this user?";
	$lang['news_delete_msg']="Do you really want to delete this news?";
	
	//Welcome page
	$lang['welcome_hello']="Hello";
	//Updates
	$lang['welcome_updates']="Version information";
	$lang['updates_your_version']="Your version";
	$lang['updates_new_version']="Actual version";
	$lang['updates_no_curl']="Please enable PHP cURL support to use this feature!";
	$lang['updates_server_not_available']="Either the update server is not available or you don't have an working internet connection!";
	$lang['no_update_available']="No update available!";
	$lang['update_available']="Update available! Please update!<br>Visit <a style=\"font-size:11px;\" href=\"".CURL_UPDATE_URL."\" target=\"_blank\">".CURL_UPDATE_URL."</a> for more information.";
	$lang['no_update_status']="Status can't be retrieved. Either you don't have cURL enabled or there was an error fetching the actual version!";
	//Stats
	$lang['welcome_stats']="Your statistics";
	$lang['created_at']="User since";
	$lang['last_login']="Last login";
	$lang['logins']="No. of logins";
	$lang['no_of_contacts']="No. of contacts";
	$lang['no_of_numbers']="No. of numbers";
	$lang['no_of_addresses']="No. of addresses";
	$lang['no_of_emails']="No. of emails";
	$lang['no_of_websites']="No. of websites";
	$lang['no_of_socialcom']="No. of social network users/entries";
	//News
	$lang['welcome_news']="News";
	$lang['no_news']="No news available!";
	$lang['back']="Back";
	$lang['all_news']="Show all news";
	
	//News Management
	$lang['news_news']="News";
	$lang['news_add']="Add news";
	$lang['news_live_search']="Live Search";
	//Infos
	$lang['news_header']="Title";
	$lang['news_time']="Time";
	$lang['news_from']="Submitted by";
	$lang['news_delete']="Delete";
	$lang['news_how_many_found']="news found";
	$lang['news_for_gid']="From group";
	$lang['news_body']="Message";
	//Errors
	$lang['news_error']="Can't create new news!";
	$lang['news_edited']="News has been updated!";
	
	//Backup & Recovery
	$lang['b_r_deleteall']="If you use the recovery feature please note that all data will be erased!";
	$lang['b_r_csv']="Comma-Separated-Value (CSV) format";
	$lang['b_r_xml']="Extensible Markup Language (XML) format";
	$lang['b_r_download']="Export - Download";
	$lang['b_r_import']="Import";
	$lang['b_r_export_personal']="Export for personal use";
	//Errors
	$lang['no_file']="No file has been uploaded!";
	$lang['wrong_data']="There are one or more invalid rows in the uploaded file!";
	$lang['import_success']="All data has been inserted!";
	$lang['no_innodb']="You must have tunred off InnoDB engine support. To use this feature, turn it on and convert all tables to InnoDB!";
	$lang['wrong_file_type']="Wrong file type!";
	
	//Numbertypes
	$lang['ntypes'][1]="Home";
	$lang['ntypes'][2]="Mobile";
	$lang['ntypes'][3]="Work";
	$lang['ntypes'][4]="Other";
	$lang['ntypes'][5]="Home Fax";
	$lang['ntypes'][6]="Work Fax";
	$lang['ntypes'][7]="Pager";
	
	//Info texts, Infos
	$lang['clear_input']="Clear input";
	//Contact Settings
	$lang['infos']['contact_settings']['header']="Help - ".$lang['settings_contact_ordering'];
	$lang['infos']['contact_settings']['text']="With <b>'".$lang['settings_show_persons']."'</b> and <b>'".$lang['settings_show_persons1']."'</b> you can design the output of the contact list at the left side.<br>
In that case <b>'".$lang['settings_show_persons']."'</b> is the standard output format for the ordered contact list on the left. Only if the ordering is not possible (e.g. because ther is no lastname stored) the <b>'".$lang['settings_show_persons1']."'</b> is used as the chosen output format for these contacts.<br><br>
Therefore the following data fields are available:<br>
<ul>
<li>firstname</li>
<li>lastname</li>
<li>title</li>
<li>bday (=birthday)</li>
</ul>
To use one of these data fields just put them into '/'. For example to use the field 'firstname' write '/firstname/'.<br><br>
Additionally you can add various text to the output. For example to get an output like 'John Doe is bad' just use: '/firstname/ /lastname/ is bad/'.<br><br>
To get a better overview you can style each element with the following style codes which are written before the data field name:
<ul>
<li><b>bold:</b> *</li>
<li><i>italic:</i> +</li>
</ul>
For example to get an output like '<b>John</b> Doe' just write: '/*firstname/ /lastname/'.<br><br>
If you want you can also <b>add line breaks</b>:
<ul>
<li><b>Code:</b> #</li>
<li>Example: '/*lastname/#/firstname/'</li>
</ul>";
	//Backup & Recovery
	$lang['infos']['backup_recovery']['csv']['header']="Help - CSV ".$lang['titles']['backup_recovery'];
	$lang['infos']['backup_recovery']['csv']['text']="This format is <b>only recommended</b> if you just want to backup your data!<br>
Please <b>notice</b> that the downloaded comma-separated-value (CSV) file is structured as follows:<br>
<ul>
	<li><i><b>Identifier:</b></i> defines to what the record is related:</li>
		<ul>
			<li><u>&quot;_person_&quot;</u> or <u>_person_</u> for the general contact information</li>
			<li><u>&quot;_number_&quot;</u> or <u>_number_</u> for a phone number</li>
			<li><u>&quot;_address_&quot;</u> or <u>_address_</u> for address information</li>
			<li><u>&quot;_website_&quot;</u> or <u>_website_</u> for a website</li>
			<li><u>&quot;_email_&quot;</u> or <u>_email_</u> for an email address</li>
			<li><u>&quot;_socialcom_&quot;</u> or <u>_socialcom_</u> for social communication information</li>
		</ul>
	<li><i><b>ID number:</b></i> is just an auto incremental number to identify record relationships</li>
	<li>All other required information for a record (<i>see later</i>)</li>
</ul><br>
Additionally, all records have <b>required</b> information fields which must either be empty or given!<br>
<u>personal contact information</u>:<br>
<ul>
	<li>firstname</li>
	<li>lastname</li>
	<li>title</li>
	<li>date of birth</li>
</ul>
<u>phone number</u>:<br>
<ul>
	<li>number type (ID number!)</li>
	<li>phone number</li>
</ul>
<u>address</u>:<br>
<ul>
	<li>street</li>
	<li>postal code</li>
	<li>city</li>
	<li>numerical country code</li>
</ul>
<u>website</u>:<br>
<ul>
	<li>website URL</li>
	<li>short informational text</li>
</ul>
<u>email address</u>:<br>
<ul>
	<li>email address</li>
	<li>short informational text</li>
</ul>
<u>social communication</u>:<br>
<ul>
	<li>type of social network (ID number!)</li>
	<li>username</li>
	<li>Facebook User ID (text value is also possible!)</li>
	<li>praefix number for link creation</li>
	<li>short informational text</li>
</ul><br>
However, <b>all</b> fields <b>except</b> those who are of the type <b>number/integer</b> <b>must</b> be covered with <b>&quot;&lt;VALUE&gt;&quot;</b>!";
	$lang['infos']['backup_recovery']['xml']['header']="Help - XML ".$lang['titles']['backup_recovery'];
	$lang['infos']['backup_recovery']['xml']['text']="This format is <b>recommended</b> because you may use the exported values for your own purpose too.<br><br>
In short, it is a <b>well structured</b> XML file with only <b>one special thing</b>:<br>
all addresses, numbers, websites, emails and social networks are indexed with an ID which is an auto increment integer and starts by '1' with each contact.<br><br>
<i><b>Information:</b></i> if you choose <i><u>'".$lang['b_r_export_personal']."'</u></i> all ID numbers will be replaced with their meanings <b>but notice</b> that you <b>cannot use</b> this XML file as a <b>valid backup</b> file and you will get these information too:<br>
<ul>
	<li>Country name</li>
	<li>Country ISO-2 code</li>
	<li>Country ISO-3 code</li>
	<li>Country numerical code</li>
	<li><b>No</b> praefix number for social network entries</li>
</ul>";
?>