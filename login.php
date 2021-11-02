<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<style type="text/css">
		.heading
		{
			background-color: rgb(173,185,202);
			padding: 15px 15px 15px 15px;
		}
		.heading h1
		{
			font-family: Arial;
			size: 40px;
			font-weight: bold;
			text-align: center;
		}
		.input_form
		{
			position: absolute;
			text-align: center;
			margin: auto auto;
			display: block;
			top: 40%;
			left: 42%;
		}
		.input_form input[type=text], input[type=password]
		{
			width: auto;
			padding: 12px 60px;
			margin: 8px 0;
			box-sizing: border-box;
			text-align: center;
		}
		.input_form input[class=button]
		{
			width: auto;
			padding: 15px 47px;
			font-size: 12px;
			margin-top: 5px;
			display: inline-block;
			border-radius: 10px;
		}
		.input_form img[src="img/watermark.png"]{
			position: absolute;
			top: 50%;
			left: 50%;
			z-index: -1;
			opacity: 0.5;
			width: 800px;
			height: auto;
			margin-top: -300px;
			margin-left: -400px;
		}
		.input_form form{
			text-align: center;
		}
		.register_button
		{
			width: auto;
			padding: 15px 110px;
			font-size: 12px;
			margin-top: 10px;
			display: inline-block;
			border-radius: 10px;
		}
		a
		{
			color: black;
			text-decoration: none;
		}
	</style>

	<?php 
		session_start();
		//Checks if the user is logged in already, if they are then take them to the homepage
		if($_SESSION["logged_in"] == TRUE){
			header("location: homepage.php");
		}
	?>
</head>
<body>
	<div class="heading">
		<h1>COVID-19 Contact Tracing</h1>
	</div>
		
	<div class="input_form">
		<img src="img/watermark.png" alt="Watermark">
		<form action= "login_server.php" method="POST">
			<input type="text" name="username" placeholder="Username" required><br>
			<input type="password" name="password" placeholder="Password" required><br>
			<input type="submit" name="login" class="button">
			<input type="reset" name="cancel" class="button">
		</form>
		<input type="button" value="Register" onclick="location.href='registration.html'" class="register_button">
	</div>
</body>
</html>