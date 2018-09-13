<?php
	$link = 'index.php';
	$content = 'Logout';
    $mes = 'Logout successful!';
	session_start();
	//Ends session
	unset($_SESSION);
	session_destroy();
    include 'message.php';
?>