<?php 
        $server = 'localhost:3306';
        $user = 'contact_tracing_admin';
        $password = 'pass';
        $dbname = 'contact_tracing';
        $conn = mysqli_connect($server, $user, $password, $dbname);
        if(mysqli_connect_error()){
            echo "Failed to connect to MySQl:" . mysqli_connect_error();
            exit();
        }
        $name = htmlentities($_POST["firstname"]);
        $surname = htmlentities($_POST["surname"]);
        $user_password = htmlentities($_POST["password"]);
        $username = htmlentities($_POST["username"]);
        $hashedpw = password_hash($user_password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (name, surname, username, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $surname, $username, $hashedpw);

        $sql_userexists = "SELECT id FROM users WHERE username= ?";
        $userexists_stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($userexists_stmt, $sql_userexists);
        mysqli_stmt_bind_param($userexists_stmt, "s", $username);
        mysqli_stmt_execute($userexists_stmt);
        mysqli_stmt_store_result($userexists_stmt);
    
        if(mysqli_stmt_num_rows($userexists_stmt) > 0){
        	echo "Error, user with given username already exists in database";
        } else {
        	if(mysqli_stmt_execute($stmt)){
        		echo "New record created successfully.";
       		} else {
        		echo "Error!";
                echo mysqli_stmt_error($stmt);
            }
        }
        mysqli_close($conn);
        header('Location: login.php');
 ?>

