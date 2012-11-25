<?php
/*
	update-entry.php

	Copyright 2012 Jon Cross <joncross.cooljc@gmail.com>

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
	MA 02110-1301, USA.
*/
	/* this document is pure php and is not intented to be used to 
	 * display the data in the clients browser. It will execute server
	 * side and then redirect to the original index page. */
	
	/* first we will define some variables for our data setting them all empty */
	$name = '';
	$phone_number = '';
	$email = '';
	$address = '';
	$record_id = $_POST['id'];
	
	/* now we need to collect the form data posted to the script */
	/* We will use the php "isset()" function to make sure there is data.
	 * If the user did not enter data for a field then php might throw
	 * a warning/error depending on internal settings/config.. Using
	 * the "isset() ensures we have data before trying to read it. */
	if (isset($_POST['name'])) {
		$name = $_POST['name'];
	}
	
	if (isset($_POST['phone_number'])) {
		$phone_number = $_POST['phone_number'];
	}
	
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
	}
	
	if (isset($_POST['address'])) {
		$address = $_POST['address'];
	}
	
	/* like the index page we need to create a connection to the database */
	$link = mysql_connect("localhost", "examples", "p@ssw0rd");
	
	/* select our database */
	mysql_select_db("examples", $link);
	
	/* build UPDATE SQL statement */	
	$sql = "UPDATE addresses SET ";
	$sql .= "name='".$name."', ";
	$sql .= "phone_number='".$phone_number."', ";
	$sql .= "email='".$email."', ";
	$sql .= "address='".$address."' ";
	$sql .= "WHERE id=".$record_id;
	
	/* perform UPDATE. For this we simply just use mysql_query() */
	$result = mysql_query($sql, $link);
	
	/* we can check $result to find out if the insert was successful */
	if ($result == FALSE) {
		/* UPDATE failed.. do something.. In this situation you could
		 * direct to an error page or simply ignor it.. Really depends
		 * on your application. */
	}
	
	/* its good practice to close you connect once your finished. 
	 * it save overhead on the server doing house keeping by removing
	 * stale connections when they have been idle for a long time.
	 * In a small scale projects its no big deal but if you are getting
	 * hundereds of connections a minute it can cause big problems and 
	 * might even take your server down if your not careful. */
	mysql_close($link);
	
	/* now we have inserted the record we will redirect to our main
	 * index page using the "header()" function. This function allows
	 * the php to set various header in the HTTP protocol causing the
	 * browser to react accordingly. In the example "Location:" tells
	 * the browser to relocate another page. */
	header("Location: index.php");
?>
