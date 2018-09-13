<?php
//Provides methods for dealing with accounts database table, uses general db_functions method templates
require_once('./db_functions.php');

//Function checks if the entered username and password are valid
function is_valid_account_login($username, $password) {
    $query = '
        SELECT * FROM accounts
        WHERE username = :username AND password = :password';
	$bindStr = array(':username', ':password');
	$bindVar = array($username, $password);
    return check_if_rows($query, $bindStr, $bindVar);
}

//Checks if any accounts are in the database
function check_if_first() {
	$query = '
		SELECT * FROM accounts';
	$bind = array();
	return !check_if_rows($query, $bind, $bind);
}

//Retrieves all accounts from database
function get_all_accounts() {
	$query = '
		SELECT * FROM accounts
		ORDER BY admin';
	$bind = array();
	return complete_fetch($query, $bind, $bind);
}

//Retrieves an account with the given user name
function get_account($username) {
    $query = '
        SELECT accountID, firstName, admin FROM accounts
        WHERE username = :username';
	$bindStr = array(':username');
	$bindVar = array($username);
    return single_fetch($query, $bindStr, $bindVar);
}

//Gets all accounts that are either admin or not admin (dependent on user input)
function get_accounts_by_admin($admin) {
	$query = '
        SELECT * FROM accounts
        WHERE admin = :admin';
	$bindStr = array(':admin');
	$bindVar = array($admin);
	return complete_fetch($query, $bindStr, $bindVar);
}

//Creates an account with given credentials
function create_account($username, $password, $first, $last, $email, $admin) {
	//first checks if username provided is unique
	$query = '
		SELECT * FROM accounts
		WHERE username = :username';
	$bindStr = array(':username');
	$bindVar = array($username);
    if (check_if_rows($query, $bindStr, $bindVar)) {
        return false;
    }
    $query = 'INSERT INTO accounts
                 (username, password,
                  firstName, lastName, email, admin)
              VALUES
                 (:username, :password,
                  :first, :last, :email, :admin)';
	$bindStr = array(':username', ':password', ':first', ':last', ':email', ':admin');
	$bindVar = array($username, $password, $first, $last, $email, $admin);
	$link = 'index.php';
	no_fetch($query, $bindStr, $bindVar, $link);
    return true;
}

//Gets an account username from the acount id
function get_username($accountID) {
    $query = '
        SELECT username FROM accounts
        WHERE accountID = :accountID';
	$bindStr = array(':accountID');
	$bindVar = array($accountID);
	return single_fetch($query, $bindStr, $bindVar);
}

//Deletes an account with the given account id
function delete_account($accountID) {
	$query = '
		DELETE FROM accounts
		WHERE accountID = :accountID';
	$bindStr = array(':accountID');
	$bindVar = array($accountID);
	$link = 'admin_account_manager.php';
	no_fetch($query, $bindStr, $bindVar, $link);
}

//Makes an account an admin account
function make_admin($accountID) {
	$query = 'UPDATE accounts SET
		admin = "y" 
		WHERE accountID = :accountID';
	$bindStr = array(':accountID');
	$bindVar = array($accountID);
	$link = 'main_page.php';
    no_fetch($query, $bindStr, $bindVar, $link);
}
?>