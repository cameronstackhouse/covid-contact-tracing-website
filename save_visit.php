<?php  
	session_start();
	$server = 'localhost:3306';
    $user = 'contact_tracing_admin';
    $password = 'pass';
    $dbname = 'contact_tracing';
    $conn = mysqli_connect($server, $user, $password, $dbname);
    $date = htmlentities($_POST["date"]);
    $time = htmlentities($_POST["time"]);
    $duration = htmlentities($_POST["duration"]);
    $x = $_POST["x"];
    $y = $_POST["y"];
    $user_id = $_SESSION["user_id"];
    if(($x != '') && ($y != '') && isset($_POST["x"]) && isset($_POST["y"])){
        $sql = "INSERT INTO visits (user, date, X, Y, duration, time) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $user_id, $date, $x, $y, $duration, $time);

        if(mysqli_stmt_execute($stmt)){
            echo "New record created successfully.";
        } else {
            echo "Error has occoured";
        }
        
    } else {
    	echo "Error, invalid data. Ensure that all input boxes are filled in and a location has been selected from the map.";
    }

    mysqli_close($conn);
    header("location: addvisit.php");
?>