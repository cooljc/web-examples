<!--
   search.php
   
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
	/* get search string from POST */
	$search = '';
	if (isset($_POST['search']) && ($_POST['search'] != '') ) {
		$search = $_POST['search'];
	}
	else {
		/* no search string passed.. redirect back to index.php */
		header ("Location: index.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Search Results</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.21" />
	<link rel="stylesheet" type="text/css" href="../css/web-examples.css">
</head>

<body>
	<h1>Search Results</h1>
	<!-- Add a link to the home page -->
	<a href="index.php">Home</a>
	<p>This page is basically the same as the index page except the SQL uses wildcard searching to build the address list.</p>
	<h2>Results for: <?php echo $search;?></h2>
	<table>
	<?php
		/* we are not in php world. So if we use the "echo" function we can write data into
		 * the html document (server side) before it is sent to the clients browser. */
		 
		/* First up we need to open a connection to the database. In this example I will
		 * use MySQL and the php bindings that talk to it. */
		$link = mysql_connect("localhost", "examples", "p@ssw0rd");
		
		/* now we need to select the database we are going to perform our queries on */
		mysql_select_db("examples", $link);
		
		/* build SQL search string */
		$sql = "SELECT * FROM addresses WHERE ";
		$sql .= "name LIKE '%".$search."%' OR ";
		$sql .= "phone_number LIKE '%".$search."%' OR ";
		$sql .= "email LIKE '%".$search."%' OR ";
		$sql .= "address LIKE '%".$search."%'";
		
		$result = mysql_query($sql, $link);
		
		/* check the $result variable. if set then the query was successful */
		if ($result) {
			/* query was successful. Did we get any rows? */
			$row = mysql_fetch_object($result);
			if ($row) {
				/* have at least one row. So lets draw the table headings */
				echo "<tr>";
				echo "<th>ID</th>";
				echo "<th>Name</th>";
				echo "<th>Phone Number</th>";
				echo "<th>email</th>";
				echo "<th>Address</th>";
				echo "<th></th>"; /* edit */
				echo "</tr>\n"; /* "\n" = new line in raw text. */
				
				/* now we enter a while loop print out each record. until there are no more */
				do {
					echo "<tr>";
					echo "<td>".$row->id."</td>";
					echo "<td>".$row->name."</td>";
					echo "<td>".$row->phone_number."</td>";
					echo "<td>".$row->email."</td>";
					echo "<td>".str_replace("\n", ",", $row->address)."</td>"; /* we replace all new line characters with a comma */
					echo "<td><a href=\"edit-address.php?id=".$row->id."\">Edit</a></td>";
					echo "</tr>\n";
				} while ( $row = mysql_fetch_object($result));
			}
			else {
				/* no rows were returned from query. Display message */
				echo "<tr><td>No Records found!</td></tr>";
			}
			mysql_free_result($result);
		}
		else {
			/* query failed.. show some meaning full message */
			echo "<tr><td>Error querying database!!</td></tr>\n";
			/* get the last error from the database */
			$error = mysql_error($link);
			echo "<tr><td>".$error."</td></tr>\n";
		}
		
		/* its good practice to close you connect once your finished. 
		 * it save overhead on the server doing house keeping by removing
		 * stale connections when they have been idle for a long time.
		 * In a small scale projects its no big deal but if you are getting
		 * hundereds of connections a minute it can cause big problems and 
		 * might even take your server down if your not careful. */
		mysql_close($link);
	?>
	</table>
</body>

</html>
