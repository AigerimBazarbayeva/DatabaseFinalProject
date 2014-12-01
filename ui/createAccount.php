<?php
	require_once('functions.php');
	require_once('DatabaseClass.php');
	require_once('SessionClass.php');

	$username = "";
	$password = "";
	$passwordVerify = "";

	$errorOccured  = false;
	$usernameError = "";
	$passwordError = "";
	$databaseError = "";
	$usernameIsBisyError = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = testInput($_POST["username"]);
		$password = testInput($_POST["password"]);
		$passwordVerify = testInput($_POST["repassword"]);

		if (empty($username)) {
			$usernameError = "Username cannot be empty";
			$errorOccured = true;
		} else if (!preg_match("/^[a-zA-Z.]*$/", $username)) {
			$usernameError = "Only letters and dots are allowed";
			$errorOccured = true;
		}

		if (empty($passwordVerify)) {
			$passwordError = "Passwords do not match";
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

				try {
					$database->query("SELECT login FROM user WHERE user.login = :username");
					$database->bind(":username", $username);
					$database->execute();
					if ($database->rowCount() != 0) {
						$errorOccured = true;
						$usernameIsBisyError = "User with such login already exists";
					}
				} catch (PDOEXception $e) {
					$errorOccured = true;
					$databaseError = "Could not create new user. Please try again later.";
				}

				if (!$errorOccured) {
					try {
						$password = password_hash($password, PASSWORD_DEFAULT);
						$database->query("INSERT INTO user (login, password) VALUES (:username, :password)");
						$database->bind(":username", $username);
						$database->bind(":password", $password);
						$database->execute();
						header("Location: signIn.php");
						exit();
					} catch (PDOException $e) {
						$errorOccured = true;
						$databaseError = "Could not create new user. Please try again later.";
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

#legendText {
	text-align: center;
    font-size: 20px;
    color: yellow;
}

#createAccountBox {
    float: right; 
    width: 600px;
    margin-top: 20px;
    margin-bottom: 20px;
}

fieldset {
    border-color: #FFCC00;
}

.errorMessage {
    color: red;
}

form {
	float: right;
}

.labelBox {
	color: #ffff00;
}
</style>

	<link rel="stylesheet" href="css/mainstyle.css" type="text/css">
	<title>Create Account</title>
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
				<a href="signIn.php" id="signInButton"> Sign in </a>
			</div>
				
		</div>
	</div>

<!-- End of head -->
	<div id="pageContent">

		<div id="createAccountBox">
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
				<fieldset>
					<legend>
						<div id="legendText">Create account in Universe Trade</div>
					</legend>
				
					<div class="labelBox">
						<label for="username"> Username </label>
					</div>
					<input type="text" name="username" placeholder="Username">
					<!-- For error msg-->
					<div class="errorMessage"><?php echo $usernameError; ?></div>
					<!-- later username can be changed to email address, with verification -->
					
					<div class="labelBox">
						<label for="password"> Password </label>
					</div>
					<input type="password" name="password" placeholder="Password">
					<!-- For error msg-->
					<div class="labelBox">
						<label for="repassword"> Password again </label>
					</div>
					<input type="password" name="repassword" placeholder="Password again">
					<div class="errorMessage"><?php echo $passwordError .  $databaseError; ?></div>
					<input type="submit" value="Create Account">
				</fieldset>
			</form>
		</div>
	</div>


	<div id="footer">
		<div class="wrap">
			<p><span style = "color:#000080; font-weight: bold">Authors:</span> Bekzhan Kassenov, Aigerim Bazarbayeva</p>
		</div>
	</div>
</body>
</html>
