<!--
   edit-address.php
   
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
   
   
-->
<?php
	/* first check page $_GET[] array for id. 
	 * if its not found we will redirect to index. */
	$record_id = 0;
	if (isset($_GET['id'])) {
		$record_id = $_GET['id'];
	}
	else {
		/* id variable not found... redirect to index. */
		header ("Location: index.php");
		exit;
	}

	/* define vars */
	$name = '';
	$phone_number = '';
	$email = '';
	$address = '';
	
	/* now we must look up the record so we can add the data to the <form> 
	 * If the record cannot be found we will redirect to index. */
	
	/* like the index page we need to create a connection to the database */
	$link = mysql_connect("localhost", "examples", "p@ssw0rd");
	
	/* select our database */
	mysql_select_db("examples", $link);
	
	/* build INSERT SQL statement */	
	$sql = "SELECT * FROM addresses WHERE id=".$record_id;
	$result = mysql_query($sql, $link);
	
	if ( $result == TRUE ) {
		/* fetch record */
		$row = mysql_fetch_object($result);
		if ( $row ) {
			$name = $row->name;
			$phone_number = $row->phone_number;
			$email = $row->email;
			$address = $row->address;
		}
		else {
			/* record not found.. might be spoof */
			mysql_close($link);
			header ("Location: index.php");
			exit;
		}
	}
	else {
		/* query failed, close connection and redirect to index.php */
		mysql_close($link);
		header ("Location: index.php");
		exit;
	}
	
	/* final stage close database link and free results */
	mysql_free_result($result);
	mysql_close($link);
	
	/* all good if we get this far. Time to echo out HTML.. */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Edit Address</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.21" />
	<link rel="stylesheet" type="text/css" href="addressbook.css">
</head>

<body>
	<h1>Edit Address</h1>
	<!-- Add a link to the home page -->
	<a href="index.php">Home</a>
	
	<p>This page uses the HTML form element to group input boxes. It will wet the initial values of the form elements using the record from the database. It will then POST the new contents (after editing) of the boxes to another page, in our case another PHP script that will update the database record that already exists and redirect us back to the home page. This is a very basic input page and will not handle errors or missing fields. Its main purpose it to demonstrate the proccess of collecting data and forwarding it onto another script to insert it into our database table.</p>
	
	<!-- create the form element -->
	<form method="POST" action="update-entry.php">
		<!-- because this is an update we need to use the record ID so we can update the correct record -->
		<!-- for this we use a hidded form element -->
		<input type="hidden" name="id" value="<?php echo $record_id;?>">
		<!-- draw the data input form (we will use a table to keep it all aligned) -->
		<table>
			<tr>
				<th>Name:</th>
				<td><input type="text" name="name" maxlength="50" value="<?php echo $name; ?>"></td>
			</tr>
			<tr>
				<th>Phone Number:</th>
				<td><input type="text" name="phone_number" maxlength="15" value="<?php echo $phone_number; ?>"></td>
			</tr>
			<tr>
				<th>email:</th>
				<td><input type="text" name="email" maxlength="100" value="<?php echo $email; ?>"></td>
			</tr>
			<tr>
				<th>Address:</th>
				<td><textarea name="address"><?php echo $address; ?></textarea></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="update" value="Update Entry"></td>
			</tr>
		</table>
		
	</form>
</body>

</html>
