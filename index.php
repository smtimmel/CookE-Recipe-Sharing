<?php
require_once('./database.php');
require_once('./account_db.php');
require_once('./control_functions.php');

//Checks if user request valid
$action = perform_filter('action');

switch ($action) {
    case 'view':
		//Provides empty login form to user
		$active = array_fill(0, 2, '');
        include 'login_display.php';
        break;
    case 'login':
		//Checks user login credentials, determines if user can continue
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = sha1($username.filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

        // If valid username/password, login
        if (is_valid_account_login($username, $password)) {
			$action = 'view_my_recipes';
			$account = get_account($username);
			$_SESSION['accountID'] = $account['accountID'];
			$_SESSION['firstName'] = $account['firstName'];
			$_SESSION['admin'] = $account['admin'];
            include 'main_page.php';
        } else {
            $error_message = 'Login failed. Invalid username or password.';
			$active = array($username, '');
			include 'login_display.php';
        }
        break;
    default:
		$link = 'index.php';
		$content = 'ERROR';
        $mes = 'Invalid action request.';
		include 'message.php';
        break;
}
?>