<!DOCTYPE html>
<html>
<head>
	<title>Add Visit</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="navbar.css">
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
			border: 5px solid black;
			float: right;
			cursor: pointer;
		}
		.main input[type=submit], input[type=reset]{
			padding: 15px 47px;
			font-size: 12px;
			margin-top: 5px;
			display: inline-block;
			border-radius: 10px;
		}
		.main input[type=date], input[type=time], input[type=number]{
			width: 70%;
			padding: 12px 60px;
			margin: 8px 0;
			box-sizing: border-box;
			text-align: center;
		}
		.form_wrapper{
			width: 600px;
			float: left;
			text-align: center;
		}
		.image{
			width: 800px;
			float: right;
			position: relative;
		}
		form{
			text-align: center;
		}
		body{	
			padding: 0;
			margin: 0;
			overflow: hidden;
		}
	</style>
	<?php  
		session_start();
		if(!($_SESSION["logged_in"] == TRUE)){ //Checks if user is logged in
			header("location: login.php");
		}
	?>
</head>
<body>
	<div class="navbar">
		<a href="homepage.php">Home</a>
		<a href="overview.php">Overview</a>
		<a href="addvisit.php" class="selected">Add Visit</a>
		<a href="report.php">Report</a>
		<a href="settings.php">Settings</a>
		<a href="logout.php" class="logout">Logout</a>
	</div>

	<div class="heading">
		<h1>COVID-19 Contact Tracing</h1>
	</div>

	<div class="main">
		<img src="img/watermark.png" alt="Watermark">
		<h3>Add a new Visit</h3>
		<hr>
		<div class="form_wrapper">
			<form method="POST" action="save_visit.php">
				<h4>Date:</h4>
				<input type="date" placeholder="Date" name="date" required>
				<h4>Time:</h4>
				<input type="time" placeholder="Time" name="time" required>
				<input type="number" step="1" placeholder="Duration" name="duration" required>
				<input type="hidden" name="x" id="x" required>
				<input type="hidden" name="y" id="y" required>
				<br>
				<input type="submit" placeholder="Add">
				<input type="reset" placeholder="Cancel" onclick="clearMarker()">
			</form>
		</div>
		<div class="image" id="pointer_div">
			<img src="img/exeter.jpg" name="exeter_image" align="right" onclick="setCoords(event)" alt="Map of Exeter">
		</div>
		<img src="img/marker_black.png" id="marker" width="40px" height="40px" style="display: none; position: absolute">
	</div>
<script type="text/javascript">
	function setCoords(event){
		var x = event.offsetX ? (event.offsetX) : event.pageX - document.getElementById("pointer_div").offsetLeft; //Gets x coordinate taking into account the position of the image on the screen
		var y = event.offsetY ? (event.offsetY) : event.pageY - document.getElementById("pointer_div").offsetTop; //Gets y coordinate taking into account the position of the image on the screen
		document.getElementById("x").setAttribute("value", x);
		document.getElementById("y").setAttribute("value", y);
		console.log("X: " + x + " Y: " + y);
		with(document.getElementById("marker")){ //Sets the position of the marker to place it on the map
			style.left = event.clientX - 180 + "px";
			style.top = event.clientY - 85+ "px";
			style.display = "block";
		}
	}

	function clearMarker(){
		//Function to clear the hidden input forms and to remove the marker from the map
		with(document.getElementById("marker")){
			style.left = 0 + "px";
			style.top = 0 + "px";
			style.display = "none";
		}
		document.getElementById("x").setAttribute("value", '');
		document.getElementById("y").setAttribute("value", '');
	}
</script>	
</body>
</html>