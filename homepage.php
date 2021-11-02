<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href = "navbar.css">
	<style type="text/css">
		.main{
			position: relative;
			height: 100vh;
			margin-left: 160px;
			margin-top: 0px;
			padding: 0px 10px;
			width: 1600px;
			overflow: hidden;
		}

		.main h3{
			text-align: center;
			font-size: 40px;
		}

		.main p{
			font-family: "Times New Roman";
			font-size: 20px;			
			text-align: left;
		}
		.main img[src="img/exeter.jpg"]{
			display: inline-block;
			width: 800px;
			float: right;			
			border: 5px solid black;
		}
		.map {
			width: 800px;
			position: absolute;
			top: 30;
			right: 0;
		}
		.welcome_text{
			width: 600px;
			float: left;
			text-align: center;
		}
		.empty{
			float: right;
			width: 800px;
		}
		body{
			padding: 0;
			margin: 0;
			overflow: hidden;
		}
	</style>
	<script type="text/javascript">
		function displayInfo(x, y, date, user){
			parsed_date = new Date(Date.parse(date));
			alert("Details about infection: \nCoordinates: (x: " + x + ", y: " + y + ") \nUser ID: " + user);
		}
	</script>
	<?php  
		session_start();
		if(!($_SESSION["logged_in"]) == TRUE){
			header("location:login.php");
		}
	?>
