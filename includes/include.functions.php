<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* * * * * * * *																								* * * * * * * *
	* * * * * * * *		   	       Alle benötigten PHP-Funktionen für FaveCon AddressBook						* * * * * * * *
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

	
	//Beginn: Coding-Functions
	//Funktion zum codieren
	function encode($string, $hash)
	{
		$specialchars=array();
		$whattodo=array();
		
		$string=preg_replace("/\\_/", "_underscore_", $string);
		
		$specialchars[]="/\\!/";
		$specialchars[]="/\\§/";
		$specialchars[]="/\\$/";
		$specialchars[]="/\\%/";
		$specialchars[]="/\\&/";
		$specialchars[]="/\\//";
		$specialchars[]="/\\(/";
		$specialchars[]="/\\)/";
		$specialchars[]="/\\=/";
		$specialchars[]="/\\?/";
		$specialchars[]="/\\°/";
		$specialchars[]="/\\`/";
		$specialchars[]="/\\Ü/";
		$specialchars[]="/\\*/";
		$specialchars[]="/\\Ö/";
		$specialchars[]="/\\Ä/";
		$specialchars[]="/\\'/";
		$specialchars[]="/\\;/";
		$specialchars[]="/\\:/";
		$specialchars[]="/\\>/";
		$specialchars[]="/\\^/";
		$specialchars[]="/\\ß/";
		$specialchars[]="/\\´/";
		$specialchars[]="/\\ü/";
		$specialchars[]="/\\+/";
		$specialchars[]="/\\ö/";
		$specialchars[]="/\\ä/";
		$specialchars[]="/\\#/";
		$specialchars[]="/\\,/";
		$specialchars[]="/\\./";
		$specialchars[]="/\\-/";
		$specialchars[]="/\\</";
		$specialchars[]="/\\{/";
		$specialchars[]="/\\[/";
		$specialchars[]="/\\]/";
		$specialchars[]="/\\}/";
		$specialchars[]="/\\\/";
		$specialchars[]="/\\~/";
		$specialchars[]="/\\|/";
		$specialchars[]="/\\@/";
		$specialchars[]="/\\/";
		$specialchars[]="/\\ /";
		
		$how=count($specialchars);
		for($i=0; $i<$how; $i++)
		{
			$whattodo[]="_".$i."_";
		}
		
		$string=preg_replace($specialchars, $whattodo, $string);
		
		$key=substr($hash, 7, 5);
		$string=str_rot13($string);
		$string=$key.$string;
		$string=$hash.str_rot13($string);
		$string=str_rot13($string);
		return $string;
	}
	
	//Funktion zum decodieren
	function decode($string, $hash)
	{
		$string=str_rot13($string);
		$string=explode($hash, $string);
		$string=str_rot13($string[1]);
		$key=substr($hash, 7, 5);
		$string=explode($key, $string);
		$string=$string[1];
		$string=str_rot13($string);
		
		$specialchars=array();
		$whattodo=array();
		
		$specialchars[]="!";
		$specialchars[]="§";
		$specialchars[]="$";
		$specialchars[]="%";
		$specialchars[]="&";
		$specialchars[]="/";
		$specialchars[]="(";
		$specialchars[]=")";
		$specialchars[]="=";
		$specialchars[]="?";
		$specialchars[]="°";
		$specialchars[]="`";
		$specialchars[]="Ü";
		$specialchars[]="*";
		$specialchars[]="Ö";
		$specialchars[]="Ä";
		$specialchars[]="'";
		$specialchars[]=";";
		$specialchars[]=":";
		$specialchars[]=">";
		$specialchars[]="^";
		$specialchars[]="ß";
		$specialchars[]="´";
		$specialchars[]="ü";
		$specialchars[]="+";
		$specialchars[]="ö";
		$specialchars[]="ä";
		$specialchars[]="#";
		$specialchars[]=",";
		$specialchars[]=".";
		$specialchars[]="-";
		$specialchars[]="<";
		$specialchars[]="{";
		$specialchars[]="[";
		$specialchars[]="]";
		$specialchars[]="}";
		$specialchars[]="\\";
		$specialchars[]="~";
		$specialchars[]="|";
		$specialchars[]="@";
		$specialchars[]="";
		$specialchars[]=" ";
		
		$how=count($specialchars);
		for($i=0; $i<$how; $i++)
		{
			$whattodo[]="/_".$i."_/";
		}
		
		$string=preg_replace($whattodo, $specialchars, $string);
		
		$string=preg_replace("/_underscore_/", "_", $string);
		
		return $string;
	}
	//Ende: Coding-Functions
	
	//Beginn: Hash-Functions
	//Funktion zur Creation eines Userhashes
	function create_hash($addition="", $timestamp="")
	{
		//Wenn Timestamp leer, nimm aktuellen
		if($timestamp=="")
		{
			$timestamp=time();
		}
		
		//Erstelle Hash
		$hash="";
		$pool="1234567890";
		$pool.="abcdefghijklmnopqrstuvwxyz";
		$pool.="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$pool.=$addition;
		$pool.=$timestamp;
		for($r=1; $r<=20; $r++)
		{
			srand((double)microtime()*1000000);
			$hash.=substr($pool,(rand()%(strlen ($pool))), 1);
		}
		return $hash;
	}
	
	//Userhash holen!!
	function get_userhash($uid)
	{
		$sql="SELECT user_hash FROM ".USERS_TBL." WHERE ID='".$uid."'";
		$data=mysql_query($sql);
		while($row=mysql_fetch_assoc($data))
		{
			$hash=$row['user_hash'];
		}
		return $hash;
	}
	//Ende: Hash-Functions
	
	//Beginn: Import- & Export-Functions
	//Schau nach, ob alle Tables in InnoDB Engine sind
	function check_innodb()
	{
		$sql="SHOW TABLE STATUS FROM ".MYSQL_DB." WHERE Engine!='InnoDB'";
		$data=mysql_query($sql);
		if(mysql_num_rows($data))
			return false;
		return true;
	}
	//Funktion zum Ersetzen des ";"
	function replace_semicolon($replace_bool, $text)
	{
		$search=";";
		$rep="_01_";
		if($replace_bool)
		{
			$search="_01_";
			$rep=";";
		}
		return str_ireplace($search, $rep, $text);
	}
	//Funktion zur XML Bearbeitung
	function XML2Array($xmlStartElement)
	{
		$array=array();
		foreach($xmlStartElement->tagChildren as $child)
		{
			if(count($child->tagChildren)>0)
				$array[$child->tagName][$child->tagAttrs['id']]=XML2Array($child);
			else
				$array[$child->tagName]=$child->tagData;
		}
		return $array;
	}
	//Ende: Import- & Export-Functions
?>