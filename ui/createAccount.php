<?php
	require_once 'functions.php';
	require_once 'DatabaseClass.php';
?>
<!DOCTYPE html>
<!-- Welcome page -->
<html>
<head>
	<link rel="stylesheet" href="mainstyle.css" type = "text/css"/>
	<title>Create Account</title>
</head>

<body>
	<div id="header">
		<div class="wrap">
			<div class="logo">
				<a href="index.php"><img src="images/logo.png"></a>
			</div>

			<div id = "usermenu">
				<ul>
					<a href="index.php"> <li> Home </li> </a> 
					<li>
					Store
						<ul>
						<a href="star.php">
							<li>Stars</li>
						</a>
						<a href="planet.php">
							<li>Planets</li>
						</a>
						</ul>
					</li>
					
					<a href="profile.php"><li> Profile </li> </a>
					<a href="encyclopedia.php"> <li> Encyclopedia </li> </a> 
					<a href="about.php"> <li> About </li> </a> 
				</ul>
			</div>	
		</div>
	</div>
<div id="pageContent">
	<form action="createAccount" name="post">
		<p> Name 
			<input type="text" name="firstName">
			<input type="text" name="lastName">
		</p>

	</form>
</div>
	<div id="footer">
		<div class="wrap">
			<p>Footer</p>
		</div>
	</div>
</body>

</html>
