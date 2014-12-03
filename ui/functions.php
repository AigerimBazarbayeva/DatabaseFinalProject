<?php
function testInput($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}

function isLoggedIn() {
	if (isset($_SESSION['loggedin'])) {
		return true;
	}

	return false;
}

function displaySignInBox() 
	$result = "<div id=\"signInBox\">";
	$result .= "<a href=\"signIn.php\" id=\"signInButton\"> Sign in </a>";
	$result .= "<a href=\"createAccount.php\" id=\"createAccountButton\"> Create Account </a>";
	$result .= "</div>";

	return $result;
}

function displayLogoutBox() {
	$result = "<div id=\"signInBox\">";
	
	try {
		$database = new Database();
		$database->query("SELECT login FROM user WHERE user.id = :id");
		$database->bind(":id", $_SESSION['loggedin']);
		$queryResult = $database->single();
		$result .= "<span style=\"padding: 5px;\"> Hello, " . $queryResult['login'] . "</span>";
	} catch (PDOException $e) {
		$result = $e->getMessage();
		return $result;
	}

	
	$result .= "<a href=\"logout.php\" id=\"signInButton\"> Logout </a>";
	$result .= "</div>";
	return $result;
}