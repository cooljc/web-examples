<!--
   index.php

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
/* include the common functions file */
require_once "common.inc.php";

/* create a variable for table title and set to addresses by default */
$table_title = "Addresses:";

/* create a variable for the search string and set empty */
$search_string = "";

/* check for posted variables. If we have some then we are is search
 * results mode. */
if (isset($_POST['search'])) {
	/* get the search string from the POST array */
	$search_string = $_POST['search'];
	if ($search_string != "") {
		/* change table title to search results only is search is not
		 * empty. If it is we will just do a normal address list. */
		$table_title = "Search Results:";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Simple Address Book</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.21" />
	<link rel="stylesheet" type="text/css" href="../css/web-examples.css">
</head>
<body>
	<h1>Simple Address Book Using SQL+PHP</h1>
	<!-- Add a link to a page that will allow creating new entries -->
	<a href="index.php">Home</a> | 	<a href="add-update-form.php">Add New Address</a>

	<p>This is a simple SQL driven address book using PHP to dynamically draw, add and update the content. It also will provide a simple search to demonstrate wild card searching.</p>

	<h2>Search:</h2>
	<!--
	In this example we is reduce the code by posting the search request
	back to the index page. When the index page loads it will check
	if there are any post variables set and if so the Address table
	will show the results of the search instead of the address list.
	-->
	<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<th>Enter Search String</th>
				<td><input type="text" name="search"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Search"></td>
			</tr>
		</table>
	</form>

	<h2><?php echo $table_title; ?></h2>
	<!-- We will use php to draw a table based on the records in our database -->
	<!-- The beauty of php is that it can be embedded inline with HTML -->
	<table>
	<?php
		/* Get records from database */
		$records = 0;
		if ($search_string) {
			$records = database_getSearchResults($search_string);
		}
		else {
			$records = database_getAddressBook();
		}
		$record_count = count($records);
		if ($record_count) {

			/* have at least one record. So lets draw the table headings */
			echo "<tr>";
			echo "<th>ID</th>";
			echo "<th>Name</th>";
			echo "<th>Phone Number</th>";
			echo "<th>email</th>";
			echo "<th>Address</th>";
			echo "<th></th>"; /* edit */
			echo "</tr>\n"; /* "\n" = new line in raw text. */

			/* now we loop printing out each record. */
			for ($loop=0; $loop<$record_count; $loop++) {
				echo "<tr>";
				echo "<td>".$records[$loop]['id']."</td>";
				echo "<td>".$records[$loop]['name']."</td>";
				echo "<td>".$records[$loop]['phone_number']."</td>";
				echo "<td>".$records[$loop]['email']."</td>";
				echo "<td>".str_replace("\n", ",", $records[$loop]['address'])."</td>"; /* we replace all new line characters with a comma */
				echo "<td><a href=\"add-update-form.php?id=".$records[$loop]['id']."\">Edit</a></td>";
				echo "</tr>\n";
			}
		}
		else {
			/* no rows were returned from query. Display message */
			echo "<tr><td>No Records found!</td></tr>";
		}
	?>
	</table>
<body>
</html>
