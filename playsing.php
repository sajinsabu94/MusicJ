<?php
include('connection.php');
$list = SecureSqlMusic::query(
	"SELECT DISTINCT(`singid`) FROM `songs`",
	TRUE
);
header('Content-Type: application/json');
echo json_encode($list);

?>