</head>
<body>
	<div class="navbar">
		<a href="homepage.php" class="selected">Home</a>
		<a href="overview.php">Overview</a>
		<a href="addvisit.php">Add Visit</a>
		<a href="report.php">Report</a>
		<a href="settings.php">Settings</a>
		<a href="logout.php" class="logout">Logout</a>
	</div>

	<div class="heading">
		<h1>COVID-19 Contact Tracing</h1>
	</div>

	<div class="main" id="main">
		<img src="img/watermark.png" alt="Watermark">
		<h3>Status</h3>
		<hr>
		<div class="welcome_text">
			<?php
				session_start();
				if(isset($_COOKIE["window"]) && isset($_COOKIE["distance"])){
					$time = $_COOKIE["window"];
					$distance = $_COOKIE["distance"];
				} else {
					$time = 1;
					$distance = 20;
				}
				$uid = $_SESSION["user_id"];
				$server = 'localhost:3306';
       			$user = 'contact_tracing_admin';
        		$password = 'pass';
        		$dbname = 'contact_tracing';
        		$conn = mysqli_connect($server, $user, $password, $dbname);
        		if(mysqli_connect_error()){
        			echo "Failed to connect to MySQL database: " .mysqli_connect_error();
        			exit();
        		}
        		//No prepared statement needed as the variables time, uid and distance are all set through means in which it is impossible to enter any text.
				$sql_contacts = "SELECT users.id, infections.date FROM users INNER JOIN infections ON users.id = infections.user INNER JOIN visits ON users.id = visits.user WHERE visits.date BETWEEN DATE_SUB(CURDATE(), INTERVAL ".$time." DAY) AND CURDATE()AND EXISTS(SELECT * FROM visits V WHERE V.user = ".$uid." AND SQRT (POWER(V.X - visits.X, 2) + POWER(V.Y - visits.Y, 2)) < ".$distance." AND (visits.date BETWEEN V.date AND DATE_ADD(V.date, INTERVAL V.duration MINUTE) OR (V.date BETWEEN visits.date AND DATE_ADD(visits.date, INTERVAL visits.duration MINUTE))))";
				$result = mysqli_query($conn, $sql_contacts);
				if(mysqli_num_rows($result) > 0){
					$display_message = ", you might have had a connection to an infected person at the location shown in red.</p>";
				} else {
					$display_message = ", you have had no connections to an infected person.</p>";
				}


				$name = $_SESSION["name"];

				mysqli_close($conn);

				echo "<p>Hi " . $name . $display_message;
			?>
			<p class="bottom_text">Click underneath a marker to see details about an infection.</p>
		</div>
		<div class="empty"></div>
		<div class="map" id="map">
			<?php 
			$server = 'localhost:3306';
       		$user = 'contact_tracing_admin';
        	$password = 'pass';
        	$dbname = 'contact_tracing';
        	$conn = mysqli_connect($server, $user, $password, $dbname);
			$sql_all_infections = "SELECT visits.X, visits.Y, visits.time, visits.date FROM visits INNER JOIN infections ON visits.user = infections.user WHERE visits.date BETWEEN DATE_SUB(CURDATE(), INTERVAL ".$time." DAY) AND CURDATE()";
			$all_infections = mysqli_query($conn, $sql_all_infections);
			while($row = $all_infections-> fetch_array(MYSQLI_ASSOC)){
				$x = $row["X"];
				$y = $row["Y"];
				echo '<script language="javascript">';
				echo "var marker = document.createElement('img');";
				echo "marker.setAttribute('src', 'img/marker_black.png');";
				echo "marker.setAttribute('alt', 'black marker');";
				echo "marker.setAttribute('width', '30px');";
				echo "marker.setAttribute('height', '30px');";
				echo 'marker.style.position= "absolute";';
				echo 'marker.style.display= "block";';
				echo 'marker.style.left= '.$x.' + 795 + "px";';
				echo 'marker.style.top= '.$y.' + 100 + "px";';
				echo "document.getElementById('main').appendChild(marker);";
				echo "</script>";
			}
			
			$sql_contacts = "SELECT users.id, infections.date, visits.X, visits.Y FROM users INNER JOIN infections ON users.id = infections.user INNER JOIN visits ON users.id = visits.user WHERE visits.date BETWEEN DATE_SUB(CURDATE(), INTERVAL ".$time." DAY) AND CURDATE()AND EXISTS(SELECT * FROM visits V WHERE V.user = ".$uid." AND SQRT (POWER(V.X - visits.X, 2) + POWER(V.Y - visits.Y, 2)) < ".$distance." AND (visits.date BETWEEN V.date AND DATE_ADD(V.date, INTERVAL V.duration MINUTE) OR (V.date BETWEEN visits.date AND DATE_ADD(visits.date, INTERVAL visits.duration MINUTE))))";
						
			$contacts_result = mysqli_query($conn, $sql_contacts);
			while($row = $contacts_result -> fetch_array(MYSQLI_ASSOC)){
				$x = $row["X"];
				$y = $row["Y"];
				echo '<script language="javascript">';
				echo "var marker = document.createElement('img');";
				echo "marker.setAttribute('src', 'img/marker_red.png');";
				echo "marker.setAttribute('alt', 'red marker');";
				echo "marker.setAttribute('width', '30px');";
				echo "marker.setAttribute('height', '30px');";
				echo 'marker.style.position= "absolute";';
				echo 'marker.style.display= "block";';
				echo 'marker.style.left= '.$x.' + 795 + "px";';
				echo 'marker.style.top= '.$y.' + 100 + "px";';
				echo "document.getElementById('main').appendChild(marker);";
				echo "</script>";
			}
			?>
			<img src="img/exeter.jpg" usemap="#exeter_map" alt="Map of Exeter">
			<map name="exeter_map">
				<?php
					session_start();
					if($_SESSION["logged_in"] == TRUE){
						$uid = $_SESSION["user_id"];
						$server = 'localhost:3306';
       					$user = 'contact_tracing_admin';
        				$password = 'pass';
        				$dbname = 'contact_tracing';
        				$conn = mysqli_connect($server, $user, $password, $dbname);
        				if(mysqli_connect_error()){
        					echo "Failed to connect to MySQL database: " .mysqli_connect_error();
        					exit();
        				}
		
						$sql_all_infections = "SELECT visits.X, visits.Y, visits.time, visits.date, visits.user FROM visits INNER JOIN infections ON visits.user = infections.user WHERE visits.date BETWEEN DATE_SUB(CURDATE(), INTERVAL ".$time." DAY) AND CURDATE()";

						$all_infections = mysqli_query($conn, $sql_all_infections);

						while($row = $all_infections-> fetch_array(MYSQLI_ASSOC)){
							$x = $row["X"];
							$y = $row["Y"];
							$visit_date = $row["date"];
							$visit_user_id = $row["user"];
							echo "<area shape='circle' coords='".$x.",".$y.",20' href='javascript:displayInfo({$x}, {$y}, {$visit_date}, {$visit_user_id})'>";
						}

						if($handle = curl_init() === false){
							echo "Curl-Error: " . curl_error($handle);
						} else {
							curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($handle, CURLOPT_FAILONERROR, true);
						}

						$url = "http://ml-lab-7b3a1aae-e63e-46ec-90c4-4e430b434198.ukwest.cloudapp.azure.com:60999/infections?ts={$time}";

						curl_setopt($handle, CURLOPT_URL, $url);
						curl_setopt($handle, CURLOPT_HTTPGET, true);
						curl_setopt($handle, CURLOPT_HTTPHEADER, false);
						if(($output = curl_exec($handle))!==false){
							$infections_ws = json_decode($output, true);
						}

						curl_close($handle);
					} else {
						header("location: logout.php");
					}
				?>
			</map>
		</div>

	</div>
</body>
</html>