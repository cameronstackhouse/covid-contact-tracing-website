<!DOCTYPE html>
<html>
<head>
	<title>Overview</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="navbar.css">
	<style type="text/css">
		.main{
			position: relative;
			height: 100vh;
			margin-left: 160px;
			margin-top: 0px;
			padding: 0px 10px;
		}
		table{
			position: relative;
			top: 150px;
			margin-left: auto;
			margin-right: auto;
			width: 70%;
		}
		tr, th{
			font-size: 20px;
			text-align: center;
		}
		th{
			font-family: Arial;
		}
		tr{
			font-family: "Times New Roman";
		}
		img[src='img/cross.png']{
			cursor: pointer;
		}
		body{
			padding: 0;
			margin: 0;
			overflow: hidden;
		}	
	</style>
</head>
<body>
	<div class="navbar">
		<a href="homepage.php">Home</a>
		<a href="overview.php" class="selected">Overview</a>
		<a href="addvisit.php">Add Visit</a>
		<a href="report.php">Report</a>
		<a href="settings.php">Settings</a>
		<a href="logout.php" class="logout">Logout</a>
	</div>

	<div class="heading">
		<h1>COVID-19 Contact Tracing</h1>
	</div>

	<div class="main">
		<img src="img/watermark.png" alt="Watermark">
		<table id="overviewTable">
			<tr>
				<th>Date</th>
				<th>Time</th>
				<th>Duration</th>
				<th>X</th>
				<th>Y</th>
				<th></th>
			</tr>
			<?php
				session_start();
				if($_SESSION["logged_in"] == TRUE){
					$server = 'localhost:3306';
        			$user = 'contact_tracing_admin';
        			$password = 'pass';
        			$dbname = 'contact_tracing';
        			$user_id = $_SESSION["user_id"];
        			$conn = mysqli_connect($server, $user, $password, $dbname);
        			if(mysqli_connect_error()){
        				echo "Failed to connect to MySQl:" . mysqli_connect_error();
        				exit();
        			}	
     				//Selects and displays all visits by a user in the table
					$sql = "SELECT date, time, duration, X, Y FROM visits WHERE user='$user_id'";
					$result = mysqli_query($conn,$sql);
					while($row = $result->fetch_array(MYSQLI_ASSOC)){
						echo "<tr><td>".$row["date"]."</td><td>".$row["time"]."</td><td>".$row["duration"]."</td><td>".$row["X"]."</td><td>".$row["Y"]."</td><td><img src= 'img/cross.png' width= '20px' onclick='removeRow(this)' alt='Cross'></td></tr>";
					}
				} else {
					mysqli_close($conn);
					header("location: logout.php"); //If the user is not logged in then send them back to the login page
				}
				mysqli_close($conn); 
			?>
		</table>
	</div>
	<script type="text/javascript">
		function removeRow(element){
			var xmlhttp = new XMLHttpRequest();
			var index = element.parentNode.parentNode.rowIndex; //Gets index of the row of the button click
			xmlhttp.onreadystatechange = function (){
				if(this.readyState == 4 && this.status == 200){
					document.getElementById("overviewTable").deleteRow(index);
				}
			};
			xmlhttp.open("GET", "delete_row.php?index=" + index, true); //AJAX request, sends index chosen to the delete_row.php file
			xmlhttp.send(); //Sends the request
		}
	</script>
</body>
</html>