<?php
include('connection.php');
session_start();
$userid = $_SESSION['xid'];
//$userid = '1';
if(isset($_POST['singid']))
	$userid = $_POST['singid'];

$list = SecureSqlMusic::query(
	"SELECT songname,songpath FROM `songs` WHERE singid = ?",
	TRUE,
	"s",
	$userid
);
header('Content-Type: application/json');
echo json_encode($list);

?>