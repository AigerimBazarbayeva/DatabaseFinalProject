<?php
	require_once('functions.php');
	require_once('DatabaseClass.php');
	require_once('SessionClass.php');

	//$thesession = new Session();
	session_start();
	//print_r($_SESSION);
	if (!isLoggedIn()) {
		header("Location: signIn.php");
		exit();
	}
?>

<!DOCTYPE html>
<!-- Welcome page -->
<html>
<head>
<style>
	#textBox {
		text-align: left;
		padding-top: 15px;
		margin: auto;
		width: 500px;
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

			<?php
				if (!isLoggedIn()) {
					echo displaySignInBox();
				} else {
					echo displayLogoutBox();
				}
			?>
			
		</div>
	</div>

<div id = "pageContent">
	<div id="textBox"> 
	<span style="font-weight: bold;"> About UT</span>
	<br/><br/>
	The Universe trade (UT) was founded in 2014. Its mission is promote commercial trading website platform that allows user to buy and sale astronomical object through international cooperation. The key activity of UT is organization of sale/buy instances between users without traditional buying/selling model.
	<br/><br/>
	
	The authors of project created only imaginary web-site that not reqiured to exist in reality. Any matches or coincides with real object or user names are incidental and random. Authors do not have any responsibilities for content of the site.
	</p>
	</div>
</div>

	<div id="footer">
		<div class="wrap">
				<p><span style = "color:#000080; font-weight: bold">Authors:</span> Bekzhan Kassenov, Aigerim Bazarbayeva</p>
		</div>
	</div>
</body>
</html>
