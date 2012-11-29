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
	/* include our common functions file. */
	require_once 'common.inc.php';
	
	/* In this example we will use the same HTML form for both add and
	 * edit. To make this work we need to decide how the logic will 
	 * tell us if we are adding or eiting.
	 * 
	 * For this we will use the $record_id. All of our database entries
	 * have an auto generated id number. This number will always be a 
	 * posative integer. So if we define a variable for record ID and 
	 * set its initial value to -1 we can then read the CGI GET array 
	 * to find out if this page was loaded by an edit request. If it is 
	 * not set then we assume that we want an add request. */
	
	$record_id = -1;
	
	/* define field vars and set initially to empty strings.
	 * If we are doing an edit then they will be populated one we have
	 * retreived the record from the database. */
	$name = '';
	$phone_number = '';
	$email = '';
	$address = '';
	
	/* we default $heading to ADD and change later to EDIT if ID is set */
	$heading = "Add Address";
	$button_text = "Add Address";
	
	if (isset($_GET['id'])) {
		/* we in EDIT mode. */
		$record_id = $_GET['id'];
		
		/* change heading to EDIT */
		$heading = "Edit Address";
		$button_text = "Update Address";
		
		/* get the record from the database */
		$record = database_getRecordByID($record_id);
		if ($record) {
			$name = $record['name'];
			$phone_number = $record['phone_number'];
			$email = $record['email'];
			$address = $record['address'];
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo $heading;?></title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.21" />
	<link rel="stylesheet" type="text/css" href="../css/web-examples.css">
</head>

<body>
	
	<h1><?php echo $heading;?></h1>
	
	<!-- Add a link to the home page -->
	<a href="index.php">Home</a>
	
	<p>This page uses the HTML form element to group input boxes. It will wet the initial values of the form elements using the record from the database. It will then POST the new contents (after editing) of the boxes to another page, in our case another PHP script that will update the database record that already exists and redirect us back to the home page. This is a very basic input page and will not handle errors or missing fields. Its main purpose it to demonstrate the proccess of collecting data and forwarding it onto another script to insert it into our database table.</p>
	
	<!-- create the form element -->
	<form method="POST" action="process-changes.php">
		<!-- We set a hidden form element to the record ID so when we POST the form
		     the script will know if we want insert or update -->
		<input type="hidden" name="record_id" value="<?php echo $record_id;?>">
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
				<td colspan="2"><input type="submit" name="update" value="<?php echo $button_text;?>"></td>
			</tr>
		</table>
		
	</form>
</body>

</html>
