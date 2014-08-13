<?php
	include "../includes/functions.php";
?>

<!-- LOGIN: FORM -->
<div id="login" data-role="page">
	<div data-role="header">
		<h1>Login</h1>
	</div>
	<div data-role="content">
		<form id="login_form" method="post" action="/login/process.php">
			<h3>Email Address</h3>
			<input type="email" name="login" id="login" value="" maxlength="35" placeholder="you@example.com" />
			<h3>Password</h3>
			<input type="password" name="password" id="password" value="" maxlength="15" placeholder="6-15 alphanumeric characters" />
			<div class="spacer"></div>
			<a href="#" class="action" data-role="button" onclick="$('#login_form').submit();" style="<?php bg("general/key"); ?>"><div class="label">Login</div></a>
		</form>
	</div>
	<div data-role="footer">
	</div>
</div>