<!DOCTYPE html>
<html>
<head>
	<title>Report</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="navbar.css">
	<style type="text/css">
		.main{
			position: relative;
			height: 100vh;
			margin-left: 160px;
			margin-top: 0px;
			padding: 0px 10px;
			overflow: hidden;
		}

		.main h3{
			text-align: center;
			font-size: 40px;
		}

		.main p{
			font-family: "Times New Roman";
			font-size: 20px;			
			text-align: center;
		}
		.input_form{
			text-align: center;
			padding: 170px 0;
		}
		.input_form input[type=date], input[type=time]{
			width: 35%;
			padding: 12px 60px;
			margin: 8px 0;
			box-sizing: border-box;
			text-align: center;
		}
		.input_form input[type=submit], input[type=reset]{
			color: black;
			padding: 15px 32px;
			text-align: center;
			border: solid;
			justify-content: center;
		}
		.input_form input[type=submit]{
			float: left;
			border-radius: 10px;
		}
		.input_form input[type=reset]{
			float: right;
			border-radius: 10px;
		}
		body{
			padding: 0;
			margin: 0;
			overflow: hidden;
		}
	</style>
	<?php
		session_start();
		if(!($_SESSION["logged_in"] == TRUE)){
			header("location: login.php");
		}

	?>
</head>
<body>
	<div class="navbar">
		<a href="homepage.php">Home</a>
		<a href="overview.php">Overview</a>
		<a href="addvisit.php">Add Visit</a>
		<a href="report.php" class="selected">Report</a>
		<a href="settings.php">Settings</a>
		<a href="logout.php" class="logout">Logout</a>
	</div>

	<div class="heading">
		<h1>COVID-19 Contact Tracing</h1>
	</div>

	<div class="main">
		<img src="img/watermark.png" alt="Watermark">
		<h3>Report an Infection</h3>
		<hr>
		<p>Please report the date and time when you were tested positive for COVID-19</p>
		<div class="input_form">
			<form method="POST" action="save_infection.php">
				<input type="date" name="date" placeholder="Date" required><br>
				<input type="time" name="time" placeholder="Time" required><br>
				<input type="submit" name="report" value="Report">
				<input type="reset" name="cancel" value="Cancel">
			</form>
		</div>
	</div>
	<script type="text/javascript">
		
	</script>
</body>
</html>