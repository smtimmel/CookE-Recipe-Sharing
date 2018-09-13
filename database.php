<?php
	//IMPORTANT: DATABASE NAME: cs602termproject
    $dsn = 'mysql:host=localhost;dbname=cs602termproject';
    $username = 'cs602_user';
    $password = 'cs602_secret';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
		$link = 'index.php';
		$content = 'ERROR';
        $mes = $e->getMessage();
        include 'message.php';
        exit();
    }
?>