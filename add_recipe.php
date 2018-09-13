<?php if (!isset($_SESSION)) {
	session_start();
}
//Checks if user logged in
if (!empty($_SESSION)) { 
require_once('./database.php');
require_once('./meal_db.php');
require_once('./component_db.php');
require_once('./step_db.php');
require_once('./account_db.php');
require_once('./control_functions.php');
$link = 'main_page.php';

//Validates user request
$action = perform_filter('action');

switch ($action) {
    case 'view':
		//Sets up parameters for empty form before displaying it
		$components = array(
			'Quantities' => array_fill(0, 5, ''),
			'Measurements' => array_fill(0, 5, ''),
			'Ingredients' => array_fill(0, 5, '')
		);
		$steps = array_fill(0, 5, '');
		$name = '';
        include 'add_recipe_display.php';
        break;
    case 'add':
		//Prepares for any task received from add recipe form
        $task = filter_input(INPUT_POST, 'task');
		$numSteps = filter_input(INPUT_POST, 'numSteps', FILTER_VALIDATE_INT);
		$numComponents = filter_input(INPUT_POST, 'numComponents', FILTER_VALIDATE_INT);
		$keys = array('Quantities', 'Measurements', 'Ingredients');
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
		switch ($task) {
			//Responsible for creating the recipe
			case 'Add Recipe':
				$valid = true;
				//Validates steps provided
				for ($i = 0; $i < $numSteps; $i++) {
					$steps[$i] = filter_input(INPUT_POST, 'step'.$i, FILTER_SANITIZE_STRING);
					if ($steps[$i] === NULL || $steps[$i] === '') {
						$error_message = 'Please enter all steps';
						$valid = false;
					}
				}
				//validates components (quantities, Ingredients, measurements) provided
				foreach ($keys as $key) {
					for ($i = 0; $i < $numComponents; $i++) {
						$items[$i] = filter_input(INPUT_POST, $key.$i, FILTER_SANITIZE_STRING);
						if ($key === 'Quantities') {
							if ($items[$i] === NULL || $items[$i] === false || !is_numeric($items[$i])) {
								$error_message = 'Please enter valid quantities';
								$valid = false;
							}
						} else {
							if ($items[$i] === NULL || $items[$i] === '') {
								$error_message = 'Please enter all ingredients and measurements';
								$valid = false;
							}
						}
					}
					$components[$key] = $items;
				}

				//Validates name provided
				if ($name === NULL || $name === '') {
					$error_message = 'Recipe name input needed';
					$valid = false;
				}

				//Creation fails if invalid
				if ($valid === false) {
					include 'add_recipe_display.php';
					break;
				}

				//Adds recipe to form
				$mealID = add_meal($name, $_SESSION['accountID']);

				for ($i = 0; $i < $numComponents; $i++) {
					add_component($mealID, $components['Ingredients'][$i], $components['Quantities'][$i], $components['Measurements'][$i]);
				}
				for ($i = 0; $i < $numSteps; $i++) {
					add_step(($i + 1), $steps[$i], $mealID);
				}
				
				$content = 'SUCCESS';
				$mes = 'Recipe creation successful!';
				include 'message.php';
				break;
			case 'Add Ingredient':
				for ($i = 0; $i < $numSteps; $i++) {
					$steps[$i] = filter_input(INPUT_POST, 'step'.$i, FILTER_SANITIZE_STRING);
				}
				//Get location of new form slot
				$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
				if ($id === NULL || $id === false) {
					$id = $numComponents;
				}
				$id -= 1;
				//Adds extra slot in component table at specified location
				foreach ($keys as $key) {
					$j = 0;
					for ($i = 0; $i < $numComponents + 1; $i++) {
						if ($i === $id) {
							$items[$j] = '';
							$j++;
						}
						if ($i !== $numComponents) {
							$items[$j] = filter_input(INPUT_POST, $key.$i, FILTER_SANITIZE_STRING);
							$j++;
						}
					}
					$components[$key] = $items;
				}
				include 'add_recipe_display.php';
				break;
			case 'Add Step':
				foreach ($keys as $key) {
					for ($i = 0; $i < $numComponents; $i++) {
						$items[$i] = filter_input(INPUT_POST, $key.$i, FILTER_SANITIZE_STRING);
					}
					$components[$key] = $items;
				}

				//Get location of new form slot
				$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
				if ($id === NULL || $id === false) {
					$id = $numSteps;
				}

				//Adds extra slot in steps portion at location specified
				$id -= 1;
				$j = 0;
				for ($i = 0; $i <= $numSteps; $i++) {
					if ($i === $id) {
							$steps[$j] = '';
							$j++;
						}
					if ($i !== $numSteps) {
						$steps[$j] = filter_input(INPUT_POST, 'step'.$i, FILTER_SANITIZE_STRING);
						$j++;
					}
				}
				include 'add_recipe_display.php';
				break;
			case 'Remove Ingredient':
				for ($i = 0; $i < $numSteps; $i++) {
					$steps[$i] = filter_input(INPUT_POST, 'step'.$i, FILTER_SANITIZE_STRING);
				}

				//Gets position of slot to be removed, ensures is valid
				$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
				if ($id === NULL || $id === false) {
					$id = $numComponents;
				}

				//Removes component slot at specified location
				$id -= 1;
				foreach ($keys as $key) {
					$j = 0;
					for ($i = 0; $i < $numComponents; $i++) {
						if ($i !== $id) {
							$items[$j] = filter_input(INPUT_POST, $key.$i, FILTER_SANITIZE_STRING);
							$j++;
						}
					}
					$components[$key] = $items;
				}
				include 'add_recipe_display.php';
				break;
			case 'Remove Step':
				foreach ($keys as $key) {
					for ($i = 0; $i < $numComponents; $i++) {
						$items[$i] = filter_input(INPUT_POST, $key.$i, FILTER_SANITIZE_STRING);
					}
					$components[$key] = $items;
				}

				//Gets step to be removes, ensures it exists
				$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
				if ($id === NULL || $id === false) {
					$id = $numSteps;
				}

				//Removes step indicated
				$id -= 1;
				$j = 0;
				for ($i = 0; $i < $numSteps; $i++) {
					if ($i !== $id) {
							$steps[$j] = filter_input(INPUT_POST, 'step'.$i, FILTER_SANITIZE_STRING);
							$j++;
						}
				}
				include 'add_recipe_display.php';
				break;
		}
        break;
	case 'edit':
		//Uses mealID to fill form with values based on the corresponding meal
		$mealID = filter_input(INPUT_POST, 'mealID', FILTER_VALIDATE_INT);

		//Gets name of meal
		$name = meal_by_id($mealID)['name'];

		//Gets all steps of meal and converts them for form
		$stepResult = get_steps($mealID);
		for ($i = 0; $i < count($stepResult); $i++) {
			$steps[$i] = $stepResult[$i]['description'];
		}

		//Gets all components of meal and converts them for form
		$comp = get_components($mealID);
		for ($i = 0; $i < count($comp); $i++) {
			$components['Quantities'][$i] = $comp[$i]['quantity'];
			$components['Measurements'][$i] = $comp[$i]['unit'];
			$components['Ingredients'][$i] = $comp[$i]['ingredient'];
		}
		include 'add_recipe_display.php';
		break;
    default:
		$content = 'ERROR';
        $mes = 'Invalid action request.';
		include 'message.php';
        break;
}
} ?>