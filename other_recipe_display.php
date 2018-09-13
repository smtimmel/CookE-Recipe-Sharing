<?php if (!isset($_SESSION)) {
	session_start();
}
//Ensures user is logged in
if (!empty($_SESSION)) { 
include './header.php'; ?>

    <main>

		<!--Variable dependent on user needs-->
        <h1><?php echo $_SESSION['page']; ?></h1>

		<?php include $_SESSION['table']; ?>

		<p><a href="main_page.php">Home</a></p>
		<p><a href="logout.php">Logout</a></p>
    </main>

    <?php include './footer.php'; 
} ?>