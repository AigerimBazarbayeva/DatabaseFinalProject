<?php
require_once 'DatabaseClass.php';
require_once 'SessionClass.php';
require_once 'functions.php';

//$thesession = new Session();
session_start();

if (isLoggedIn()) {
    session_destroy();
}

header("Location: index.php"); /* Redirect browser */
exit();
?>