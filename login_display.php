<?php include './header.php';?>

    <main>
        <h1>Login</h1>

		<!--Provides for form requesting login credentials-->
		<?php $action_val = 'login';
		$submit_val = 'Login';
		$labels = array('Username:', 'Password:');
		$names = array('username', 'password');
		include './basic_form.php'; ?>

		<p><a href="add_account.php">Create Account</a></p>
    </main>

    <?php include './footer.php'; ?>