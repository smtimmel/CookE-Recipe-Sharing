<?php
require_once('./database.php');
require_once('./account_db.php');
require_once('./control_functions.php');
$link = 'index.php';

//Checks if valid request
$action = perform_filter('action');

switch ($action) {
    case 'view':
		//Shows an empty account form
		$active = array_fill(0, 5, '');
        include 'add_account_display.php';
        break;
    case 'add':
		//Receive inputs
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
		$first = filter_input(INPUT_POST, 'first', FILTER_SANITIZE_STRING);
		$last = filter_input(INPUT_POST, 'last', FILTER_SANITIZE_STRING);
		$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
		if (check_if_first()) {
			$admin = 'y';
		} else {
			$admin = 'n';
		}
		//Encrypt password
		$password = sha1($username.$pass);
		$active = array($username, '', $first, $last, $email);

        // Check if inputs valid
        if ($username === NULL || $username === '') {
            $error_message = 'Need to enter a username.';
			include 'add_account_display.php';
        } elseif ($password === NULL || $pass === '') {
            $error_message = 'Need to enter a password.';
			include 'add_account_display.php';
        } elseif ($first === NULL || $first === '') {
			$error_message = 'Need to enter a first name.';
			include 'add_account_display.php';
		} elseif ($last === NULL || $last === '') {
			$error_message = 'Need to enter a last name.';
			include 'add_account_display.php';
		} elseif ($email === NULL || $email === '') {
			$error_message = 'Need to enter an email.';
			include 'add_account_display.php';
		} elseif ($email === false) {
			$error_message = 'Need to enter a valid email.';
			include 'add_account_display.php';
			//Create the account while simultaneously checking if username is unique
		} elseif (!create_account($username, $password, $first, $last, $email, $admin)) {
			$error_message = 'Sorry username already taken.';
			include 'add_account_display.php';
		} else {
			$content = 'SUCCESS';
			$mes = 'Account creation successful!';
			include 'message.php';
		}
        break;
    default:
		$content = 'ERROR';
        $mes = 'Invalid action request.';
		include 'message.php';
        break;
}
?>