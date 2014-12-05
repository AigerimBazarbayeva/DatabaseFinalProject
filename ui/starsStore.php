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

	function displayStarList() {
		$database = null;
		$result = "";
		try {
			$database = new Database();
			$database->query("SELECT * FROM star JOIN spaceObject ON star.OName = spaceObject.name");
			$queryResult = $database->getResult();

			$result .= "<table>";
			foreach ($queryResult as $star) {
				$result .= "<tr>";
				$result .= "<td>" . $star['OName'] . "</td>";
				$result .= "</tr>";
			}
			$result .= "</table>";
		} catch (PDOException $e) {
			die();
		}

		return $result;
	}

	function displayStarInfo($starName) {
		$database = null;
		$result = "";

		try {
			$database = new Database();
			$database->query("SELECT * FROM star JOIN spaceObject ON star.OName = spaceObject.name JOIN user ON user.ID = star.ownerID WHERE spaceObject.name=:OName");
			$database->bind(":OName", $starName);
			$queryResult = $database->single();

			if ($database->rowCount() == 0) {
				$result = "Invalid starName";
				return $result;
			}

			$result .= "<table>";
			$result .= "<tr><td>Name</td><td>" . $queryResult['name'] . "</td></tr>";
			
		} catch (PDOException $e) {
			die();
		}

		return $result;
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
		<?php
			if (!isset($_GET['starName'])) {
				echo displayStarList();
			} else {
				echo displayStarInfo($_GET['starName']);
			}
		?>
	</div>

	<div id="footer">
		<div class="wrap">
			<p><span style = "color:#000080; font-weight: bold">Authors:</span> Bekzhan Kassenov, Aigerim Bazarbayeva</p>
		</div>
	</div>
</body>
</html>