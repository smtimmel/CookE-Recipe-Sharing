<!--Acts as template for certain basic user forms-->
<?php include './error_mes.php'; ?>

<form action="" method="post">
	<input type="hidden" name="action" value="<?php echo $action_val; ?>">

	<!--Provides inputs for sepcified components-->
	<?php for ($i = 0; $i < count($labels); $i++) { ?>
		<label><?php echo $labels[$i]; ?></label><br>
		<input type="<?php if ($names[$i] === 'password') {
			echo 'password';
		} else {
			echo 'text';
		} ?>" name="<?php echo $names[$i]; ?>" value="<?php echo $active[$i]; ?>"><br>
	<?php } ?>

    <label>&nbsp;</label><br>
    <input type="submit" value="<?php echo $submit_val; ?>"><br>
</form>
		