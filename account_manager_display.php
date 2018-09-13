<?php if (!isset($_SESSION)) {
	session_start();
}
//Ensures user has credentials for access
if (!empty($_SESSION) && $_SESSION['admin'] === 'y') { ?>
<table>
	<tr>
		<th>Username</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email</th>
		<th>&nbsp;</th>
	</tr>
	<?php foreach ($accounts as $account) { ?>
		<tr>
			<td><?php echo $account['username']; ?></td>
			<td><?php echo $account['firstName']; ?></td>
			<td><?php echo $account['lastName']; ?></td>
			<td><?php echo $account['email']; ?></td>
			<!--Only applies if user not admin-->
			<?php if ($account['admin'] === 'n') { ?>
				<td><form action="" method="post" style="display:inline">
					<input type="hidden" name="accountID" value="<?php echo $account['accountID']; ?>">
					<input type="hidden" name="action" value="delete">
					<input type="submit" value="Delete">
				</form>
				<form action="" method="post" style="display:inline">
					<input type="hidden" name="accountID" value="<?php echo $account['accountID']; ?>">
					<input type="hidden" name="action" value="admin">
					<input type="submit" value="Make Admin">
				</form></td>
			<?php } else { ?>
				<td>&nbsp;</td>
			<?php } ?>
		</tr>
	<?php } ?>
</table><br>	
<?php } ?>