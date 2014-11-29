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
			$passwordError = "Password should not be empty";
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
	<link rel="stylesheet" href="css/mainstyle.css" type = "text/css"/>
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
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" id="loginForm">
		<fieldset>	
			<legend>
				<img src="">
			</legend>
			<div id="usernameInput">
				<label for="username">Username</label>
				<input name="username" type="text" placeholder="Username" value="<?php echo $username ?>">
			</div>

			<div class="errorBox">
				<?php echo $usernameError ?>
			</div>

			<div id="passwordInput">
				<label for="password">Password:</label>
				<input name="password" type="password" placeholder="Password">
			</div>
			
			<div id="repasswordInput">
				<label for="repassword">Password again:</label>
				<input name="repassword" type="password" placeholder="Password again">
			</div>

			<div class="errorBox">
				<?php echo $passwordError ?>
			</div>

			<input type="submit" value="Create account">
		</fieldset>
		</form>
	</div>
	<div id="footer">
		<div class="wrap">
			<p>Footer</p>
		</div>
	</div>
</body>
</html>
