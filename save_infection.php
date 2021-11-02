<?php  
	session_start();
	$server = 'localhost:3306';
    $user = 'contact_tracing_admin';
    $password = 'pass';
    $dbname = 'contact_tracing';
    $conn = mysqli_connect($server, $user, $password, $dbname);
    if(mysqli_connect_error()){
            echo "Failed to connect to MySQl:" . mysqli_connect_error();
            exit();
    }
    if(isset($_POST["date"]) && isset($_POST["time"]) && isset($_SESSION["user_id"])){
    	$user_id = $_SESSION["user_id"];
    	$date = htmlentities($_POST["date"]);
    	$time = htmlentities($_POST["time"]);
    	$sql = "INSERT INTO infections (user, date, time) VALUES (?, ?, ?)";
    	$stmt = mysqli_stmt_init($conn);
    	mysqli_stmt_prepare($stmt, $sql);
    	mysqli_stmt_bind_param($stmt, "sss", $user_id, $date, $time);
    
    	if(mysqli_stmt_execute($stmt)){
        	echo "New infection added successfully.";
        	$sql_visits = "SELECT X, Y, date, time, duration FROM visits WHERE id=".$user_id;
        	$all_visits = mysqli_query($conn, $sql_visits);

        	while($row = $all_visits-> fetch_array(MYSQLI_ASSOC)){
        		$handle = curl_init();
       			curl_setopt($handle, CURLOPT_URL, "http://ml-lab-7b3a1aae-e63e-46ec-90c4-4e430b434198.ukwest.cloudapp.azure.com:60999/report");
       			curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
       			$jsoninfection = array("x" => $row["X"], "y" => $row["Y"], "date" => "{$row["date"]}", "time" => "{$row["time"]}", "duration" => "{$row["duration"]}");
       			curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($jsoninfection));
       			curl_exec($handle);
       		}
    	} else {
        	echo "An error has occoured.";
    	}
	} else {
		echo "An error has occoured.";
	}
	mysqli_close($conn);
    header("location: report.php");
?>