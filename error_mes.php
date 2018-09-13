<!--Checks if error present, displays message if so-->
<?php if (!empty($error_message)) { ?>
	<p class="error"><?php echo htmlspecialchars($error_message); ?></p>
<?php } ?>
