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

	$userID = $_SESSION['loggedin'];

	function updateValue(&$array, $value) {
		if (!isset($array[$value]) || empty($array[$value]) || is_null($array[$value]))
			$array[$value] = "Not filled";

		return $array[$value];
	}

	function displayUserInfo() {
		$userID = $_SESSION['loggedin'];
		$database = new Database();

		if (!$database->isConnected()) {
			echo "Error occured during connecting to server. Please reload the page.";
			die();
		}

		$queryResult = false;
		try {
			$database->query("SELECT * FROM user WHERE user.id = :id");
			$database->bind(":id", $userID);
			$queryResult = $database->single();
		} catch (PDOException $e) {
			echo "Error occured during connecting to server. Please reload the page.";
			die();
		}

		$firstName    = updateValue($queryResult, 'fname');
		$lastName     = updateValue($queryResult, 'lname');
		$placeOfBirth = updateValue($queryResult, 'placeOfBirth');
		$gender       = updateValue($queryResult, 'gender');

		$result = "<div id=\"profileBox\">";
		$result .= "<table>";
		$result .= "<tr> <td style=\"width: 150px; color: yellow;\"> First name:     </td> <td>" . $queryResult['fname'] .         "</td> </tr>";
		$result .= "<tr> <td style=\"width: 150px; color: yellow;\"> Last name:      </td> <td>" . $queryResult['lname'] .         "</td> </tr>";
		$result .= "<tr> <td style=\"width: 150px; color: yellow;\"> Place of birth: </td> <td>" . $queryResult['placeOfBirth'] .  "</td> </tr>";
		$result .= "<tr> <td style=\"width: 150px; color: yellow;\"> Gender:         </td> <td>" . $queryResult['gender'] .        "</td> </tr>";
		$result .= "</table>";
		$result .= "</div>";

		return $result;
	}

	if ($_SERVER['REQUEST_METHOD'] === "GET") {
		if (isset($_GET['delete'])) {
			$database = new Database();
			$database->query("DELETE FROM user WHERE user.ID = :userID");
			$database->bind(":userID", $userID);
			$database->execute();
			header("Location: logout.php");
			exit();
		}
	}
?>
<!DOCTYPE html>
<!-- Welcome page -->
<html>
<head>
<style>
	#profileBox {
		text-align: left;
		float: center;
		margin: auto;
		width: 400px;
		color: white;
		padding: 15px;
	}
</style>	
	<link rel="stylesheet" href="css/mainstyle.css" type="text/css">
	<title>Profile</title>
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
	<?php echo displayUserInfo(); ?>
	<div>
		<form action="updateProfile.php">
			<input type="submit" value="Update my profile">
		</form>
	</div>

	<div>
		<form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?> method="get">
			<input type="hidden" name="delete" value="true">
			<input type="submit" value="Delete my profile">
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