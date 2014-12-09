<?php
	require_once('functions.php');
	require_once('DatabaseClass.php');

	session_start();
	if (!isLoggedIn()) {
		header("Location: signIn.php");
		exit();
	}
	
	$userID = $_SESSION['loggedin'];

	$firstName = "";        // For updating first name
	$lastName = "";         // For updating last name 
	$birthPlace = "";       // For updatng birth place ( = some string)
	$gender = "";           // For updating gender ( = {"Male", "Female"})

	$errorOccured  = false;
	$databaseError = "";
	
	function updateValue(&$array, $value) {
		if (!isset($array[$value]) || empty($array[$value]) || is_null($array[$value])) {
			$array[$value] = "";
		}

		return $array[$value];
	}

	function getQueryValue($value) {
		if (!isset($value) || empty($value) || is_null($value)) {
			return "NULL";
		}

		return $value;
	}
	
	$database = new Database();
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$firstName  = testInput($_POST['fname']);
		$lastName   = testInput($_POST['lname']);
		$birthPlace = testInput($_POST['birthPlace']);
		$gender     = testInput($_POST['gender']);

		$database->query("UPDATE user SET FName = :firstName, LName = :lastName, placeOfBirth = :birthPlace, gender = :gender WHERE user.ID = :userID");
		$database->bind(":firstName",  getQueryValue($firstName));
		$database->bind(":lastName",   getQueryValue($lastName));
		$database->bind(":birthPlace", getQueryValue($birthPlace));
		$database->bind(":gender",     getQueryValue($gender));
		$database->bind(":userID",     $userID);
		$database->execute();
	} else {
		$database->query("SELECT * FROM user WHERE user.ID = :userID");
		$database->bind(':userID', $userID);
		$queryResult = $database->single();
		
		$firstName  = updateValue($queryResult, 'fname');
		$lastName   = updateValue($queryResult, 'lname');
		$birthPlace = updateValue($queryResult, 'placeOfBirth');
		$gender     = updateValue($queryResult, 'gender');
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

			<?php echo displayLogoutBox(); ?>
			
		</div>
	</div>

	<div id = "pageContent">
		<div id = "prifleUpdateBox">
			<form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> method="post">
				<div>
					<label for="fname"> First name: </label>
					<input type="text" name="fname" placeholder="First name" value=<?php echo $firstName; ?> >
				</div>

				<div>
					<label for="lname"> Last name: </label>
					<input type="text" name="lname" placeholder="Last name" value=<?php echo $lastName; ?> >
				</div>

				<div>
					<label for="birthPlace"> Place of birth: </label>
					<input type="text" name="birthPlace" placeholder="Place of birth" value=<?php echo $birthPlace; ?> >
				</div>

				<div>
					<input type="radio" name="gender" value="Male" <?php if ($gender==="Male") echo " checked" ?> > Male
					<input type="radio" name="gender" value="Female" <?php if ($gender==="Female") echo " checked" ?> > Female
				</div>

				<input type="submit" value="Update profile"/>
			</form>

			<form action = "changePassword.php">
			<input type="submit" value="Change my password">
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