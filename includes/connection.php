<?php
    	////////////////// CREATING OFFLINE DATABASE CONNECTION ////////////////////////////////////////
		$dbName	=	"registration_project";
		$conn	=	mysql_connect("localhost","root","") or die("Error in connection");
		mysql_select_db($dbName) or die("db not connected");
?>