<?php
	if(!isset($_SESSION)) { session_start(); }

	include "../includes/functions.php";
		
	$login = $_POST["login"];
	$password = $_POST["password"];

	//All logins are stored in lowercase
	$login = strtolower($login);
	
	//Check to see if login already exists
	$rows = query("SELECT id FROM users WHERE email = '{$login}'");
	
	$login_error = 0;
	$exists_error = 0;
	$password_error = 0;
	
	//Check to see if Email and Password are VALID
	if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
		$login_error = 1;
	} elseif (mysql_num_rows($rows) > 0) {
		$exists_error = 1;
	}
	
	if (preg_match('/^[a-zA-Z0-9]{6,15}$/', $password) == 0) {
		$password_error = 1;
	}
?>
<?php if ($login_error == 1 || $exists_error == 1 || $password_error == 1) { ?>		
	<div id="whoops" data-role="page">
		<div data-role="header">
			<h1>Whoops!</h1>
		</div>
		<div data-role="content">
			<div class="block error">
				<div class="italic">We encountered some errors : </div>
				<br />
				<?php if ($login_error == 1) { ?>
					<div class="italic">&raquo; <span class="bold size_1">Email Address</span> is invalid.</div>
				<?php } elseif ($exists_error == 1) { ?>
					<div class="italic">&raquo; <span class="bold size_1">Email Address</span> is tied to another account.</div>				
				<?php } ?>
				<?php if ($password_error == 1) { ?>
					<div class="italic">&raquo; <span class="bold size_1">Password</span> is invalid.</div>
				<?php } ?>
				<br />
				<div class="italic">Please go <span class="bold">Back</span>, and try again.</div>
			</div>
		</div>
		<div data-role="footer">
		</div>
	</div>
<?php } else { ?>
	<?php
		//Create new user record
		$uid = uniqid();
		$password = md5($password);
		
		query("INSERT INTO users (id, email, password, created, last_seen) VALUES ('{$uid}', '{$login}', '{$password}', NOW(), NOW())");
		
		//Set SESSION variables
		$_SESSION["user_login"] = 1;
		$_SESSION["user_id"] = $uid;
	?>

	<div id="success" data-role="page">
		<div data-role="header" data-nobackbtn="true">
			<h1>Success!</h1>
		</div>
		<div data-role="content">
			<div class="block success">
				<div class="size_1 bold">Welcome!</div>
				<br />
				<div class="italic">Your account has been successfully created.</div>
			</div>
			<div class="spacer"></div>
			<a href="/account/main.php" rel="external" class="action" data-role="button" style="<?php bg("general/key"); ?>"><div class="label">Access Your Account</div></a>
		</div>
		<div data-role="footer">
		</div>
	</div>
<?php } ?>