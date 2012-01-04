<div id='head'>Database installation</div>
<br><br>
<div align='center'>
<?php
	//Funktion zum Einfügen einer .sql Datei
	function import_sql_file($file)
	{
		$data=mysql_query("SHOW ENGINES");
		$engine="MyISAM";
		while($row=mysql_fetch_assoc($data))
		{
			if($row['Engine']=="InnoDB")
				$engine="InnoDB";
		}
		$exec="";
		$sql_inhalt=file($file);
		for($i=0;$i<count($sql_inhalt);$i++)
		{
			if(substr($sql_inhalt[$i],0,1)!='-')
			{ 
				if(strpos($sql_inhalt[$i], ';'))
				{
					$exec.=$sql_inhalt[$i];
					$exec=str_ireplace("<ENGINE>", $engine, $exec);
					mysql_query($exec);
					$exec="";
				}
				else
				{
					$exec.=$sql_inhalt[$i]; 
				}
			}
		}
	}
	
	$mysql=@mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWD);
	$connect=@mysql_select_db(MYSQL_DB, $mysql);
	if(!isset($_GET['install']))
	{
?>
	<table border='0' class='user'>
    	<tr>
        	<td>Database user:</td>
            <td><?=MYSQL_USER?></td>
        </tr>
        <tr>
        	<td>Database password:</td>
            <td><?=MYSQL_PASSWD?></td>
        </tr>
        <tr>
        	<td>Database:</td>
            <td><?=MYSQL_DB?></td>
        </tr>
	</table><br>
<?php
	if($mysql)
	{
		if($connect)
		{
			echo "<span style='color:green;'>Database connection could be established! These values should be correct.</span>";
		}
		else
		{
			echo "<span style='color:darkred;'>Database connection could be established, but the database '".MYSQL_DB."' doesn't exist! These values could be correct.<br>Please create the database!</span>";
		}
	}
	else
	{
		echo "<span style='color:red;'>Database connection couldn't be established! Are these values correct?<br>Please modify 'config/db.php' to match your configuration!</span>";
	}
?>
    <br><br><br>
    <input type='button' value='Install database layout' onClick="location.href='?step=2&install=true';" <?php if(!($connect AND $mysql)) echo "disabled"; ?>><br><br>
<?php
	}
	else
	{
?>
	Database layout gets installed...<br><br>
<?php
		//drop old data
		$sql="SHOW TABLES";
		$data=mysql_query($sql);
		if(mysql_num_rows($data))
		{
			while($row=mysql_fetch_assoc($data))
			{
				$sql1="DROP TABLE ".$row['Tables_in_'.MYSQL_DB];
				$data1=mysql_query($sql1);
			}
		}
		
		//create tables
		import_sql_file("../config/table_layout.sql");
		
		//insert data
		//countries
		import_sql_file("../config/countries.sql");
		//socialtypes
		import_sql_file("../config/socialtypes.sql");
		//numbertypes
		import_sql_file("../config/numbertype.sql");
		//users_groups
		import_sql_file("../config/users_groups.sql");
		
		echo "<script type='text/javascript'>
				location.href='?step=3';
			</script>";
	}
?>
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