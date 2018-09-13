<?php
if (!isset($_SESSION)) {
	session_start();
}

//provides REST API services, accessed through get requests
require_once('./database.php');
require_once('./search_db.php');
require_once('./account_db.php');

$content = 'ERROR';

//Only accessible to admin accounts
if (isset($_SESSION['admin']) && $_SESSION['admin'] === 'y') {
	//filter user format and action requests
	$format = filter_input(INPUT_GET, 'format');
	$action = filter_input(INPUT_GET, 'action');


	if ($action === "searches") {
		$result = get_search();
	} elseif ($action === "accounts") {
		//Gets admin request for type of accounts to recieve data for
		$admin = filter_input(INPUT_GET, 'admin');
		$result = get_accounts_by_admin($admin);
	}

	//if a valid action request was given
	if (!empty($result)) {
	
		if ($format === "xml") {
			//new xml document generated
			$doc = new DOMDocument('1.0','UTF-8');
			$doc->perserveWhiteSpace = false;
			$doc->formatOutput = true;
			//root of document set
			$root = $doc->createElement($action);
			$doc->appendChild($root);
			//child of root equivalent to name of root but is singular
			$node = rtrim($action, 'es');
			foreach($result as $type) {
				//a child created for each query result
				$parent = $doc->createElement($node);
				$root->appendChild($parent);
				foreach($type as $key => $value) {
					//the attributes of each query results are added to the XML file
					$child = $doc->createElement($key, $value);
					$parent->appendChild($child);
				}
			}
			//the XML is output to the user
			echo '<pre>'.htmlspecialchars($doc->saveXML($root)).'</pre>';
		} elseif ($format === "json") {
			//json format data is output to the user
			echo '<pre>'.json_encode($result, JSON_PRETTY_PRINT).'</pre>';
		} else {
			$mes = "Invalid format input. Check all fields and try again.";
			$link = 'main_page.php';
			include('message.php');
		}
	} else {
		//error if invalid action type utilized
		$mes = "Invalid action input or no results available. Check all fields and try again.";
		$link = 'main_page.php';
		include('message.php');
	}
} else {
	$mes = 'Must be admin account to access REST API.';
	$link = 'index.php';
	include 'message.php';
}
?>