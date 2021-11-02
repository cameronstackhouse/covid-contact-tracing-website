<?php  
	session_start();
	if(isset($_POST["window"]) && isset($_POST["distance"])){
		setcookie("window", $_POST["window"], time() + 2592000, "/");
		setcookie("distance", $_POST["distance"], time() + 2592000, "/");
		header("location: settings.php");
	} else {
		echo "Error! Enter settings using the settings form.";
	}
?>