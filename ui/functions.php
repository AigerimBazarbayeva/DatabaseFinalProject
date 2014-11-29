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

?>