<?php
function testInput($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}

function isLoggedIn() {
	return isset($_SESSION['loggedin']);
}

?>