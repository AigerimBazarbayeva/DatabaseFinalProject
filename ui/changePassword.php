<?php
	require_once('functions.php');
	require_once('DatabaseClass.php');
	require_once('SessionClass.php');

	session_start();
	if (!isLoggedIn()) {
		header("Location: index.php");
		exit();
	}

	function checkPassword($userID, $password) {
		$database = new Database();
		if (!$database->isConnected()) {
			return false;
		}

		$database->query("SELECT password FROM user WHERE user.ID = :userID");
		$database->bind(":userID", $userID);
		$queryResult = $database->single();

		if ($database->rowCount() == 0)
			return false;

		$correctPassword = $queryResult['password'];

		return password_verify($password, $correctPassword);
	}

	$passwordOld = "";
	$passwordNew = "";
	$passwordNewVerify = "";
	$userID = $_SESSION['loggedin'];

	$errorOccured  = false;
	$passwordError = "";
	$databaseError = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$passwordOld       = testInput($_POST["opass"]);
		$passwordNew       = testInput($_POST["npass"]);
		$passwordNewVerify = testInput($_POST["vpass"]);

		if (empty($passwordNewVerify)) {
			$passwordError = "Passwords don't match";
			$errorOccured = true;
		}

		if (empty($passwordNew)) {
			$passwordError = "Password cannot be empty";
			$errorOccured = true;
		}

		if ($passwordNew !== $passwordNewVerify) {
			$passwordError = "Passwords don't match";
			$errorOccured = true;
		}

		if (!$errorOccured) {
			try {	
				if (!checkPassword($userID, $passwordOld)) {
					$passwordError = "This is not your password!";
					$errorOccured = true;
				} else {
					$database = new Database();
					if (!$database->isConnected()) {
						$errorOccured = true;
						$databaseError = "Could not connect to server. Please try again later.";
					} else {		
						$password = password_hash($passwordNew, PASSWORD_DEFAULT);
						$database->query("UPDATE user SET password=:password WHERE ID = :userID");
						$database->bind(":userID", $userID);
						$database->bind(":password", $password);
						$database->execute();
						session_destroy();
						header("Location: signIn.php");
						exit();
					} 
				}
			} catch (PDOException $e) {
				$errorOccured = true;
				$databaseError = "Some problems occured on server. Please try again later.";
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

#changePasswordBox {
    float: center;
    width: 400px;
    margin: auto;
    padding-bottom: 10px;
    padding-top: 10px;
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

.labelBox {
	color: #ffff00;
}
</style>

	<link rel="stylesheet" href="css/mainstyle.css" type="text/css">
	<title>Change password</title>
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

			<?php echo displayLogoutBox() ?>	
		</div>
	</div>

<!-- End of head -->
	<div id="pageContent">

		<div id="changePasswordBox">
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
				<fieldset>
					<legend>
						<div id="legendText">Change your password</div>
					</legend>
				
					<div class="labelBox">
						<label for="opass"> Old password </label>
					</div>
					<input type="password" name="opass" placeholder="Old password">
					
					<div class="labelBox">
						<label for="npass"> New password </label>
					</div>
					<input type="password" name="npass" placeholder="New password">
					
					<div class="labelBox">
						<label for="vpass"> Verify new password </label>
					</div>
					<input type="password" name="vpass" placeholder="Password again">
					
					<div class="errorMessage"><?php echo $passwordError .  $databaseError; ?></div>
					
					<input type="submit" value="Change password">
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
