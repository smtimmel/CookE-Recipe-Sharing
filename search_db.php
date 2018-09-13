<?php
//Provides functions for accessing search database
require_once('./db_functions.php');

//Increments the amount of times a search has been performed
function add_search($category, $input) {
    $query = '
        SELECT * FROM search 
        WHERE category = :category
		AND input = :input';
    $bindStr = array(':category', ':input');
	$bindVar = array($category, $input);
    if (check_if_rows($query, $bindStr, $bindVar)) {
		$query = '
			UPDATE search SET
			searchAmt = searchAmt + 1 
			WHERE category = :category
			AND input = :input';
	} else {
		$query = 'INSERT INTO search
			(searchAmt, category, input)
			VALUES
			(1, :category, :input)';
	}
	$link = 'main_page.php';
	no_fetch($query, $bindStr, $bindVar, $link);
}

//Retrieves all search records, sorted by search amount
function get_search() {
	$query = '
        SELECT * FROM search 
        ORDER BY searchAmt DESC';
	$bind = array();
	return complete_fetch($query, $bind, $bind);
}