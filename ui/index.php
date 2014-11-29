<?php
	require_once('DatabaseClass.php');
	require_once('SessionClass.php');
	require_once('functions.php');
	$session = new Session();
?>
<!DOCTYPE html>
<!-- Welcome page -->
<html>
<head>
	<link rel="stylesheet" href="css/mainstyle.css" type="text/css">
	<title>UniverseTrade</title>
</head>

<body>	
	<div id="header">
		<div class="wrap">
			<div class="logo">
				<a href="index.php"><img src="images/logo.png"></a>
			</div>

			<div id = "usermenu">
				<ul id ="menubar1" class="menuHorizontal">
					<li>
						<a class="subMenu" href="#">Home</a>	
					</li>
					<li>
						<a class="subMenu" href="#">Store
							<ul>
								<li><a href="smth1.php">Stars</a></li>
								<li><a href="smth2.php">Planets</a></li>
							</ul>
						</a>		
					</li>
					<li>
						<a class="subMenu" href="profile.php">Profile</a>	
					</li>
					<li>
						<a class="subMenu" href="#">Encyclopedia</a>	
					</li>
					<li>
						<a class="subMenu" href="#">About</a>	
					</li>
				</ul>	
			</div>	
		</div>
	</div>

<div id = "pageContent">
	<p>Welcome to Universe trade</p>
</div>

	<div id="footer">
		<div class="wrap">
			<p>Footer</p>
		</div>
	</div>
</body>
</html>