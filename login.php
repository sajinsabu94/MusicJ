<?php

$user = $_POST['inputEmail'];
$pass = $_POST['inputPass'];

include('connection.php');

$rest = SecureSqlMusic::query(
"SELECT * FROM `users` WHERE email = ? AND pass = ?",
TRUE,
"ss",
$user, $pass
);

$id 	=  $rest[0][0] . ' ';
$name 	=  $rest[0][1] . ' ';
$email 	=  $rest[0][2] . ' ';
$type 	=  $rest[0][3] . ' ';


session_start();
$_SESSION["xid"] 	= $id;
$_SESSION["xuser"] 	= $name;
$_SESSION["xtype"] 	= $type;
if($type == 1)
{
	echo "<script type='text/javascript'>
		        location.href='singer.html';
		  </script>";

	die();
}
if($type == 2)
{
	echo "<script type='text/javascript'>
		        location.href='mdirector.html';
		  </script>";
	die();
}

?>