<?php if (!isset($_SESSION)) {
	session_start();
}
//Ensures user has credentials to access
if (!empty($_SESSION) && $_SESSION['admin'] === 'y') { 
if (empty($searches)) { ?>
	<h2>No searches to display.</h2>
<?php } else { ?>

	<!--Creates search data table-->		
	<table>
		<tr>
			<th>Search</th>
			<th>Category</th>
			<th>Times Searched</th>
		</tr>
		<?php foreach ($searches as $search) { ?>
			<tr>
				<td><?php echo $search['input']; ?></td>
				<td><?php echo $search['category']; ?></td>
				<td><?php echo $search['searchAmt']; ?></td>
			</tr>
		<?php } ?>
	</table><br>	
<?php }} ?>