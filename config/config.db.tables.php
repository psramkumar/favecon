<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* * * * * * * *																								* * * * * * * *
	* * * * * * * *		   		   	  DB Table Configuration for FaveCon AddressBook							* * * * * * * *
	* * * * * * * *													       		 								* * * * * * * *
	* * * * * * * *						 Written 2009-2011 by Daniel Mühlbachler  								* * * * * * * *
	* * * * * * * *			    	  Copyright (C) 2009-2011 by Daniel Mühlbachler 							* * * * * * * *
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
	
	//Table Variablen
	//USERS
	define('USERS_TBL',				'users');
	define('USERS_DATA_TBL',		'users_data');
	define('USERS_SETTINGS_TBL',	'users_settings');
	define('USERS_GROUPS_TBL',		'users_groups');
	//SYSTEM
	define('SETTINGS_TBL',			'settings');
	define('NEWS_TBL',				'news');
	define('STATES_TBL',			'countries');
	define('NUMBERTYPES_TBL',		'numbertype');
	define('SOCIALTYPES_TBL',		'socialtypes');
	//CONTACT ENTRIES / PERSONS
	define('PERSONS_TBL',			'persons');
	define('PERSONS_NUMBERS_TBL',	'persons_numbers');
	define('PERSONS_ADDRESSES_TBL',	'persons_addresses');
	define('PERSONS_EMAILS_TBL',	'persons_emails');
	define('PERSONS_WEBSITES_TBL',	'persons_websites');
	define('PERSONS_SOCIALCOM_TBL',	'persons_socialcom');
	
	//cURL Update URL
	define('CURL_UPDATE_URL',		'http://favecon.muehlbachler.org/');
	define('CURL_UPDATE_SCRIPT',	'curl.php');
?>