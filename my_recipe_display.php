<?php if (!isset($_SESSION)) {
	session_start();
}
//Ensures user is logged in
if (!empty($_SESSION)) { 
include './header.php'; ?>

    <main>
		<h1>Welcome <?php echo $_SESSION['firstName']; ?>!</h1>

			<?php include './error_mes.php'; ?>

			<!--Provides form for completing a search-->
			<form action="main_page.php" method="post">
				<label>Search by:</label>
				<select name="search">
					<option value="Recipe">Recipe</option>
					<option value="Ingredient">Ingredient</option>
					<option value="User">User</option>
				</select><br><br>
				<input type="text" name="choice">
				<input type="submit" value="Search"><br>
			</form>

        <h1>My Recipes</h1>

		<!--displays the recipe tables-->
		<?php include './recipe_tables.php'; 
		//Gives extra options to admins
		if ($_SESSION['admin'] === 'y') {?>
			<p><a href="admin_account_manager.php">Account Manager</a></p>
			<p><a href="admin_search.php">Search Data</a></p>
		<?php } ?>

		<p><a href="add_recipe.php">Add Recipe</a></p>
		<p><a href="favorite.php">My Favorites</a></p>
		<p><a href="logout.php">Logout</a></p>
    </main>

    <?php include './footer.php'; 
} ?>