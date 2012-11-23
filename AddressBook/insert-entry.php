<?php
	/* this document is pure php and is not intented to be used to 
	 * display and data in the clients browser. It will execute server
	 * side and then redirect to the original index page. */
	
	/* first we will define some variables for our data setting them all empty */
	$name = '';
	$phone_number = '';
	$email = '';
	$address = '';
	
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
	
	/* ok all data has been collected. before we do the insert a little 
	 * on the $_POST[] variable.
	 * The $_POST[] variable is a built in server array. The array elements
	 * are build from serialized data sent from HTTP POSTS (in our case HTML <form>). 
	 * The element name is referenced to the name of the <input> field in the <form>.
	 * Read more here: http://php.net/manual/en/reserved.variables.post.php 
	 * Now on with the INSERT.... */
	
	/* like the index page we need to create a connection to the database */
	$link = mysql_connect("localhost", "examples", "p@ssw0rd");
	
	/* select our database */
	mysql_select_db("examples", $link);
	
	/* build INSERT SQL statement */	
	$sql = "INSERT INTO addresses (name, phone_number, email, address, date_created) ";
	$sql .= "VALUES('".$name."', '".$phone_number."', '".$email."', '".$address."', UNIX_TIMESTAMP())";
	
	/* a little note on the 2 lines above.
	 * 
	 * First the use of the period (.) is a way (in PHP) to append to a 
	 * string variable. It allows you to break down the string over a number 
	 * of lines and even customize it based on other variables and 
	 * if(), else if() statements.
	 * 
	 * Second you will notice the use of the apostrophe ('). This is 
	 * required in SQL to encapsulate a string within a string. Because
	 * SQL is essentially a string based language the server needs to know
	 * what are commands and what is data. So the apostrophe (') is used.
	 * Things get more dificult if your data string also has an apostrophe
	 * as part of its structure. For that you need to escape it with another
	 * special character. Cross that bridge when it comes...
	 * 
	 * Thirdly "UNIX_TIMESTAMP()" is a built in funtion of the SQL server.
	 * When it encounters this the server inserts the current time in seconds
	 * from 01/01/1970: See http://www.unixtimestamp.com/index.php for more.
	 * Basically is the best way to store date/time as it is a number and 
	 * can always be translated back to a printable time/date. Typical use
	 * case would be in searching data between 2 dates. Numbers are quicker 
	 * it search than strings (server point of view). */
	
	/* now on with the INSERT. For this we simply just use mysql_query() */
	$result = mysql_query($sql, $link);
	
	/* we can check $result to find out if the insert was successful */
	if ($result == FALSE) {
		/* INSERT failed.. do something.. In this situation you could
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
