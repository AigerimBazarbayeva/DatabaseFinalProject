<?php
	require_once('functions.php');
	require_once('DatabaseClass.php');
	require_once('SessionClass.php');

	$session = new Session();

	if (isLoggedIn()) {
		header("Location: index.php"); // Redirect browser to index.php
		exit();
	}

	$db = new Database();

	$username = "";
	$password = "";

	$errorOccured  = false;
	$usernameError = "";
	$passwordError = "";
	$databaseError = "";
	$userNotFoundError = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = testInput($_POST["username"]);
		$password = testInput($_POST["password"]);

		if (empty($username)) {
			$usernameError = "Username should be empty";
			$errorOccured = true;
		} else if (!preg_match("/^[a-zA-Z.]*$/", $username)) {
			$usernameError = "Only letters and dots are allowed";
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
				$database->query("SELECT id, password FROM user WHERE user.login = :username");
				$database->bind(":username", $username);
				$userInfo = $database->single();
				
				if ($database->rowCount() == 0) {
					$errorOccured = true;
					$userNotFoundError = "Incorrect username or password.";
				} else {
					$correctPassword = $userInfo['password'];
					if (!password_verify($password, $correctPassword)) {
						$errorOccured = true;
						$userNotFoundError = "Username or password is incorrect.";
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
	<link rel="stylesheet" href="css/mainstyle.css" type = "text/css"/>
	<title> Sign In </title>
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
	<div id="logformbox" style="background-color:white;">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" id="loginForm">
			<div id="usernameInput">
				<label for="username">Username</label>
				<input name="username" type="text" placeholder="Username" value="<?php echo $username ?>">
			</div>

			<div id="passwordInput">
				<label for="password">Password:</label>
				<input name="password" type="password" placeholder="Password">
			</div>
			
			<div class="errorBox">
				<?php echo $passwordError ?>
			</div>

			<input id="logbutton" name="logInButton" type="submit" value="Sign In">
		</form>
	</div>

	<div id="footer">
		<div class="wrap">
			<p>Footer</p>
		</div>
	</div>
</body>

</html>
