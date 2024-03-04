<?php
session_start();

$_SESSION = array();

session_destroy();

// Redirect to the login page or any other desired page after logout
header("Location: auth-sign-in.php");
exit();
?>
