<?php
	require_once('DatabaseClass.php');
	require_once('SessionClass.php');
	require_once('functions.php');
	
	//$thesession = new Session();
	session_start();
	if (isLoggedIn()) {
		header("Location: index.php"); // Redirect browser to index.php
		exit();
	}

	$username = "";
	$password = "";

	$errorOccured  = false;
	$usernameError = "";
	$passwordError = "";
	$databaseError = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = testInput($_POST["username"]);
		$password = testInput($_POST["password"]);

		if (empty($username)) {
			$usernameError = "Username cannot be empty";
			$errorOccured = true;
		} else if (!preg_match("/^[a-zA-Z.]*$/", $username)) {
			$usernameError = "Only letters and dots are allowed";
			$errorOccured = true;
		}

		if (empty($password)) {
			$passwordError = "Password cannot be empty";
			$errorOccured = true;
		}

		if (!$errorOccured) {
			$database = new Database();
			if (!$database->isConnected()) {
				$errorOccured = true;
				$databaseError = "Could not connect to server. Please try again later.";
			} else {
				$database->query("SELECT id, password FROM user WHERE user.login = :username");
				$database->bind(":username", $username);
				$userInfo = $database->single();
				
				if ($database->rowCount() == 0) {
					$errorOccured = true;
					$usernameError = "Incorrect username or password.";
				} else {
					$correctPassword = $userInfo['password'];
					if (!password_verify($password, $correctPassword)) {
						$errorOccured = true;
						$usernameError = "Username or password is incorrect.";
					} else {
						$_SESSION['loggedin'] = $userInfo['id'];
						header("Location: index.php");
						exit();
					}
				}
			}
		}
	}
?>
<!DOCTYPE html>
<!-- Welcome page -->
<html>
<head>
<style>
#profile-img {
	width:97px; 
    height:97px;
    float: center;   
}

#legendText {
	text-align: center;
    font-size: 20px;
    color: yellow;
}

#loginBox {
    float: center; 
    width: 600px;
    margin: auto;
}

fieldset {
    border-color: #FFCC00;
}

.errorMessage {
    color: red;
}

form {
	float: center;
}
</style>

	<link rel="stylesheet" href="css/mainstyle.css" type="text/css">
	<title>Sign In</title>
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

			<div id="signInBox">
				<a href="createAccount.php" id="createAccountButton"> Create Account </a>
			</div>
				
		</div>
	</div>

<!-- End of head -->
	<div id="pageContent">

		<div id="loginBox">
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
				<fieldset>
					<legend>
						<div id="legendText">Sign in to continue to Universe Trade</div>
					</legend>
					<div id="prof-img">
						<img id="profile-img" src="images/profile.png" alt="profile">
					</div>

					<input type="text" name="username" placeholder="Username">
					<!-- For error msg-->
					<div class="errorMessage"><?php echo $usernameError; ?></div>
					<!-- later username can be changed to email address, with verification -->
					<input type="password" name="password" placeholder="Password">
					<!-- For error msg-->
					<div class="errorMessage"><?php echo $passwordError . "<br/>" . $databaseError; ?></div>
					<input type="submit" value="Sign in">
				</fieldset>
			</form>
			
			<a id="lnk-frgt-psswrd" href="helpPage.html">
			<span style = "color:#FFCC00; font-weight:bold; float:left">
			Need help?
			</span>
			</a>
		</div>
	</div>


	<div id="footer">
		<div class="wrap">
			<p><span style = "color:#000080; font-weight: bold">Authors:</span> Bekzhan Kassenov, Aigerim Bazarbayeva</p>
		</div>
	</div>
</body>
</html>
