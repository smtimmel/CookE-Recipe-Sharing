<?php if (!isset($_SESSION)) {
	session_start();
}
//Checks if user is logged in
if (!empty($_SESSION)) { 

//Checks if recipe tables need to be made, message of no recipes otherwise
if (empty($meals)) { ?>
	<h2>No recipes to display.</h2>
<?php } else {

	//For each meal display a table to the user
	foreach($meals as $meal) {?>
		<h2><?php echo $meal['name']; ?></h2>
		<b>Posted by <?php echo $meal['username']; ?></b>
				
		<table>
			<tr>
				<th>Quantity</th>
				<th>Ingredient</th>
			</tr>
			<!--Put each component in the table-->
			<?php for ($i = 0; $i < count($meal['components']); $i++) { ?>
				<tr>
					<td><?php echo $meal['components'][$i]['quantity'].' '.$meal['components'][$i]['unit']; ?></td>
					<td><?php echo $meal['components'][$i]['ingredient']; ?></td>
				</tr>
			<?php } ?>
		</table><br>
		<?php echo 'Favorited '.$meal['favorited'].' times'; 
		//Present favorite button to user unless already favorited
		if (!$meal['isFavorite']) {?>
			<form action="favorite.php" method="post">
				<input type="hidden" name="mealID" value="<?php echo $meal['mealID']; ?>">
				<input type="hidden" name="action" value="add">
				<input type="submit" value="Favorite">
			</form>
		<?php } ?><br><br>
		<!--Displays steps in order under table-->
		<?php for ($i = 0; $i < count($meal['steps']); $i++) { ?>
			<b>Step <?php echo $meal['steps'][$i]['stepNum'].' - '; ?></b><?php echo $meal['steps'][$i]['description']; ?><br>
		<?php } 
		//allows user to delete recipe if they created it
		if ($meal['accountID'] === $_SESSION['accountID']) {?>
		<form action="main_page.php" method="post" style="display:inline">
			<input type="hidden" name="mealID" value="<?php echo $meal['mealID']; ?>">
			<input type="hidden" name="search" value="delete">
			<input type="submit" value="Delete">
		</form>
		<?php } ?>
		<form action="add_recipe.php" method="post" style="display:inline">
			<input type="hidden" name="mealID" value="<?php echo $meal['mealID']; ?>">
			<input type="hidden" name="action" value="edit">
			<input type="submit" value="Use Template">
		</form>
		<hr>
<?php }}} ?>