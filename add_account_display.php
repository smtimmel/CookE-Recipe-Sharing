<?php include './header.php'; ?>

    <main>
        <h1>Create Account</h1>

		<!--form created using basic form template and asking for account values-->
		<?php $action_val = 'add';
		$submit_val = 'Create Account';
		$labels = array('Username:', 'Password:', 'First Name:', 'Last Name:', 'Email:');
		$names = array('username', 'password', 'first', 'last', 'email');
		include './basic_form.php'; ?>

        <p><a href="index.php">Login Page</a></p>
    </main>

    <?php include './footer.php'; ?>