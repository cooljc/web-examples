<?php
/*
 * Filename: common.inc.php
 * 
 * Copyright 2012 Jon Cross <joncross.cooljc@gmail.com>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */

/* ==================================================================
 * This file is used for all common functions and variables. If written
 * well it can be used as an abstraction layer allowing you to replace
 * core parts without needing to rewrite the entire application.
 * For example if you changes your database backend from MySQL to Oracle
 * you should only need to edit this file. As long as your functions 
 * return the data that is required.
 * ================================================================== */

/* ------------------------------------------------------------------ */
/* define global variables */
/* ------------------------------------------------------------------ */
$DATABASE_SERVER = "localhost";
$DATABASE_USER   = "examples";
$DATABASE_PASS   = "p@ssw0rd";
$DATABASE_DB     = "examples";

/* ==================================================================
 * In this exmample we will make use of PHPs ability to declare 
 * functions. Functions a great for grouping functionality in one 
 * place. 
 * 
 * When naming functions its a good idea to stick to some sort
 * of convention. 
 * For example in this file I am prefixing the function
 * name with "database_" followed by the operation "connect" or 
 * "disconnect" etc. When the operation contains more than one word
 * I will use camelCase where the first word is all lower case and the
 * first character of the following words is capital.
 * Eg. database_insertAddress or database_updateAddress
 * ================================================================== */

/* ------------------------------------------------------------------ */
/* database_connect()
 * This function creates a connection to our database backend. */
/* ------------------------------------------------------------------ */
function database_connect() 
{
	/* to use global variables in a function you need to declare them */
	global $DATABASE_SERVER, $DATABASE_USER, $DATABASE_PASS, $DATABASE_DB;
	
	/* now we can use the mysql_connect() function passing in our variables */
	$link = mysql_connect($DATABASE_SERVER, $DATABASE_USER, $DATABASE_PASS);
	
	/* select our database */
	mysql_select_db($DATABASE_DB, $link);
	
	/* return $link to caller */
	return $link;
}

/* ------------------------------------------------------------------ */
/* database_disconnect()
 * This function closes the connection to our database backend. */
/* ------------------------------------------------------------------ */
function database_disconnect($link)
{
	mysql_close($link);
}

/* ------------------------------------------------------------------ */
/* database_getAddressBook()
 * This function will return an array of arrays. */
/* ------------------------------------------------------------------ */
function database_getAddressBook()
{
	/* define return array */
	$ret = array();
	
	/* connect to database */
	$link = database_connect();
	
	/* build SQL */
	$sql = "SELECT * FROM addresses";
	
	/* execute query */
	if ($result = mysql_query($sql, $link)) {
		if ($row = mysql_fetch_array($result)) {
			/* loop through results until no more rows */
			do {
				/* append row to array */
				$ret[] = $row;
			} while($row = mysql_fetch_array($result));
		}
		mysql_free_result($result);
	}
	
	/* close connection */
	database_disconnect($link);
	
	/* return array */
	return $ret;
}

/* ------------------------------------------------------------------ */
/* database_getRecordByID()
 * This function looks up a record by ID */
/* ------------------------------------------------------------------ */
function database_getRecordByID($record_id)
{
	/* define ret value to false 
	 * if we successfully find the record this will be set to the 
	 * record array. */
	$ret = false;
	
	/* connect to database */
	$link = database_connect();
	
	/* build SQL */
	$sql = "SELECT * FROM addresses WHERE id=".$record_id;
	
	/* execute query */
	if ($result = mysql_query($sql, $link)) {
		if ($row = mysql_fetch_array($result)) {
			$ret = $row;
		}
		mysql_free_result($result);
	}
	
	/* close connection */
	database_disconnect($link);
	
	/* return array */
	return $ret;
}

/* ------------------------------------------------------------------ */
/* database_addUpdateRecord()
 * This function is used to INSERT or UPDATE an address record. */
/* ------------------------------------------------------------------ */
function database_addUpdateRecord($data) 
{
	/* connect to database */
	$link = database_connect();
	
	/* define variable for SQL string */
	$sql = ""; 
	
	/* check if we are adding or updating.. */
	if ($data['record_id'] == -1) {
		/* insert mode */
		/* build INSERT SQL statement */	
		$sql = "INSERT INTO addresses (name, phone_number, email, address, date_created) ";
		$sql .= "VALUES('".$data['name']."', '".$data['phone_number']."', '".$data['email']."', '".$data['address']."', UNIX_TIMESTAMP())";
	}
	else {
		/* update mode */
		/* build UPDATE SQL statement */	
		$sql = "UPDATE addresses SET ";
		$sql .= "name='".$data['name']."', ";
		$sql .= "phone_number='".$data['phone_number']."', ";
		$sql .= "email='".$data['email']."', ";
		$sql .= "address='".$data['address']."' ";
		$sql .= "WHERE id=".$data['record_id'];
	}
	
	/* perform INSERT/UPDATE. For this we simply just use mysql_query() */
	$result = mysql_query($sql, $link);
	
	/* we can check $result to find out if the insert was successful */
	if ($result == FALSE) {
		/* INSERT/UPDATE failed.. do something.. In this situation you could
		 * direct to an error page or simply ignor it.. Really depends
		 * on your application. */
	}
	
	/* close connection */
	database_disconnect($link);
}

/* ------------------------------------------------------------------ */
/* ------------------------------------------------------------------ */


/* ------------------------------------------------------------------ */
/* ------------------------------------------------------------------ */

?>
