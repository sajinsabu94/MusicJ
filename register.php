<?php

include('connection.php');

$name = $_POST['nameField'];
$email = $_POST['emailField'];
$type = $_POST['typeField'];
$pass = $_POST['passField'];

SecureSqlMusic::query(
	'INSERT INTO `users`(`name`, `email`, `type`, `pass`) VALUES(?,?,?,?)',
	FALSE,
	'ssss',
	$name, $email, $type, $pass
);
echo '<script> 
location.href ="login.html";
</scrit>'
?>