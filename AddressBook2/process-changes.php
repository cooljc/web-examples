<?php
/*
 * Filename: process-changes.php
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

/* include our common functions file. */
require_once 'common.inc.php';

/* define an array to store posted form variables */
$data = array ('name' => '', 
			   'phone_number' => '', 
			   'email' => '',
			   'address' => '',
			   'record_id' => 0);

/* get record_id */
if (isset($_POST['record_id'])) {
	$data['record_id'] = $_POST['record_id'];
	
	/* get form data from POST array */
	if (isset($_POST['name'])) {
		$data['name'] = $_POST['name'];
	}
	
	if (isset($_POST['phone_number'])) {
		$data['phone_number'] = $_POST['phone_number'];
	}
	
	if (isset($_POST['email'])) {
		$data['email'] = $_POST['email'];
	}
	
	if (isset($_POST['address'])) {
		$data['address'] = $_POST['address'];
	}
		
	/* add/update record */
	database_addUpdateRecord($data);
}

/* redirect to index page */
header("Location: index.php");

?>
