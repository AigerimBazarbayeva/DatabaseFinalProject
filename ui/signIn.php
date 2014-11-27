<?php
	require_once('functions.php');
	require_once('DatabaseClass.php');

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
			$usernameError = "Username cannot be empty";
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
			if (!$database->connected) {
				$errorOccured = true;
				$databaseError = "Could not connect to server. Please try again later.";
			} else {
				$database->query("SELECT id, password FROM user WHERE user.login = :username");
				$databse->bind(":username", $username);
				$userInfo = $database->single();
				
				if ($database->rowCount == 0) {
					$errorOccured = true;
					$userNotFoundError = "Username or password is incorrect.";
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
	<link rel="stylesheet" href="mainstyle.css" type = "text/css"/>
	<title> Sign in </title>
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
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" name="logform" id="logform">
			<div id="usernameInput">
				<label for="username">Username</label>
				<input id="username"
					   name="username"
					   type="text"
					   maxlength="255"
					   placeholder="Username"
					   value="<?php echo $username ?>">
			</div>
			<div id="usernameError" style="color: red;">
				<?php echo $usernameError?>
			</div>

			<div id="passwordInput">
				<label for="password">Password:</label>
				<input id="password"
					   name="password"
					   type="password"
					   maxlength="255"
					   class="theusernameput"
					   placeholder="Password">
			</div>
			<div id="usernameError" style="color: red;">
				<?php echo $passwordError?>
			</div>

			<input id="logbutton" name="logInButton" type="submit" value="Log in">
		</form>
	</div>

	<div id="footer">
		<div class="wrap">
			<p>Footer</p>
		</div>
	</div>
</body>

</html>
