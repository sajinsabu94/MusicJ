<?php
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('max_input_time', 30000);
ini_set('max_execution_time', 30000);

	 include('connection.php');
     session_start();
     $xuser = $_SESSION["xid"];
     $fileToUpload = basename($_FILES["file"]["name"]);
     $target_dir = "uploads/";
     $target_file = $target_dir . $fileToUpload;

     $salt = hash('sha512', mt_rand(0, PHP_INT_MAX));
     $target_file = hash('sha512', $salt);
   //  $fname =  $target_file;

     $target_file = $target_dir . $target_file;
   	 //die();


	 if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
	 {
	 	$key = ini_get("session.upload_progress.prefix") . $_POST[ini_get("session.upload_progress.name")];
	 	var_dump($_SESSION[$key]);

	 	SecureSqlMusic::query(
	 		"INSERT INTO `songs`(`singid`,`songname`,`songpath`) VALUES(?,?,?)",
	 		FALSE,
	 		"sss",
	 		$xuser, $fileToUpload, $target_file
	 	);

		return "success";
	 }
	 else
	 {
		//echo "<script type='text/javascript'>
		//        alert('hi');
		//  </script>";
		return "fail";
	 }
	
/*
     $target_dir = "./uploads/";
     $name = $_POST['name'];
     $target_file = $target_dir . basename($_FILES["file"]["name"]);
     move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
*/
?>