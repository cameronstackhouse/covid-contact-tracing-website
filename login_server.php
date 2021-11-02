<?php
		session_start();
		$server = 'localhost:3306';
        $user = 'contact_tracing_admin';
        $dbpassword = 'pass';
        $dbname = 'contact_tracing';
        if(isset($_POST["username"]) && isset($_POST["password"])){
        	$conn = mysqli_connect($server, $user, $dbpassword, $dbname);
       		if(mysqli_connect_error()){
        		echo "Failed to connect to MySQl:" . mysqli_connect_error();
        		exit();
        	}
			$username = htmlentities($_POST["username"]);
			$entered_password = htmlentities($_POST["password"]);
			$sql = "SELECT id, password, name FROM users WHERE username= ?"; //Using a prepared statement to prevent SQL injection
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, $sql);
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);

			if(mysqli_stmt_num_rows($stmt) > 0){

				mysqli_stmt_bind_result($stmt, $userid ,$indexedpw, $name);
				while (mysqli_stmt_fetch($stmt)) 
				{
					if(password_verify($entered_password, $indexedpw)){ //Uses password verify to check if passwords match
						$login = TRUE; //If so then set login to true
						$_SESSION["user_id"] = $userid; //Set the session ID variable to the user ID
						$_SESSION["name"] = $name;
					}
				}
			}	

    		if($login == TRUE){
    			$_SESSION["username"] = $username;
    			$_SESSION["logged_in"] = TRUE;
            	mysqli_close($conn);
    			header("location: homepage.php"); //Sends the user to the homepage
    		} else {
    			echo "Error, invalid login details entered.";
    			mysqli_close($conn);
    			header("location: login.php"); //Else if invalid details are entered the user is returned to the login page
    		}
    	} else {
    		echo "Error! Enter username and password into login form.";
    	}
?>