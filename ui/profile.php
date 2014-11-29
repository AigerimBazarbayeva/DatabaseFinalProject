<?php
	require_once('functions.php');
	require_once('DatabaseClass.php');
	require_once('SessionClass.php');

	$session = new Session();
	if (!isLoggedIn()) {
		header("Location: signIn.php");
		exit();
	}

	function updateValue($array, $value) {
		if (!isset($array[$value]) || empty($array[$value]) || is_null($array[$value]))
			$array[$value] = "Not filled";

		return $array[$value];
	}

	function displayUserInfo() {
		$userID = $_SESSION["loggedin"];
		$database = new Database();

		if (!$database->isConnected()) {
			echo "Error occured during connecting to server. Please reload the page."
			die();
		}

		$result = false;
		try {
			$database->query("SELECT * FROM user WHERE user.id = :id");
			$database->bind(":id", $userID);
			$result = $database->single();
		} catch (PDOException $e) {
			echo "Error occured during connecting to server. Please reload the page."
			die();
		}

		$firstName    = updateValue($result, 'fname');
		$lastName     = updateValue($result, 'lname');
		$placeOfBirth = updateValue($result, 'placeOfBirth');
		$gender       = updateValue($result, 'gender');
	}
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
						<a class="subMenu" href="#">Profile</a>	
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