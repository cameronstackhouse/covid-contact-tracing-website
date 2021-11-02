<!DOCTYPE html>
<html>
<head>
	<title>Settings</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href = "navbar.css">
	<style type="text/css">
		.main{
			position: relative;
			height: 100vh;
			margin-left: 160px;
			margin-top: 0px;
			padding: 0px 10px;
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
		.main img[src="img/exeter.jpg"]{
			height: 50%;
			width: 50%;
			border: 5px solid black;	
		}
		.map {
			text-align: right;
		}
		.slidercontainer {
			width: 100%;
			text-align: center;
		}
		.slider{
			-webkit-appearance:none;
			width: 50%;
			height: 50px;
			opacity: 0.8;
			border: 1px;
		}
		.slider::-webkit-slider-thumb{
			-webkit-appearance: none;
 			appearance: none;
  			width: 50px;
  			height: 50px;
  			background: #4CAF50;
  			cursor: pointer;
		}
		.slider::-webkit-slider-runnable-track{
			border-radius: 3px;
			border-style: solid;
		}
		.main output{
			text-align: center;
		}
		input[type=submit], input[type=reset]{
			color: black;
			padding: 15px 32px;
			text-align: center;
			border: solid;
			justify-content: center;
			border-radius: 10px;
		}
		.main input[type="submit"]{
			float: left;
		}
		.main input[type="reset"]{
			float: right;
		}
		body{
			padding: 0;
			margin: 0;
			overflow: hidden;
		}
	</style>
	<script type="text/javascript">
		function resetVals(){
			window_output.innerHTML = 1;
			distance_output.innerHTML = 1;
		}
	</script>
</head>
<body>
	<?php
		session_start();
		if(!($_SESSION["logged_in"] == TRUE)){
			header('location: login.php');
		}  
	?>
	<div class="navbar">
		<a href="homepage.php">Home</a>
		<a href="overview.php">Overview</a>
		<a href="addvisit.php">Add Visit</a>
		<a href="report.php">Report</a>
		<a href="settings.php" class="selected">Settings</a>
		<a href="logout.php" class="logout">Logout</a>
	</div>

	<div class="heading">
		<h1>COVID-19 Contact Tracing</h1>
	</div>

	<div class="main">
		<img src="img/watermark.png" alt="Watermark">
		<h3>Alert Settings</h3>
		<hr>
		<p>Here you may change the alert distance and the time span for which the contact tracing will be performed.</p>
		<br>
		<form method="POST" action="save_settings.php">
			<div class = "slidercontainer">
			<p>window</p>
			<input type="range" min="1" max="4" class="slider" id="window" value="1" name="window">
			<p>Window Selected: <output id="window_output"></output>.</p>
		</div>
		<br>
		<div class = "slidercontainer">
			<p>distance</p>
			<input type="range" min="1" max="500" class="slider" id="distance" value="1" name="distance">
			<p>Distance Selected: <output id = "distance_output"></output>.</p>
			<br>
			<input type="submit" name="Confirm" value="Confirm">
			<input type="reset" name="Cancel" value="Cancel" onclick="resetVals()">
		</div>
		</form>
	</div>
	<script type="text/javascript">
		var window_slider = document.getElementById("window");
		var distance_slider = document.getElementById("distance");

		var window_output = document.getElementById("window_output");
		var distance_output = document.getElementById("distance_output");

		window_slider.value = <?php echo $_COOKIE["window"];?>;
		distance_slider.value = <?php echo $_COOKIE["distance"];?>;

		window_output.innerHTML = <?php echo $_COOKIE["window"];?>;
		distance_output.innerHTML = <?php echo $_COOKIE["distance"];?>;

		window_slider.addEventListener('input', function() {
			window_output.innerHTML = window_slider.value;
		});

		distance_slider.addEventListener('input', function() {
			distance_output.innerHTML = distance_slider.value;
		});
	</script>
</body>
</html>