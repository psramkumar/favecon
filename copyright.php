<?php
	//Hole Version
	$zeile=file("config/version.txt");
	foreach($zeile as $z)
	{
		$version=$z;
	}
?>
<div>
	Copyright &copy; 2010-2011 by <a href='http://www.muehlbachler.org' target='_blank'>Daniel M&uuml;hlbachler</a>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;v<span style='font-size:11px;'><?=$version?></span>
</div>

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