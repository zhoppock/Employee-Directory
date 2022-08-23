<?php
	session_start();
	
	if (!isset($_SESSION['account-connected'])) 
		header("Location: http://localhost:1234/webpages/pechanga_directory_administrative_login.php");
	else if(isset($_SESSION['account-connected'])!="") 
		header("Location: http://localhost:1234/webpages/pechanga_directory_administrative_search.php?");
	
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION);
		header("Location: http://localhost:1234/pechanga_directory_main_page.html");
		exit;
	}
?>