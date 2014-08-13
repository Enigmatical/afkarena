<?php
	if(!isset($_SESSION)) { session_start(); }
	
	include "../includes/functions.php";
	
	$login = $_POST["login"];
	$password = $_POST["password"];
	
	//All logins are stored in lowercase
	$login = strtolower($login);
	$password = md5($password);
	
	//Check to see if login exists
	$results = query("SELECT id FROM users WHERE email = '$login' AND password = '$password'");
?>

<?php if (mysql_num_rows($results) == 0) { ?>
	<div id="whoops" data-role="page">
		<div data-role="header">
			<h1>Whoops!</h1>
		</div>
		<div data-role="content">
			<div class="block error">
				<div class="italic">We could not locate an account with those credentials.</div>
				<br />
				<div class="italic">Please go <span class="bold">Back</span>, and try again.</div>
			</div>
		</div>
		<div data-role="footer">
		</div>
	</div>
<?php } else { ?>
	<?php
		//Set SESSION variables
		$user = mysql_fetch_assoc($results);
		$_SESSION["user_id"] = $user["id"];
	?>
	
	<div id="success" data-role="page">
		<div data-role="header" data-nobackbtn="true">
			<h1>Success!</h1>
		</div>
		<div data-role="content">
			<div class="block success">
				<div class="size_1 bold">Welcome back!</div>
				<br />
				<div class="italic">You have successfully logged in.</div>
			</div>
			<div class="spacer"></div>
			<a href="/account/main.php" rel="external" class="action" data-role="button" style="<?php bg("general/key"); ?>"><div class="label">Access Your Account</div></a>
		</div>
		<div data-role="footer">
		</div>
	</div>
<?php } ?>