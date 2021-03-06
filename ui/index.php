<?php
	require_once('DatabaseClass.php');
	require_once('SessionClass.php');
	require_once('functions.php');
	
	//$thesession = new Session();
	session_start();
	//print_r($_SESSION);
?>
<!DOCTYPE html>
<!-- Welcome page -->
<html>
<head>
<style>
	#imageBox {
		padding: 15px;
	}
</style>
	<link rel="stylesheet" href="css/mainstyle.css" type="text/css">
	<title>UniverseTrade</title>
</head>

<body>	
	<div id="header">
		<div class="wrap">
			<div id="logo">
				<a href="index.php"><img src="images/logoFar.png" alt="logoFar"></a>
			</div>

			<div id = "usermenu">
				<ul>
					
					<a href="index.php"><li>Home</li></a>	
					<a href="starsStore.php"><li>Stars store</li></a>
					<a href="planetsStore.php"><li>Planets store</li></a>
					<a href="profile.php"><li>Profile</li></a>	
					<a href="aboutPage.php"><li>About</li></a>	
				</ul>	
			</div>

			<?php	if (!isLoggedIn()) {
						echo displaySignInBox();
					} else {
						echo displayLogoutBox();
					}
					?>
				
		</div>
	</div>

<div id = "pageContent">
	<div id="imageBox"> <img src="images/Index-bg.jpg" width="90%"/></div>
</div>

	<div id="footer">
		<div class="wrap">
				<p><span style = "color:#000080; font-weight: bold">Authors:</span> Bekzhan Kassenov, Aigerim Bazarbayeva</p>
		</div>
	</div>
</body>
</html>