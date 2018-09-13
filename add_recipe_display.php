<?php if (!isset($_SESSION)) {
	session_start();
}
if (!empty($_SESSION)) { 
include './header.php'; ?>

    <main>
        <h1>Add Recipe</h1>

		<!--Provides user error in case of unfilled or invalid fields-->
		<?php include './error_mes.php'; 
		$tasks = array('Add Recipe', 'Add Ingredient', 'Add Step', 'Remove Ingredient', 'Remove Step'); ?>
		
		<form action="" method="post">
			<input type="hidden" name="action" value="add">
			<!--Gets data sizes in case form resize needed-->
			<input type="hidden" name="numSteps" value="<?php echo count($steps); ?>">
			<input type="hidden" name="numComponents" value="<?php echo count($components['Quantities']); ?>">

			<label>Recipe Name:</label><br>
			<input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"><br>

			<br>

				<table>
				<tr>
					<th>Quantity</th>
					<th>Measurement</th>
					<th>Ingredient</th>
				</tr>
				<?php for ($i = 0; $i < count($components['Quantities']); $i++) { ?>
					<tr>
						<!--Puts any previously determined values in form components table-->
						<?php foreach ($components as $key => $values) {  ?>
							<td><input type="text" name="<?php echo $key.$i ?>"
								value="<?php echo htmlspecialchars($values[$i]); ?>"></td>
						<?php } ?>
					</tr>
				<?php } ?>
			</table><br>
			<!--Puts any previously determined values in form steps section-->
			<?php for ($i = 0; $i < count($steps); $i++) { ?>
				<label>Step <?php echo ($i + 1) ?>:</label>
				<input type="text" style="width: 500px;" name="<?php echo 'step'.$i ?>"
					value="<?php echo htmlspecialchars($steps[$i]); ?>"><br><br>
			<?php } ?>
			<!--Allow user to create recipe or edit form with location specifier provided in edit needed-->
			<label>Task:</label><br>
            <select name="task">
            <?php foreach ($tasks as $task) : ?>
                <option value="<?php echo $task; ?>">
                    <?php echo $task; ?>
                </option>
            <?php endforeach; ?>
            </select><br>
			<label>Item Number:</label><br>
			<input type="text" name="id"><br>
			<label>&nbsp;</label><br>
			<input type="submit" value="Perform Task"><br>
		</form><br>

        <p><a href="main_page.php">Go Back</a></p>
    </main>

    <?php include './footer.php'; 
} ?>