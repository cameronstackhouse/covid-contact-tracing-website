<?php  
	session_start();
	if(isset($_SESSION["user_id"]) && isset($_GET['index'])){
		$server = 'localhost:3306';
    	$user = 'contact_tracing_admin';
    	$password = 'pass';
    	$dbname = 'contact_tracing';
    	$user_id = $_SESSION["user_id"]; //Gets user ID
		$index = $_GET['index']; //Gets the index of the row the user clicked on to be removed
		$conn = mysqli_connect($server, $user, $password, $dbname); //Connects to database
		$visit_id; 
		$count = 1;
    	if(mysqli_connect_error()){
    		echo "Failed to connect to MySQl:" . mysqli_connect_error();
    		exit();
    	} else {
    		$sql = "SELECT id FROM visits WHERE user='$user_id'"; //Selects all visits by the user from the table
    		$result = mysqli_query($conn,$sql); //Executes querey 
    		while($row = $result->fetch_array(MYSQLI_ASSOC)){ //Iterates through the resulting table
    			if($index == $count){ //Checks if the index the user wants to remove is equal to the count
    				$visit_id = $row["id"]; //If so then set visit_id to the id of the visit
    			}
    			$count = $count + 1;
    		}
    		$delete_statement = "DELETE FROM visits WHERE id='$visit_id'"; //Statement to delete the row with the id from the table
    		$delete_result = mysqli_query($conn,$delete_statement); //Executes the statement
    		mysqli_close($conn);
    	}
	} else {
		echo "An Error has occurred.";
	}
?>